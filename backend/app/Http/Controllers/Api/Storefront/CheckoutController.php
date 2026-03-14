<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ChapaPaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    use ApiResponse;

    protected ChapaPaymentService $chapaPaymentService;

    public function __construct(ChapaPaymentService $chapaPaymentService)
    {
        $this->chapaPaymentService = $chapaPaymentService;
    }

    /**
     * Process checkout and create order with payment
     * 
     * POST /api/v1/storefront/checkout
     */
    public function process(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Please login to checkout', 401);
        }
        
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:chapa,paypal,mobile_banking,bank_transfer',
            'delivery_method' => 'nullable|string|in:self_pickup,standard_delivery,express_delivery,dhl,fedex',
            'shipping_address' => 'nullable|string',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
        ], [
            'phone.required' => 'Phone number is required for payment',
            'phone.regex' => 'Please enter a valid phone number (e.g., +251911234567 or 0911234567)',
        ]);

        // Validate stock availability
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                return $this->error("Product not found", 422);
            }
            if ($product->quantity < $item['quantity']) {
                return $this->error("Insufficient stock for {$product->name}. Available: {$product->quantity}", 422);
            }
        }

        try {
            $result = DB::transaction(function () use ($validated, $user) {
                // Find or create customer
                $customer = Customer::where('email', $user->email)->first();
                
                // Format phone number for Chapa (ensure it starts with +251)
                $phone = $this->formatPhoneNumber($validated['phone']);
                
                // Validate email format
                $email = filter_var($user->email, FILTER_VALIDATE_EMAIL) 
                    ? $user->email 
                    : 'customer@smartsupermarket.com';
                
                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $user->name,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $validated['shipping_address'] ?? '',
                    ]);
                } else {
                    // Update customer info if provided
                    $customer->email = $email;
                    $customer->phone = $phone;
                    if (isset($validated['shipping_address'])) {
                        $customer->address = $validated['shipping_address'];
                    }
                    $customer->save();
                }

                $subtotal = 0;
                $items = [];

                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);
                    $lineTotal = $product->price * $item['quantity'];
                    
                    $items[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->price,
                        'total' => $lineTotal,
                    ];

                    $subtotal += $lineTotal;
                    
                    // Deduct stock
                    $product->decrement('quantity', $item['quantity']);
                }

                $taxRate = 15; // 15% VAT for Ethiopia
                $tax = ($subtotal * $taxRate) / 100;
                $total = $subtotal + $tax;

                // Generate unique order number
                $orderNumber = Order::generateOrderNumber();
                
                while (Order::where('order_number', $orderNumber)->exists()) {
                    $orderNumber = Order::generateOrderNumber();
                }

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => $orderNumber,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => 0,
                    'total' => $total,
                    'status' => 'processing',  // Always processing for online payments
                    'payment_status' => 'pending',
                    'notes' => ($validated['shipping_address'] ?? null) . 
                               ($validated['delivery_method'] ? ' | Delivery: ' . $validated['delivery_method'] : ''),
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        ...$item,
                    ]);
                }

                return $order->load('orderItems.product', 'customer');
            });

            // Initialize payment based on method
            $paymentData = null;
            
            if (strtolower($validated['payment_method']) === 'chapa') {
                $paymentResult = $this->chapaPaymentService->initializePayment($result);
                
                if ($paymentResult['success']) {
                    $paymentData = [
                        'gateway' => 'chapa',
                        'transaction_id' => $paymentResult['transaction_id'],
                        'checkout_url' => $paymentResult['checkout_url'],
                        'status' => 'pending',
                    ];
                    
                    Log::info('Chapa payment initialized successfully', [
                        'order_id' => $result->id,
                        'transaction_id' => $paymentResult['transaction_id'],
                    ]);
                } else {
                    Log::error('Chapa payment initialization failed', [
                        'order_id' => $result->id,
                        'error' => $paymentResult['error'],
                    ]);
                    
                    // Format error message properly
                    $errorMessage = 'Order created but payment initialization failed';
                    if (isset($paymentResult['error'])) {
                        if (is_array($paymentResult['error'])) {
                            $errorMessage .= ': ' . json_encode($paymentResult['error']);
                        } else {
                            $errorMessage .= ': ' . $paymentResult['error'];
                        }
                    }
                    
                    return $this->error(
                        $errorMessage,
                        422,
                        ['order' => $result]
                    );
                }
            } else {
                // For other payment methods (paypal, mobile_banking, bank_transfer)
                $paymentData = [
                    'gateway' => $validated['payment_method'],
                    'status' => 'pending',
                    'message' => 'Payment will be processed through ' . ucfirst(str_replace('_', ' ', $validated['payment_method'])),
                ];
            }

            return $this->success([
                'order' => $result,
                'payment' => $paymentData,
            ], 'Checkout successful', 201);

        } catch (\Exception $e) {
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return $this->serverError('Checkout failed. Please try again.');
        }
    }

    /**
     * Initialize payment for existing order
     * 
     * POST /api/v1/storefront/orders/{order}/pay
     */
    public function initializePayment(Request $request, $orderId): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|in:chapa',
        ]);

        try {
            // Find order
            $customer = Customer::where('email', $user->email)->first();
            
            if (!$customer) {
                return $this->error('Customer not found', 404);
            }

            $order = Order::where('id', $orderId)
                ->where('customer_id', $customer->id)
                ->with(['orderItems.product', 'customer'])
                ->first();

            if (!$order) {
                return $this->error('Order not found', 404);
            }

            if ($order->status === 'completed') {
                return $this->error('Order already completed', 422);
            }

            // Initialize Chapa payment
            $paymentResult = $this->chapaPaymentService->initializePayment($order);
            
            if ($paymentResult['success']) {
                return $this->success([
                    'transaction_id' => $paymentResult['transaction_id'],
                    'checkout_url' => $paymentResult['checkout_url'],
                    'status' => 'pending',
                ], 'Payment initialized successfully');
            }
            
            return $this->error($paymentResult['error'] ?? 'Payment initialization failed', 422);

        } catch (\Exception $e) {
            Log::error('Payment initialization failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            
            return $this->serverError('Payment initialization failed');
        }
    }

    /**
     * Verify payment status
     * 
     * GET /api/v1/storefront/orders/{order}/payment-status
     */
    public function checkPaymentStatus(Request $request, $orderId): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $customer = Customer::where('email', $user->email)->first();
            
            if (!$customer) {
                return $this->error('Customer not found', 404);
            }

            $order = Order::where('id', $orderId)
                ->where('customer_id', $customer->id)
                ->with(['payments' => function ($query) {
                    $query->latest();
                }])
                ->first();

            if (!$order) {
                return $this->error('Order not found', 404);
            }

            $latestPayment = $order->payments->first();

            // If payment exists and is pending, verify with Chapa
            if ($latestPayment && $latestPayment->status === 'pending') {
                $verifyResult = $this->chapaPaymentService->verifyPaymentWithGateway($latestPayment->transaction_id);
                
                if ($verifyResult['success'] && $verifyResult['verified']) {
                    // Payment is successful, update payment and order
                    $latestPayment->update([
                        'status' => 'completed',
                        'verified_at' => now(),
                        'payment_method' => $verifyResult['payment_method'] ?? 'chapa',
                    ]);
                    
                    // Complete order and create sale
                    $this->chapaPaymentService->completeOrder($order, $verifyResult['payment_method'] ?? 'chapa');
                    
                    // Reload order to get updated status
                    $order->refresh();
                }
            }

            return $this->success([
                'order_status' => $order->status,
                'payment_status' => $order->payment_status ?? 'pending',
                'payment' => $latestPayment ? [
                    'transaction_id' => $latestPayment->transaction_id,
                    'status' => $latestPayment->status,
                    'amount' => $latestPayment->amount,
                    'gateway' => $latestPayment->gateway,
                    'verified_at' => $latestPayment->verified_at,
                ] : null,
                'redirect_to_orders' => $order->status === 'completed',
            ], 'Payment status retrieved');

        } catch (\Exception $e) {
            Log::error('Failed to check payment status', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            
            return $this->serverError('Failed to check payment status');
        }
    }

    /**
     * Format phone number for Chapa API
     * Ensures phone number is in international format (+251...)
     * 
     * @param string $phone
     * @return string
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all spaces, dashes, and parentheses
        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        
        // If phone starts with 0, replace with +251
        if (substr($phone, 0, 1) === '0') {
            $phone = '+251' . substr($phone, 1);
        }
        
        // If phone doesn't start with +, add +251
        if (substr($phone, 0, 1) !== '+') {
            // Check if it starts with 251
            if (substr($phone, 0, 3) === '251') {
                $phone = '+' . $phone;
            } else {
                $phone = '+251' . $phone;
            }
        }
        
        return $phone;
    }
}
