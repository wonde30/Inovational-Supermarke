<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentGateway\ChappaGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * ChapaPaymentService - Handles payment processing through Chapa gateway
 * 
 * This service provides a higher-level interface for payment operations
 * specific to the admin dashboard analytics feature, including:
 * - Payment initialization with order tracking
 * - Webhook handling and verification
 * - Order status updates
 * - Payment expiration management
 */
class ChapaPaymentService
{
    private ChappaGateway $gateway;

    public function __construct(ChappaGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Initialize payment for order
     * 
     * Creates a payment transaction with Chapa and returns checkout URL
     * for customer to complete payment.
     * 
     * @param Order $order The order to create payment for
     * @return array ['success' => bool, 'checkout_url' => string|null, 'transaction_id' => string|null, 'error' => string|null]
     */
    public function initializePayment(Order $order): array
    {
        try {
            // Validate order
            if ($order->isCompleted()) {
                return [
                    'success' => false,
                    'checkout_url' => null,
                    'transaction_id' => null,
                    'error' => 'Order already completed',
                ];
            }

            // Check if payment already exists for this order
            $existingPayment = $order->payments()
                ->whereIn('status', ['pending', 'completed'])
                ->first();

            if ($existingPayment) {
                return [
                    'success' => false,
                    'checkout_url' => null,
                    'transaction_id' => null,
                    'error' => 'Payment already exists for this order',
                ];
            }

            // Load customer relationship if not loaded
            if (!$order->relationLoaded('customer')) {
                $order->load('customer');
            }

            // Prepare payment data
            $paymentData = [
                'amount' => $order->total,
                'currency' => 'ETB',
                'customer_email' => $order->customer->email ?? 'customer@example.com',
                'customer_name' => $order->customer->name ?? 'Customer',
                'phone_number' => $order->customer->phone ?? '',
                'reference' => $order->order_number,
                'callback_url' => config('app.url') . '/api/v1/payments/webhook/chapa',
                'return_url' => config('app.frontend_url', config('app.url')) . '/payment/callback?order_id=' . $order->id,
                'description' => "Payment for order {$order->order_number}",
            ];
            
            // Validate email format before sending to Chapa
            if (!filter_var($paymentData['customer_email'], FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invalid customer email, using default', [
                    'order_id' => $order->id,
                    'invalid_email' => $paymentData['customer_email'],
                ]);
                $paymentData['customer_email'] = 'customer@smartsupermarket.com';
            }

            // Process payment through gateway
            $result = $this->gateway->processPayment($paymentData);

            if ($result['success']) {
                // Create payment record
                // Note: user_id should be the authenticated user processing the payment
                // For now, we'll use the customer_id as a fallback
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id() ?? $order->customer_id,
                    'transaction_id' => $result['transaction_id'],
                    'gateway' => 'chapa',
                    'amount' => $order->total,
                    'currency' => 'ETB',
                    'status' => 'pending',
                    'checkout_url' => $result['checkout_url'],
                    'expires_at' => now()->addMinutes(30),
                ]);

                return [
                    'success' => true,
                    'checkout_url' => $result['checkout_url'],
                    'transaction_id' => $result['transaction_id'],
                    'error' => null,
                ];
            }

            // Payment initialization failed
            Log::error('Chapa payment initialization failed', [
                'order_id' => $order->id,
                'error' => $result['error'] ?? 'Unknown error',
            ]);

