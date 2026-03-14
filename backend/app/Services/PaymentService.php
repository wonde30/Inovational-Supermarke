<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentGateway\PaymentGatewayFactory;
use App\Exceptions\PaymentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Initiate payment for an order
     */
    public function initiatePayment(Order $order, string $paymentMethod, ?array $paymentData = []): Payment
    {
        // Check for duplicate payment
        $existingPayment = Payment::where('order_id', $order->id)
            ->where('status', 'completed')
            ->first();

        if ($existingPayment) {
            throw new \Exception('Payment already completed for this order');
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'payment_method' => $paymentMethod,
            'amount' => $order->total_amount,
            'status' => 'pending',
            'transaction_id' => $this->generateTransactionId(),
            'reference_number' => $paymentData['reference'] ?? null,
        ]);

        return $payment;
    }

    /**
     * Process payment
     */
    public function processPayment(Payment $payment, array $paymentData = []): Payment
    {
        return DB::transaction(function () use ($payment, $paymentData) {
            try {
                // Update status to processing
                $payment->update(['status' => 'processing']);

                // Process based on payment method
                $result = match ($payment->payment_method) {
                    'cash' => $this->processCashPayment($payment, $paymentData),
                    'card' => $this->processCardPayment($payment, $paymentData),
                    'mobile_money' => $this->processMobileMoneyPayment($payment, $paymentData),
                    'wallet' => $this->processWalletPayment($payment, $paymentData),
                    default => throw new \Exception('Unsupported payment method'),
                };

                if ($result['success']) {
                    $payment->markAsCompleted();
                    $payment->update(['gateway_response' => $result]);
                    
                    // Update order status
                    $payment->order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);
                } else {
                    $payment->markAsFailed($result['message'] ?? 'Payment failed');
                }

                return $payment->fresh();
            } catch (\Exception $e) {
                $payment->markAsFailed($e->getMessage());
                throw $e;
            }
        });
    }

    /**
     * Process cash payment
     */
    private function processCashPayment(Payment $payment, array $data): array
    {
        // Cash payments are immediately successful
        return [
            'success' => true,
            'method' => 'cash',
            'amount_received' => $data['amount_received'] ?? $payment->amount,
            'change' => ($data['amount_received'] ?? $payment->amount) - $payment->amount,
            'processed_at' => now()->toISOString(),
        ];
    }

    /**
     * Process card payment via payment gateway
     */
    private function processCardPayment(Payment $payment, array $data): array
    {
        try {
            $gateway = $data['gateway'] ?? 'stripe';
            $paymentGateway = PaymentGatewayFactory::create($gateway);

            $result = $paymentGateway->processPayment([
                'amount' => $payment->amount,
                'currency' => $data['currency'] ?? 'USD',
                'payment_method_id' => $data['payment_method_id'] ?? null,
                'order_id' => $payment->order_id,
                'customer_email' => $payment->order->customer->email ?? null,
                'description' => "Payment for Order #{$payment->order->order_number}",
            ]);

            if (!$result['success']) {
                throw new PaymentException($result['error'] ?? 'Card payment failed', 0, null, $result);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Card payment failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'method' => 'card',
            ];
        }
    }

    /**
     * Process mobile money payment via Chappa (Ethiopian payment gateway)
     */
    private function processMobileMoneyPayment(Payment $payment, array $data): array
    {
        try {
            $paymentGateway = PaymentGatewayFactory::create('chappa');

            $result = $paymentGateway->processPayment([
                'amount' => $payment->amount,
                'currency' => 'ETB',
                'customer_email' => $payment->order->customer->email ?? 'customer@example.com',
                'customer_name' => $payment->order->customer->name ?? 'Customer',
                'phone_number' => $data['phone_number'] ?? '',
                'reference' => $payment->transaction_id,
                'description' => "Payment for Order #{$payment->order->order_number}",
                'callback_url' => config('app.url') . '/api/v1/payments/callback',
                'return_url' => config('app.url') . '/orders/' . $payment->order->id,
            ]);

            if (!$result['success']) {
                throw new PaymentException($result['error'] ?? 'Mobile money payment failed', 0, null, $result);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Mobile money payment failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'method' => 'mobile_money',
            ];
        }
    }

    /**
     * Process wallet payment
     */
    private function processWalletPayment(Payment $payment, array $data): array
    {
        // TODO: Integrate with digital wallet
        // For now, simulate successful payment
        
        return [
            'success' => true,
            'method' => 'wallet',
            'wallet_id' => $data['wallet_id'] ?? null,
            'balance_after' => $data['balance_after'] ?? 0,
            'processed_at' => now()->toISOString(),
        ];
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $transactionId): ?Payment
    {
        return Payment::where('transaction_id', $transactionId)->first();
    }

    /**
     * Refund payment
     */
    public function refundPayment(Payment $payment, float $amount = null): Payment
    {
        if ($payment->status !== 'completed') {
            throw new \Exception('Can only refund completed payments');
        }

        $refundAmount = $amount ?? $payment->amount;

        if ($refundAmount > $payment->amount) {
            throw new \Exception('Refund amount cannot exceed payment amount');
        }

        return DB::transaction(function () use ($payment, $refundAmount) {
            // Create refund record (could be a separate table)
            $payment->update([
                'status' => 'refunded',
                'gateway_response' => array_merge(
                    $payment->gateway_response ?? [],
                    [
                        'refunded' => true,
                        'refund_amount' => $refundAmount,
                        'refunded_at' => now()->toISOString(),
                    ]
                ),
            ]);

            // Update order status
            $payment->order->update([
                'payment_status' => 'refunded',
                'status' => 'cancelled',
            ]);

            // Restore inventory
            foreach ($payment->order->orderItems as $item) {
                $item->product->increment('quantity', $item->quantity);
            }

            return $payment->fresh();
        });
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId(): string
    {
        return 'TXN-' . strtoupper(Str::random(12)) . '-' . time();
    }
}
