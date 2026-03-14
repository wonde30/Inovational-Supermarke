<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleService
{
    /**
     * Calculate totals for sale items server-side.
     * 
     * @param array $items Array of items with product_id and quantity
     * @param float $discount Discount amount
     * @param float $taxRate Tax rate percentage (e.g., 15 for 15%)
     * @return array Calculated totals
     */
    public function calculateTotals(array $items, float $discount = 0, float $taxRate = 0): array
    {
        $calculatedItems = [];
        $subtotal = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            
            if (!$product) {
                continue;
            }

            $quantity = (int) $item['quantity'];
            $unitPrice = (float) $product->price;
            $lineTotal = $quantity * $unitPrice;

            $calculatedItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'total' => round($lineTotal, 2),
            ];

            $subtotal += $lineTotal;
        }

        $tax = ($subtotal * $taxRate) / 100;
        $total = $subtotal + $tax - $discount;

        return [
            'items' => $calculatedItems,
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'discount' => round($discount, 2),
            'total' => round(max(0, $total), 2),
        ];
    }

    /**
     * Create a sale with items and deduct stock.
     * 
     * @param int $userId User creating the sale
     * @param array $items Array of items with product_id and quantity
     * @param string $paymentMethod Payment method
     * @param float $discount Discount amount
     * @param float $taxRate Tax rate percentage
     * @return Sale Created sale
     */
    public function createSale(
        int $userId,
        array $items,
        string $paymentMethod,
        float $discount = 0,
        float $taxRate = 0
    ): Sale {
        return DB::transaction(function () use ($userId, $items, $paymentMethod, $discount, $taxRate) {
            $totals = $this->calculateTotals($items, $discount, $taxRate);

            $sale = Sale::create([
                'user_id' => $userId,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'subtotal' => $totals['subtotal'],
                'tax' => $totals['tax'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'payment_method' => $paymentMethod,
                'status' => 'completed',
            ]);

            foreach ($totals['items'] as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['total'],
                ]);

                // Deduct stock
                $product = Product::find($item['product_id']);
                $product->deductStock($item['quantity']);
            }

            return $sale->load('saleItems.product');
        });
    }

    /**
     * Validate stock availability for all items.
     * 
     * @param array $items Array of items with product_id and quantity
     * @return array Array of validation errors (empty if all valid)
     */
    public function validateStockAvailability(array $items): array
    {
        $errors = [];

        foreach ($items as $index => $item) {
            $product = Product::find($item['product_id'] ?? null);
            
            if (!$product) {
                $errors["items.{$index}.product_id"] = "Product not found.";
                continue;
            }

            $requestedQuantity = (int) ($item['quantity'] ?? 0);
            
            if (!$product->hasAvailableStock($requestedQuantity)) {
                $errors["items.{$index}.quantity"] = 
                    "Insufficient stock for {$product->name}. Available: {$product->quantity}, Requested: {$requestedQuantity}";
            }
        }

        return $errors;
    }
}
