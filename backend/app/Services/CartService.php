<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get or create cart for user/session
     */
    public function getOrCreateCart(?int $userId, ?string $sessionId): Cart
    {
        $query = Cart::active();

        if ($userId) {
            $query->forUser($userId);
        } elseif ($sessionId) {
            $query->forSession($sessionId);
        }

        $cart = $query->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'status' => 'active',
                'last_activity_at' => now(),
            ]);
        }

        return $cart;
    }

    /**
     * Add product to cart
     */
    public function addProduct(Cart $cart, Product $product, int $quantity = 1): CartItem
    {
        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->increment('quantity', $quantity);
            $cartItem->update(['scanned_at' => now()]);
        } else {
            // Create new cart item
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'scanned_at' => now(),
            ]);
        }

        $cart->updateActivity();

        return $cartItem->fresh('product');
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(CartItem $cartItem, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem;
        }

        $cartItem->update(['quantity' => $quantity]);
        $cartItem->cart->updateActivity();

        return $cartItem->fresh();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(CartItem $cartItem): void
    {
        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->updateActivity();
    }

    /**
     * Clear cart
     */
    public function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->updateActivity();
    }

    /**
     * Get cart with items
     */
    public function getCartWithItems(Cart $cart): array
    {
        $items = $cart->items()->with('product.category')->get();

        $subtotal = 0;
        $itemsData = [];

        foreach ($items as $item) {
            $lineTotal = $item->price * $item->quantity;
            $subtotal += $lineTotal;

            $itemsData[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->image,
                'category' => $item->product->category->name ?? null,
                'quantity' => $item->quantity,
                'unit_price' => round($item->price, 2),
                'total' => round($lineTotal, 2),
                'available_stock' => $item->product->quantity,
                'scanned_at' => $item->scanned_at?->toISOString(),
            ];
        }

        $taxRate = config('app.tax_rate', 0);
        $tax = ($subtotal * $taxRate) / 100;
        $total = $subtotal + $tax;

        return [
            'cart_id' => $cart->id,
            'items' => $itemsData,
            'item_count' => $cart->item_count,
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'tax_rate' => $taxRate,
            'total' => round($total, 2),
            'last_activity' => $cart->last_activity_at?->toISOString(),
        ];
    }

    /**
     * Validate cart stock availability
     */
    public function validateStock(Cart $cart): array
    {
        $errors = [];

        foreach ($cart->items as $item) {
            $product = $item->product;

            if (!$product->active) {
                $errors[] = "{$product->name} is no longer available";
                continue;
            }

            if ($product->quantity < $item->quantity) {
                $errors[] = "Insufficient stock for {$product->name}. Available: {$product->quantity}, Requested: {$item->quantity}";
            }
        }

        return $errors;
    }

    /**
     * Convert cart to order
     */
    public function convertToOrder(Cart $cart, int $userId): \App\Models\Order
    {
        return DB::transaction(function () use ($cart, $userId) {
            // Validate stock
            $errors = $this->validateStock($cart);
            if (!empty($errors)) {
                throw new \Exception(implode(', ', $errors));
            }

            // Calculate total
            $cartData = $this->getCartWithItems($cart);

            // Create order
            $order = \App\Models\Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $cartData['total'],
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items and reduce stock
            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->decrement('quantity', $item->quantity);
            }

            // Mark cart as converted
            $cart->update(['status' => 'converted']);

            return $order->fresh('orderItems.product');
        });
    }
}
