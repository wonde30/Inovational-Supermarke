<?php

namespace App\Services\PaymentGateway;

use Illuminate\Support\Facades\Http;

/**
 * Chappa Payment Gateway - Ethiopian Payment Solution
 * Supports: Telebirr, CBE Birr, M-Pesa, Amole, etc.
 */
class ChappaGateway implements PaymentGatewayInterface
{
    private string $baseUrl;
    private string $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.chappa.mode') === 'live'
            ? 'https://api.chapa.co/v1'
            : 'https://api.chapa.co/v1'; // Chappa uses same URL for both
        
        $this->secretKey = config('services.chappa.secret_key');
    }

    /**
     * Process payment through Chappa
     */
    public function processPayment(array $paymentData): array
    {
        try {
            $txRef = $paymentData['reference'] ?? 'TX-' . time();
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/transaction/initialize", [
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'] ?? 'ETB',
                'email' => $paymentData['customer_email'],
                'first_name' => $paymentData['customer_name'] ?? 'Customer',
                'last_name' => $paymentData['customer_name'] ?? '',
                'phone_number' => $paymentData['phone_number'] ?? '',
                'tx_ref' => $txRef,
                'callback_url' => $paymentData['callback_url'] ?? config('app.url') . '/api/v1/payments/callback',
                'return_url' => $paymentData['return_url'] ?? config('app.url'),
                'customization' => [
                    'title' => 'IBMS Payment', // Max 16 characters for Chapa
                    'description' => $paymentData['description'] ?? 'Order payment',
                ],
            ]);

            $responseData = $response->json();
            
            // Log the response for debugging
            \Log::info('Chapa API Response', [
                'status_code' => $response->status(),
                'response' => $responseData,
            ]);

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'success') {
                $data = $responseData['data'] ?? [];
                
                return [
                    'success' => true,
                    'transaction_id' => $data['tx_ref'] ?? $txRef,
                    'checkout_url' => $data['checkout_url'] ?? null,
                    'status' => 'pending',
                    'gateway' => 'chappa',
                ];
            }

            // Handle error response
            $errorMessage = 'Payment initialization failed';
            
            if (isset($responseData['message'])) {
                $errorMessage = $responseData['message'];
            } elseif (isset($responseData['error'])) {
                $errorMessage = is_array($responseData['error']) 
                    ? json_encode($responseData['error']) 
                    : $responseData['error'];
            }

            \Log::error('Chapa payment initialization failed', [
                'status_code' => $response->status(),
                'error' => $errorMessage,
                'response' => $responseData,
            ]);

            return [
                'success' => false,
                'error' => $errorMessage,
                'gateway' => 'chappa',
            ];
        } catch (\Exception $e) {
            \Log::error('Chapa payment exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'gateway' => 'chappa',
            ];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $transactionId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
            ])->get("{$this->baseUrl}/transaction/verify/{$transactionId}");

            if ($response->successful() && $response->json('status') === 'success') {
                $data = $response->json('data');
                
                return [
                    'success' => true,
                    'status' => $data['status'],
                    'amount' => $data['amount'],
                    'currency' => $data['currency'],
                    'verified' => $data['status'] === 'success',
                    'payment_method' => $data['payment_method'] ?? 'unknown',
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message') ?? 'Verification failed',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund payment (if supported by Chappa)
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array
    {
        // Note: Check Chappa documentation for refund API
        // This is a placeholder implementation
        
        return [
            'success' => false,
            'error' => 'Refunds must be processed manually through Chappa dashboard',
            'gateway' => 'chappa',
        ];
    }

    /**
     * Get supported payment methods
     */
    public function getSupportedMethods(): array
    {
        return [
            'telebirr',
            'cbe_birr',
            'mpesa',
            'amole',
            'ebirr',
        ];
    }
}
