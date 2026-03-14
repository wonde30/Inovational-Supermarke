<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');
        
        return [
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string',
            'default_reorder_level' => 'nullable|integer|min:0',
            'default_lead_time' => 'nullable|integer|min:0',
        ];
    }
}
