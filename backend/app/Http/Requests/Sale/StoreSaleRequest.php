<?php

namespace App\Http\Requests\Sale;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:cash,mobile,mobile_banking,bank_transfer,credit'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->validateStockAvailability($validator);
        });
    }

    protected function validateStockAvailability(Validator $validator): void
    {
        $items = $this->input('items', []);
        
        foreach ($items as $index => $item) {
            $product = Product::find($item['product_id'] ?? null);
            
            if (!$product) {
                continue;
            }

            $requestedQuantity = $item['quantity'] ?? 0;
            
            if (!$product->hasAvailableStock($requestedQuantity)) {
                $validator->errors()->add(
                    "items.{$index}.quantity",
                    "Insufficient stock for {$product->name}. Available: {$product->quantity}, Requested: {$requestedQuantity}"
                );
            }
        }
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required for a sale.',
            'items.min' => 'At least one item is required for a sale.',
            'items.*.product_id.required' => 'Product ID is required for each item.',
            'items.*.product_id.exists' => 'The selected product does not exist.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Invalid payment method. Must be cash, mobile, mobile_banking, bank_transfer, or credit.',
        ];
    }
}