            return [
                'success' => false,
                'checkout_url' => null,
                'transaction_id' => null,
                'error' => $result['error'] ?? 'Payment initialization failed',
            ];

        } catch (Exception $e) {
            Log::error('Exception during payment initialization', [
                'order_id' => $order->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'checkout_url' => null,
                'transaction_id' => null,
                'error' => 'An error occurred while initializing payment. Please try again.',
            ];
        }
    }

    /**
     * Handle webhook notification from Chapa
     * 
     * Processes incoming webhook, verifies signature, and updates order status
     * 
     * @param array $payload Webhook payload from Chapa
     * @param string $signature Webhook signature for verification
     * @return array ['success' => bool, 'message' => string]
     */
    public function handleWebhook(array $payload, string $signature): array
    {
        try {
            // Verify webhook signature
            if (!$this->verifySignature($payload, $signature)) {
                Log::warning('Invalid webhook signature received', [
                    'payload' => $payload,
                ]);

                return [
                    'success' => false,
                    'message' => 'Invalid signature',
                ];
            }

            // Extract transaction reference
            $transactionId = $payload['tx_ref'] ?? null;

            if (!$transactionId) {
                Log::error('Webhook missing transaction reference', [
                    'payload' => $payload,
                ]);

                return [
                    'success' => false,
                    'message' => 'Missing transaction reference',
                ];
            }

            // Find payment record
            $payment = Payment::where('transaction_id', $transactionId)->first();

            if (!$payment) {
                Log::error('Payment not found for webhook', [
                    'transaction_id' => $transactionId,
                ]);

                return [
                    'success' => false,
                    'message' => 'Payment not found',
                ];
            }

            // Check for duplicate webhook (idempotent handling)
            if ($payment->status === 'completed') {
                Log::info('Duplicate webhook received for completed payment', [
                    'transaction_id' => $transactionId,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment already processed',
                ];
            }

            // Update payment record
            $payment->update([
                'status' => $payload['status'] === 'success' ? 'completed' : 'failed',
                'payment_method' => $payload['payment_method'] ?? null,
                'webhook_data' => $payload,
                'verified_at' => now(),
            ]);

            // Update order status if payment successful
            if ($payload['status'] === 'success') {
                // Complete the order and create sale record
                $this->completeOrderWithSale($payment->order, $payload['payment_method'] ?? 'chapa');

                Log::info('Payment completed successfully', [
                    'transaction_id' => $transactionId,
                    'order_id' => $payment->order_id,
                ]);
            } else {
                Log::warning('Payment failed', [
                    'transaction_id' => $transactionId,
                    'order_id' => $payment->order_id,
                    'status' => $payload['status'],
                ]);
            }

            return [
                'success' => true,
                'message' => 'Webhook processed successfully',
            ];

        } catch (Exception $e) {
            Log::error('Exception during webhook processing', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Error processing webhook',
            ];
        }
    }

    /**
     * Verify webhook signature using HMAC-SHA256
     * 
     * @param array $payload Webhook payload
     * @param string $signature Provided signature
     * @return bool True if signature is valid
     */
    protected function verifySignature(array $payload, string $signature): bool
    {
        $webhookSecret = config('services.chappa.webhook_secret');

        if (!$webhookSecret) {
            Log::error('Webhook secret not configured');
            return false;
        }

        // Compute expected signature
        $computedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);

        // Compare signatures (timing-safe comparison)
        return hash_equals($computedSignature, $signature);
    }

    /**
     * Complete order and create sale record after successful payment
     * 
     * @param Order $order Order to complete
     * @param string $paymentMethod Payment method used
     * @return void
     */
    protected function completeOrderWithSale(Order $order, string $paymentMethod): void
    {
        DB::transaction(function () use ($order, $paymentMethod) {
            // Check if order is already completed
            if ($order->status === 'completed') {
                Log::info('Order already completed, skipping', [
                    'order_id' => $order->id,
                ]);
                return;
            }

            // Create sale record from order
            $sale = $this->createSaleFromOrder($order, $paymentMethod);
            
            // Update order status and payment status - mark as completed and paid
            $order->update([
                'status' => 'completed',
                'payment_status' => 'paid',
                'sale_id' => $sale->id,
            ]);

            Log::info('Order completed and sale created', [
                'order_id' => $order->id,
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
                'payment_status' => 'paid',
            ]);
        });
    }

    /**
     * Public method to complete order (called from controller)
     * 
     * @param Order $order Order to complete
     * @param string $paymentMethod Payment method used
     * @return void
     */
    public function completeOrder(Order $order, string $paymentMethod): void
    {
        $this->completeOrderWithSale($order, $paymentMethod);
    }

    /**
     * Verify payment with Chapa gateway
     * 
     * @param string $transactionId Transaction ID to verify
     * @return array ['success' => bool, 'verified' => bool, 'payment_method' => string|null]
     */
    public function verifyPaymentWithGateway(string $transactionId): array
    {
        try {
            $result = $this->gateway->verifyPayment($transactionId);
            
            if ($result['success'] && isset($result['verified']) && $result['verified']) {
                return [
                    'success' => true,
                    'verified' => true,
                    'payment_method' => $result['payment_method'] ?? 'chapa',
                    'amount' => $result['amount'] ?? null,
                    'currency' => $result['currency'] ?? 'ETB',
                ];
            }
            
            return [
                'success' => true,
                'verified' => false,
                'payment_method' => null,
            ];
            
        } catch (Exception $e) {
            Log::error('Failed to verify payment with gateway', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);
            
            return [
                'success' => false,
                'verified' => false,
                'payment_method' => null,
            ];
        }
    }

    /**
     * Create a Sale record from a completed Order
     * 
     * @param Order $order Order to create sale from
     * @param string $paymentMethod Payment method used
     * @return \App\Models\Sale
     */
    protected function createSaleFromOrder(Order $order, string $paymentMethod): \App\Models\Sale
    {
        // Generate unique invoice number
        $lastSale = \App\Models\Sale::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        $nextNumber = $lastSale ? ((int) substr($lastSale->invoice_number, -4)) + 1 : 1;
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Ensure uniqueness
        while (\App\Models\Sale::where('invoice_number', $invoiceNumber)->exists()) {
            $nextNumber++;
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        // Create sale record
        // For online orders, user_id is null since no staff processed it
        $sale = \App\Models\Sale::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => null, // Online orders have no staff user
            'subtotal' => $order->subtotal,
            'tax' => $order->tax,
            'discount' => $order->discount,
            'total' => $order->total,
            'payment_method' => $paymentMethod,
            'payment_status' => 'paid',
            'status' => 'completed',
            'customer_name' => $order->customer->name ?? null,
            'notes' => "From Order #{$order->order_number} - Paid via {$paymentMethod}",
        ]);

        // Create sale items from order items
        foreach ($order->orderItems as $orderItem) {
            \App\Models\SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $orderItem->product_id,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
                'total' => $orderItem->total,
            ]);
        }

        // Log the sale creation
        \App\Models\AuditLog::log(
            'create_sale_from_order',
            'Sale',
            $sale->id,
            null,
            ['order_id' => $order->id, 'invoice_number' => $invoiceNumber],
            "Sale created from Order #{$order->order_number} via Chapa payment"
        );

        return $sale;
    }

    /**
     * Mark payment as expired
     * 
     * Called by scheduled job to expire payments older than 30 minutes
     * 
     * @param string $transactionId Transaction ID to expire
     * @return void
     */
    public function markPaymentExpired(string $transactionId): void
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)
                ->where('status', 'pending')
                ->first();

            if ($payment && $payment->expires_at && $payment->expires_at->isPast()) {
                $payment->update(['status' => 'expired']);

                Log::info('Payment marked as expired', [
                    'transaction_id' => $transactionId,
                    'order_id' => $payment->order_id,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error marking payment as expired', [
                'transaction_id' => $transactionId,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
