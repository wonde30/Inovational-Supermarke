<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderAnalyticsService
{
    /**
     * Cache TTL in seconds (5 minutes)
     */
    private const CACHE_TTL = 300;

    /**
     * Get order counts grouped by status
     * 
     * @param User|null $user - Current user for role-based filtering
     * @return array ['pending' => int, 'processing' => int, 'completed' => int]
     */
    public function getOrderStatusCounts(?User $user = null): array
    {
        $cacheKey = $this->getCacheKey($user);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($user) {
            $query = Order::query();

            // Apply role-based filtering for provider users
            // Note: Provider filtering requires provider_id column in orders table
            // When provider_id is added to the schema, uncomment the following:
            // if ($user && $user->role === 'provider') {
            //     $query->where('provider_id', $user->id);
            // }

            // Get counts grouped by status
            $counts = $query->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            // Ensure all statuses are present with default value of 0
            return [
                'pending' => $counts['pending'] ?? 0,
                'processing' => $counts['processing'] ?? 0,
                'completed' => $counts['completed'] ?? 0,
            ];
        });
    }

    /**
     * Invalidate analytics cache
     * 
     * @param string|null $cacheKey - Specific cache key or null for all
     * @return void
     */
    public function invalidateCache(?string $cacheKey = null): void
    {
        if ($cacheKey) {
            Cache::forget($cacheKey);
        } else {
            // Clear all analytics cache keys
            // Pattern: order_analytics:*
            Cache::flush();
        }
    }

    /**
     * Get cache key for user
     * 
     * @param User|null $user
     * @return string
     */
    protected function getCacheKey(?User $user): string
    {
        if ($user && $user->role === 'provider') {
            return "order_analytics:provider:{$user->id}";
        }

        return 'order_analytics:all';
    }
}
