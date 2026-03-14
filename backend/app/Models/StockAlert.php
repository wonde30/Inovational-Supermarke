<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAlert extends Model
{
    protected $fillable = [
        'product_id',
        'alert_type',
        'is_resolved',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Create alert if not exists
     */
    public static function createIfNotExists(int $productId, string $alertType): ?self
    {
        $existing = self::where('product_id', $productId)
            ->where('alert_type', $alertType)
            ->where('is_resolved', false)
            ->first();

        if ($existing) {
            return null;
        }

        return self::create([
            'product_id' => $productId,
            'alert_type' => $alertType,
        ]);
    }

    /**
     * Resolve alert
     */
    public function resolve(): void
    {
        $this->update([
            'is_resolved' => true,
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);
    }
}
