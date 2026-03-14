<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InsufficientStockException extends Exception
{
    protected array $products = [];

    public function __construct(
        string $message = 'Insufficient stock',
        array $products = []
    ) {
        parent::__construct($message);
        $this->products = $products;
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        \Log::warning('Insufficient Stock', [
            'message' => $this->getMessage(),
            'products' => $this->products,
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
            'error' => 'insufficient_stock',
            'products' => $this->products,
        ], 422);
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
