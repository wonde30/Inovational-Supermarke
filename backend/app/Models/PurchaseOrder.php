<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'po_number',
        'supplier_id',
        'user_id',
        'status',
        'order_date',
        'expected_delivery_date',
        'actual_delivery_date',
        'total_amount',
        'notes',
        'supplier_notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the supplier for this purchase order
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the user who created this purchase order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchase order items
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Get available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    /**
     * Check if purchase order can be updated by supplier
     */
    public function canBeUpdatedBySupplier(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_SHIPPED]);
    }

    /**
     * Generate unique PO number
     */
    public static function generatePoNumber(): string
    {
        $prefix = 'PO';
        $date = now()->format('Ymd');
        $lastPo = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastPo ? (int)substr($lastPo->po_number, -3) + 1 : 1;
        
        return $prefix . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}