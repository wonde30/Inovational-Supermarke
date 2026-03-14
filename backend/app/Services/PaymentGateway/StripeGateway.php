<?php

namespace App\Services\PaymentGateway;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Exception\ApiErrorException;

class StripeGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Process payment through Stripe
     */
    public function processPayment(array $paymentData): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $paymentData['amount'] * 100, // Convert to cents
                'currency' => $paymentData['currency'] ?? 'usd',
                'payment_method' => $paymentData['payment_method_id'],
                'confirm' => true,
                'description' => $paymentData['description'] ?? 'Order payment',
                'metadata' => [
                    'order_id' => $paymentData['order_id'] ?? null,
                    'customer_email' => $paymentData['customer_email'] ?? null,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            return [
                'success' => $paymentIntent->status === 'succeeded',
                'transaction_id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'payment_method' => $paymentIntent->payment_method,
                'created_at' => date('Y-m-d H:i:s', $paymentIntent->created),
                'gateway' => 'stripe',
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getError()->code ?? 'unknown',
                'gateway' => 'stripe',
            ];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $transactionId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($transactionId);

            return [
                'success' => true,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'verified' => $paymentIntent->status === 'succeeded',
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund payment
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array
    {
        try {
            $refundData = ['payment_intent' => $transactionId];
            
            if ($amount !== null) {
                $refundData['amount'] = $amount * 100; // Convert to cents
            }

            $refund = Refund::create($refundData);

            return [
                'success' => $refund->status === 'succeeded',
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100,
                'status' => $refund->status,
                'gateway' => 'stripe',
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create payment intent (for client-side confirmation)
     */
    public function createPaymentIntent(array $data): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $data['amount'] * 100,
                'currency' => $data['currency'] ?? 'usd',
                'metadata' => $data['metadata'] ?? [],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
