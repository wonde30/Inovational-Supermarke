<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact_person',
        'user_id', // Link to User model for supplier login
        'is_active',
        'tax_number',
        'payment_terms',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user account for this supplier
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get purchase orders for this supplier
     */
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /**
     * Get products supplied by this supplier
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope for active suppliers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get pending purchase orders
     */
    public function getPendingPurchaseOrders()
    {
        return $this->purchaseOrders()
            ->whereIn('status', [PurchaseOrder::STATUS_PENDING, PurchaseOrder::STATUS_CONFIRMED])
            ->with('items.product')
            ->get();
    }
}
