<?php

namespace App\Http\Controllers\Api\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Get user's cart
     */
    public function show(Request $request): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart($request->user()->id);
        $cartData = $this->cartService->getCartWithItems($cart);

        return $this->success($cartData);
    }

    /**
     * Add product to cart
     */
    public function addProduct(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = $this->cartService->addProduct(
                $request->user()->id,
                $validated['product_id'],
                $validated['quantity']
            );

            $cartData = $this->cartService->getCartWithItems($cart);

            return $this->success($cartData, 'Product added to cart');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, CartItem $item): JsonResponse
    {
        // Verify the item belongs to the user's cart
        if ($item->cart->user_id !== $request->user()->id) {
            return $this->error('Unauthorized', 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = $this->cartService->updateQuantity(
                $item->id,
                $validated['quantity']
            );

            $cartData = $this->cartService->getCartWithItems($cart);

            return $this->success($cartData, 'Cart updated');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request, CartItem $item): JsonResponse
    {
        // Verify the item belongs to the user's cart
        if ($item->cart->user_id !== $request->user()->id) {
            return $this->error('Unauthorized', 403);
        }

        try {
            $cart = $this->cartService->removeItem($item->id);
            $cartData = $this->cartService->getCartWithItems($cart);

            return $this->success($cartData, 'Item removed from cart');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Clear cart
     */
    public function clear(Request $request): JsonResponse
    {
        try {
            $cart = $this->cartService->clearCart($request->user()->id);
            $cartData = $this->cartService->getCartWithItems($cart);

            return $this->success($cartData, 'Cart cleared');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    public function calculateTotals(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = [];
        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            
            if (!$product || !$product->active) {
                continue;
            }

            $lineTotal = $product->price * $item['quantity'];
            
            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $item['quantity'],
                'unit_price' => round($product->price, 2),
                'total' => round($lineTotal, 2),
                'available_stock' => $product->quantity,
            ];

            $subtotal += $lineTotal;
        }

        $taxRate = config('app.tax_rate', 0);
        $tax = ($subtotal * $taxRate) / 100;
        $total = $subtotal + $tax;

        return $this->success([
            'items' => $items,
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'total' => round($total, 2),
        ]);
    }

    public function validateStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $errors = [];

        foreach ($validated['items'] as $index => $item) {
            $product = Product::find($item['product_id']);
            
            if (!$product) {
                $errors[] = "Product not found for item {$index}";
                continue;
            }

            if (!$product->active) {
                $errors[] = "{$product->name} is no longer available";
                continue;
            }

            if ($product->quantity < $item['quantity']) {
                $errors[] = "Insufficient stock for {$product->name}. Available: {$product->quantity}";
            }
        }

        if (!empty($errors)) {
            return $this->error('Stock validation failed', 422, ['errors' => $errors]);
        }

        return $this->success(['valid' => true], 'Stock is available');
    }
}
