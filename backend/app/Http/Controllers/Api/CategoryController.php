<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return $this->success($categories, 'Categories retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return $this->success($category, 'Category created successfully', 201);
    }

    public function show(Category $category)
    {
        return $this->success($category->loadCount('products'), 'Category retrieved successfully');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return $this->success($category, 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return $this->error('Cannot delete category with products', 422);
        }

        $category->delete();

        return $this->success(null, 'Category deleted successfully');
    }
}
