<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;

    /**
     * Sale Model - Business/Accounting record
     * 
     * Real-World Inventory System:
     * - Sales are created in two ways:
     *   1. Direct POS sale (cashier sells to walk-in customer) - has user_id
     *   2. From completed Order (online customer order fulfilled) - user_id is null
     * 
     * Relationship:
     * - Sale belongs to User (staff who processed the sale, nullable for online orders)
     * - Sale has many SaleItems (products sold)
     * - Sale has one Order (if created from online order)
     */

    protected $fillable = [
        'user_id', // Nullable - null for online orders, set for POS sales
        'invoice_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'customer_name',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Staff who processed the sale
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Items in this sale
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Alias for saleItems
     */
    public function items(): HasMany
    {
        return $this->saleItems();
    }

    /**
     * The order that this sale was created from (if any)
     * Only exists if sale was created from a completed online order
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Check if this sale was created from an online order
     */
    public function isFromOrder(): bool
    {
        return $this->order()->exists();
    }

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));
        
        return "{$prefix}-{$date}-{$random}";
    }
}
