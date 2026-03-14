<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category')->where('active', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Only show products with stock
        if ($request->boolean('in_stock', false)) {
            $query->where('quantity', '>', 0);
        }

        $products = $query->orderBy('name')->paginate($request->per_page ?? 12);

        return $this->paginated($products);
    }

    public function show(Product $product): JsonResponse
    {
        if (!$product->active) {
            return $this->error('Product not found', 404);
        }

        return $this->success($product->load('category'));
    }

    public function categories(): JsonResponse
    {
        $categories = \App\Models\Category::withCount(['products' => function ($q) {
            $q->where('active', true);
        }])->get();

        return $this->success($categories);
    }
}
