<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');
        
        return [
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'sku' => 'sometimes|required|string|max:100|unique:products,sku,' . $productId,
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'cost' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:100',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
            'manufacture_date' => 'nullable|date',
            'movement_type' => 'nullable|in:fast,medium,slow',
            'lead_time_days' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ];
    }
}
