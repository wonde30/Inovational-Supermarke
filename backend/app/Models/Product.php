<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'price',
        'cost',
        'quantity',
        'reorder_level',
        'image',
        'active',
        'batch_number',
        'expiry_date',
        'manufacture_date',
        'movement_type',
        'lead_time_days',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'quantity' => 'integer',
        'reorder_level' => 'integer',
        'active' => 'boolean',
        'expiry_date' => 'date',
        'manufacture_date' => 'date',
        'lead_time_days' => 'integer',
    ];

    protected $appends = ['low_stock', 'is_expiring_soon', 'is_expired', 'profit_margin'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function stockAlerts(): HasMany
    {
        return $this->hasMany(StockAlert::class);
    }

    public function getLowStockAttribute(): bool
    {
        // Only consider low stock if reorder_level is set (> 0) and quantity is at or below it
        return $this->reorder_level > 0 && $this->quantity > 0 && $this->quantity <= $this->reorder_level;
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->diffInDays(now()) <= 30 && $this->expiry_date->isFuture();
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->isPast();
    }

    public function getProfitMarginAttribute(): float
    {
        if ($this->price <= 0) return 0;
        return round((($this->price - $this->cost) / $this->price) * 100, 2);
    }

    public function hasAvailableStock(int $requestedQuantity): bool
    {
        return $this->quantity >= $requestedQuantity;
    }

    public function deductStock(int $quantity): void
    {
        $this->decrement('quantity', $quantity);
        $this->checkAndCreateAlerts();
    }

    public function addStock(int $quantity): void
    {
        $this->increment('quantity', $quantity);
        $this->resolveStockAlerts();
    }

    /**
     * Check stock levels and create alerts
     */
    public function checkAndCreateAlerts(): void
    {
        // Out of stock check
        if ($this->quantity <= 0) {
            StockAlert::createIfNotExists($this->id, 'out_of_stock');
            // Resolve low_stock since it's now out_of_stock
            $this->stockAlerts()
                ->where('alert_type', 'low_stock')
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        } 
        // Low stock check (only if reorder_level > 0)
        elseif ($this->reorder_level > 0 && $this->quantity <= $this->reorder_level) {
            StockAlert::createIfNotExists($this->id, 'low_stock');
            // Resolve out_of_stock since we have stock now
            $this->stockAlerts()
                ->where('alert_type', 'out_of_stock')
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        }
        // Stock is healthy
        else {
            $this->stockAlerts()
                ->whereIn('alert_type', ['low_stock', 'out_of_stock'])
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        }

        // Expired check
        if ($this->is_expired) {
            StockAlert::createIfNotExists($this->id, 'expired');
            // Resolve expiring_soon since it's now expired
            $this->stockAlerts()
                ->where('alert_type', 'expiring_soon')
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        } 
        // Expiring soon check
        elseif ($this->is_expiring_soon) {
            StockAlert::createIfNotExists($this->id, 'expiring_soon');
        }
        // Expiry is healthy
        else {
            $this->stockAlerts()
                ->whereIn('alert_type', ['expiring_soon', 'expired'])
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        }
    }

    /**
     * Resolve stock alerts when stock is replenished
     */
    public function resolveStockAlerts(): void
    {
        if ($this->quantity > $this->reorder_level) {
            $this->stockAlerts()
                ->whereIn('alert_type', ['low_stock', 'out_of_stock'])
                ->where('is_resolved', false)
                ->each(fn($alert) => $alert->resolve());
        }
    }

    /**
     * Update movement type based on sales velocity
     */
    public function updateMovementType(): void
    {
        $salesLast30Days = $this->saleItems()
            ->whereHas('sale', fn($q) => $q->where('created_at', '>=', now()->subDays(30)))
            ->sum('quantity');

        if ($salesLast30Days >= 50) {
            $this->movement_type = 'fast';
        } elseif ($salesLast30Days >= 10) {
            $this->movement_type = 'medium';
        } else {
            $this->movement_type = 'slow';
        }
        $this->save();
    }
}
