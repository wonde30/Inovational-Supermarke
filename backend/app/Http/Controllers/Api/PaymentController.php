<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ChapaPaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    use ApiResponse;

    /**
     * @var ChapaPaymentService
     */
    protected ChapaPaymentService $chapaPaymentService;

    /**
     * PaymentController constructor.
     *
     * @param ChapaPaymentService $chapaPaymentService
     */
    public function __construct(ChapaPaymentService $chapaPaymentService)
    {
        $this->chapaPaymentService = $chapaPaymentService;
    }

    /**
     * Initialize payment for order
     * 
     * POST /api/v1/payments/initialize
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function initializePayment(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
            ]);
            
            // Find order
            $order = Order::findOrFail($validated['order_id']);
            
            // Initialize payment
            $result = $this->chapaPaymentService->initializePayment($order);
            
            if ($result['success']) {
                return $this->success([
                    'transaction_id' => $result['transaction_id'],
                    'checkout_url' => $result['checkout_url'],
                    'status' => 'pending',
                ], 'Payment initialized successfully');
            }
            
            // Payment initialization failed
            return $this->error($result['error'] ?? 'Payment initialization failed', 400);
            
        } catch (ValidationException $e) {
            return $this->validationError($e->errors(), 'Validation failed');
        } catch (\Exception $e) {
            Log::error('Failed to initialize payment', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()?->id,
                'order_id' => $request->input('order_id'),
            ]);
            
            return $this->serverError('Failed to initialize payment');
        }
    }

    /**
     * Handle Chapa webhook
     * 
     * POST /api/v1/payments/webhook/chapa
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function chapaWebhook(Request $request): JsonResponse
    {
        try {
            Log::info('Chapa webhook received', [
                'payload' => $request->all(),
                'headers' => $request->headers->all(),
            ]);
            
            // Get webhook signature from header
            $signature = $request->header('X-Chapa-Signature', '');
            
            // Get payload
            $payload = $request->all();
            
            // Handle webhook
            $result = $this->chapaPaymentService->handleWebhook($payload, $signature);
            
            if ($result['success']) {
                Log::info('Webhook processed successfully', [
                    'message' => $result['message'],
                ]);
                return $this->success(null, $result['message']);
            }
            
            // Webhook processing failed
            Log::error('Webhook processing failed', [
                'message' => $result['message'],
                'payload' => $payload,
            ]);
            
            $statusCode = $result['message'] === 'Invalid signature' ? 401 : 400;
            return $this->error($result['message'], $statusCode);
            
        } catch (\Exception $e) {
            Log::error('Failed to process webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);
            
            return $this->serverError('Failed to process webhook');
        }
    }

    /**
     * Verify payment status
     * 
     * GET /api/v1/payments/{transactionId}/verify
     * 
     * @param string $transactionId
     * @return JsonResponse
     */
    public function verifyPayment(string $transactionId): JsonResponse
    {
        try {
            // Find payment by transaction ID
            $payment = Payment::where('transaction_id', $transactionId)->first();
            
            if (!$payment) {
                return $this->notFound('Payment not found');
            }
            
            // If payment is still pending, try to verify with gateway
            if ($payment->status === 'pending') {
                $verifyResult = $this->chapaPaymentService->verifyPaymentWithGateway($transactionId);
                
                if ($verifyResult['success'] && $verifyResult['verified']) {
                    // Update payment status
                    $payment->update([
                        'status' => 'completed',
                        'verified_at' => now(),
                        'payment_method' => $verifyResult['payment_method'] ?? 'chapa',
                    ]);
                    
                    // Complete the order
                    $order = $payment->order;
                    if ($order) {
                        $this->chapaPaymentService->completeOrder($order, $verifyResult['payment_method'] ?? 'chapa');
                    }
                }
            }
            
            // Return payment status
            return $this->success([
                'transaction_id' => $payment->transaction_id,
                'status' => $payment->status,
                'verified' => $payment->status === 'completed',
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'verified_at' => $payment->verified_at?->toISOString(),
                'order_id' => $payment->order_id,
                'order_status' => $payment->order?->status,
            ], 'Payment status retrieved successfully');
            
        } catch (\Exception $e) {
            Log::error('Failed to verify payment', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId,
            ]);
            
            return $this->serverError('Failed to verify payment');
        }
    }

    /**
     * Complete order after Chapa payment (called from callback page)
     * 
     * POST /api/v1/payments/complete-order
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function completeOrderAfterPayment(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
            ]);
            
            $order = Order::with('payments')->findOrFail($validated['order_id']);
            
            Log::info('Complete order request received', [
                'order_id' => $order->id,
                'current_status' => $order->status,
            ]);
            
            // If already completed, return success
            if ($order->status === 'completed') {
                Log::info('Order already completed', ['order_id' => $order->id]);
                return $this->success([
                    'order' => $order,
                    'message' => 'Order already completed',
                ]);
            }
            
            // Get the payment
            $payment = $order->payments()->latest()->first();
            
            if (!$payment) {
                Log::error('No payment found for order', ['order_id' => $order->id]);
                return $this->error('No payment found for this order', 404);
            }
            
            // Update payment status
            $payment->update([
                'status' => 'completed',
                'verified_at' => now(),
            ]);
            
            Log::info('Payment updated to completed', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
            ]);
            
            // Complete the order and create sale
            $this->chapaPaymentService->completeOrder($order, 'chapa');
            
            // Refresh order to get updated status
            $order->refresh();
            
            Log::info('Order completed successfully', [
                'order_id' => $order->id,
                'new_status' => $order->status,
                'payment_status' => $order->payment_status,
            ]);
            
            return $this->success([
                'order' => $order,
                'payment' => $payment,
                'message' => 'Order completed successfully',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to complete order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            
            return $this->serverError('Failed to complete order: ' . $e->getMessage());
        }
    }
}
