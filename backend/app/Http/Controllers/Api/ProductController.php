<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $perPage = $request->get('per_page', 15);
        $products = $query->orderBy('name')->paginate($perPage);

        return $this->paginated($products, 'Products retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return $this->success($product->load('category'), 'Product created successfully', 201);
    }

    public function show(Product $product)
    {
        return $this->success($product->load('category'), 'Product retrieved successfully');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'cost' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
            'reorder_level' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $product->update($validated);
        
        // Check and update stock alerts after quantity or reorder_level changes
        if (isset($validated['quantity']) || isset($validated['reorder_level'])) {
            $product->checkAndCreateAlerts();
        }

        return $this->success($product->load('category'), 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success(null, 'Product deleted successfully');
    }
}
