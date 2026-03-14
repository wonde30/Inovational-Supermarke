<?php

namespace App\Services\PaymentGateway;

use Illuminate\Support\Facades\Http;

class PayPalGateway implements PaymentGatewayInterface
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.paypal.mode') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
        
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
    }

    /**
     * Get access token
     */
    private function getAccessToken(): ?string
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        return null;
    }

    /**
     * Process payment through PayPal
     */
    public function processPayment(array $paymentData): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'error' => 'Failed to authenticate with PayPal',
                'gateway' => 'paypal',
            ];
        }

        try {
            // Create order
            $response = Http::withToken($token)
                ->post("{$this->baseUrl}/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'amount' => [
                            'currency_code' => $paymentData['currency'] ?? 'USD',
                            'value' => number_format($paymentData['amount'], 2, '.', ''),
                        ],
                        'description' => $paymentData['description'] ?? 'Order payment',
                    ]],
                ]);

            if ($response->successful()) {
                $order = $response->json();
                
                return [
                    'success' => true,
                    'transaction_id' => $order['id'],
                    'status' => $order['status'],
                    'approval_url' => $order['links'][1]['href'] ?? null,
                    'gateway' => 'paypal',
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message') ?? 'Payment failed',
                'gateway' => 'paypal',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'gateway' => 'paypal',
            ];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $transactionId): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'error' => 'Failed to authenticate with PayPal',
            ];
        }

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/v2/checkout/orders/{$transactionId}");

        if ($response->successful()) {
            $order = $response->json();
            
            return [
                'success' => true,
                'status' => $order['status'],
                'verified' => $order['status'] === 'COMPLETED',
            ];
        }

        return [
            'success' => false,
            'error' => 'Failed to verify payment',
        ];
    }

    /**
     * Refund payment
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'error' => 'Failed to authenticate with PayPal',
            ];
        }

        $refundData = [];
        if ($amount !== null) {
            $refundData['amount'] = [
                'value' => number_format($amount, 2, '.', ''),
                'currency_code' => 'USD',
            ];
        }

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/v2/payments/captures/{$transactionId}/refund", $refundData);

        if ($response->successful()) {
            $refund = $response->json();
            
            return [
                'success' => true,
                'refund_id' => $refund['id'],
                'status' => $refund['status'],
                'gateway' => 'paypal',
            ];
        }

        return [
            'success' => false,
            'error' => $response->json('message') ?? 'Refund failed',
        ];
    }
}
