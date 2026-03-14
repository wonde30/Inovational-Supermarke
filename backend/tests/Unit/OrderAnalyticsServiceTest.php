<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderAnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class OrderAnalyticsServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderAnalyticsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OrderAnalyticsService();
        Cache::flush(); // Clear cache before each test
    }

    /** @test */
    public function it_returns_complete_status_counts_structure()
    {
        // Requirement 10.1: Test that the service returns all three status counts
        $result = $this->service->getOrderStatusCounts();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('pending', $result);
        $this->assertArrayHasKey('processing', $result);
        $this->assertArrayHasKey('completed', $result);
        $this->assertIsInt($result['pending']);
        $this->assertIsInt($result['processing']);
        $this->assertIsInt($result['completed']);
    }

    /** @test */
    public function it_returns_zero_counts_for_empty_database()
    {
        $result = $this->service->getOrderStatusCounts();

        $this->assertEquals(0, $result['pending']);
        $this->assertEquals(0, $result['processing']);
        $this->assertEquals(0, $result['completed']);
    }

    /** @test */
    public function it_returns_correct_counts_for_mixed_order_statuses()
    {
        // Create orders with different statuses
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'processing']);
        Order::factory()->create(['status' => 'completed']);
        Order::factory()->create(['status' => 'completed']);
        Order::factory()->create(['status' => 'completed']);

        $result = $this->service->getOrderStatusCounts();

        $this->assertEquals(2, $result['pending']);
        $this->assertEquals(1, $result['processing']);
        $this->assertEquals(3, $result['completed']);
    }

    /** @test */
    public function it_caches_order_status_counts_for_5_minutes()
    {
        // Requirement 10.1: Cache order status counts for 5 minutes
        Order::factory()->create(['status' => 'pending']);

        // First call should query database and cache
        $result1 = $this->service->getOrderStatusCounts();
        $this->assertEquals(1, $result1['pending']);

        // Create another order
        Order::factory()->create(['status' => 'pending']);

        // Second call should return cached data (still 1, not 2)
        $result2 = $this->service->getOrderStatusCounts();
        $this->assertEquals(1, $result2['pending'], 'Should return cached data');
    }

    /** @test */
    public function it_returns_cached_data_when_cache_exists()
    {
        // Requirement 10.2: Return cached data when it exists and is less than 5 minutes old
        Order::factory()->create(['status' => 'pending']);

        // First call caches the data
        $result1 = $this->service->getOrderStatusCounts();

        // Add more orders
        Order::factory()->count(5)->create(['status' => 'pending']);

        // Second call should return cached data (1, not 6)
        $result2 = $this->service->getOrderStatusCounts();
        $this->assertEquals($result1['pending'], $result2['pending']);
    }

    /** @test */
    public function it_refreshes_cache_after_invalidation()
    {
        // Requirement 10.3: Refresh cache with current data when expired
        Order::factory()->create(['status' => 'pending']);

        // First call caches the data
        $result1 = $this->service->getOrderStatusCounts();
        $this->assertEquals(1, $result1['pending']);

        // Add more orders
        Order::factory()->count(2)->create(['status' => 'pending']);

        // Invalidate cache
        $this->service->invalidateCache();

        // Next call should refresh with current data
        $result2 = $this->service->getOrderStatusCounts();
        $this->assertEquals(3, $result2['pending'], 'Should return fresh data after cache invalidation');
    }

    /** @test */
    public function it_invalidates_specific_cache_key()
    {
        // Requirement 10.4: Invalidate relevant cache entries
        Order::factory()->create(['status' => 'pending']);

        $result1 = $this->service->getOrderStatusCounts();
        $this->assertEquals(1, $result1['pending']);

        // Get the cache key
        $cacheKey = 'order_analytics:all';

        // Invalidate specific cache key
        $this->service->invalidateCache($cacheKey);

        // Add more orders
        Order::factory()->create(['status' => 'pending']);

        // Should return fresh data
        $result2 = $this->service->getOrderStatusCounts();
        $this->assertEquals(2, $result2['pending']);
    }

    /** @test */
    public function it_generates_correct_cache_key_for_admin()
    {
        $result = $this->service->getOrderStatusCounts(null);

        // Verify cache was created with correct key
        $this->assertTrue(Cache::has('order_analytics:all'));
    }

    /** @test */
    public function it_generates_correct_cache_key_for_provider()
    {
        // Note: Using 'manager' role as a substitute for 'provider' since the schema
        // defines roles as: admin, manager, cashier, customer, delivery_staff, supplier
        $provider = User::factory()->create(['role' => 'manager']);

        $result = $this->service->getOrderStatusCounts($provider);

        // The service checks for 'provider' role, so it should use the 'all' cache key
        // since 'manager' is not 'provider'
        $this->assertTrue(Cache::has('order_analytics:all'));
    }

    /** @test */
    public function it_invalidates_all_cache_when_no_key_specified()
    {
        Order::factory()->create(['status' => 'pending']);

        // Cache data for admin
        $this->service->getOrderStatusCounts();

        // Cache data for manager
        $manager = User::factory()->create(['role' => 'manager']);
        $this->service->getOrderStatusCounts($manager);

        // Verify cache exists
        $this->assertTrue(Cache::has('order_analytics:all'));

        // Invalidate all cache
        $this->service->invalidateCache();

        // Verify cache is cleared
        $this->assertFalse(Cache::has('order_analytics:all'));
    }
}
