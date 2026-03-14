<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    /**
     * Order Model - Customer-facing order record
     * 
     * Real-World Inventory System Flow:
     * 1. Customer places ORDER (online/storefront) → Status: pending
     * 2. Staff processes ORDER → Status: processing
     * 3. ORDER completed & paid → Creates SALE record → Order Status: completed
     * 
     * Relationship:
     * - Order belongs to Customer (who placed the order)
     * - Order has many OrderItems (products ordered)
     * - Order belongs to Sale (when completed, links to financial record)
     */

    protected $fillable = [
        'customer_id',
        'user_id',
        'order_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
        'payment_status',
        'sale_id',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Customer who placed the order
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Items in this order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * The sale record created when order is completed
     * This links the customer order to the accounting/financial record
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Payment records for this order
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Check if order is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
