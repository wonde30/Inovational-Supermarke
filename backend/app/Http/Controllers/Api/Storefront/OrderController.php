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

class OrderController extends Controller
{
    use ApiResponse;

    protected ChapaPaymentService $chapaPaymentService;

    public function __construct(ChapaPaymentService $chapaPaymentService)
    {
        $this->chapaPaymentService = $chapaPaymentService;
    }

    /**
     * Get all orders for the authenticated customer
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        // Find customer by user email
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            // Create customer record if not exists
            $customer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ]);
        }

        // Get orders for this customer with sale relationship
        $orders = Order::where('customer_id', $customer->id)
            ->with(['orderItems.product', 'sale'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return $this->paginated($orders);
    }

    /**
     * Get a specific order
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return $this->error('Customer not found', 404);
        }

        $order = Order::where('id', $id)
            ->where('customer_id', $customer->id)
            ->with(['orderItems.product', 'sale'])
            ->first();

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        return $this->success($order);
    }

    /**
     * Create a new order
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Ensure user is authenticated
        if (!$user) {
            return $this->error('Please login to place an order', 401);
        }
        
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'address' => 'nullable|string',
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

        $order = DB::transaction(function () use ($validated, $user) {
            // Find or create customer
            $customer = Customer::where('email', $user->email)->first();
            
            if (!$customer) {
                $customer = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ]);
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
            
            // Ensure uniqueness
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
                'status' => 'pending',
                'notes' => $validated['address'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    ...$item,
                ]);
            }

            return $order;
        });

        // Load order relationships
        $order->load('orderItems.product', 'customer');

        // Initialize payment if payment method is chapa
        $paymentData = null;
        if (isset($validated['payment_method']) && strtolower($validated['payment_method']) === 'chapa') {
            try {
                $paymentResult = $this->chapaPaymentService->initializePayment($order);
                
                if ($paymentResult['success']) {
                    $paymentData = [
                        'transaction_id' => $paymentResult['transaction_id'],
                        'checkout_url' => $paymentResult['checkout_url'],
                        'status' => 'pending',
                    ];
                } else {
                    Log::warning('Chapa payment initialization failed for order', [
                        'order_id' => $order->id,
                        'error' => $paymentResult['error'],
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Exception during Chapa payment initialization', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $this->success([
            'order' => $order,
            'payment' => $paymentData,
        ], 'Order placed successfully', 201);
    }

    /**
     * Cancel an order (only if pending)
     */
    public function cancel(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return $this->error('Customer not found', 404);
        }

        $order = Order::where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        if ($order->status !== 'pending') {
            return $this->error('Only pending orders can be cancelled', 422);
        }

        DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('quantity', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);
        });

        return $this->success($order->fresh(), 'Order cancelled successfully');
    }
}
