<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
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
