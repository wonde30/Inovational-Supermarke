<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class PaymentException extends Exception
{
    protected array $context = [];

    public function __construct(
        string $message = 'Payment processing failed',
        int $code = 0,
        ?Exception $previous = null,
        array $context = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        \Log::error('Payment Exception', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'context' => $this->context,
            'trace' => $this->getTraceAsString(),
        ]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error' => 'payment_failed',
            'context' => config('app.debug') ? $this->context : [],
        ], 422);
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
