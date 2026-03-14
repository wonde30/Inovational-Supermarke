<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AnalyticsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $cashier;
    protected string $adminToken;
    protected string $managerToken;
    protected string $cashierToken;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users with different roles
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->manager = User::factory()->create([
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        $this->cashier = User::factory()->create([
            'role' => 'cashier',
            'email_verified_at' => now(),
        ]);

        // Create tokens
        $this->adminToken = $this->admin->createToken('test-token')->plainTextToken;
        $this->managerToken = $this->manager->createToken('test-token')->plainTextToken;
        $this->cashierToken = $this->cashier->createToken('test-token')->plainTextToken;

        // Clear cache before each test
        Cache::flush();
    }

    /**
     * Test order status counts endpoint returns correct structure
     */
    public function test_order_status_counts_returns_correct_structure(): void
    {
        // Create orders with different statuses
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'processing']);
        Order::factory()->create(['status' => 'completed']);

        $response = $this->getJson('/api/v1/analytics/orders/status', [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'pending',
                'processing',
                'completed',
            ],
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertIsInt($response->json('data.pending'));
        $this->assertIsInt($response->json('data.processing'));
        $this->assertIsInt($response->json('data.completed'));
    }

    /**
     * Test order status counts with multiple orders
     */
    public function test_order_status_counts_with_multiple_orders(): void
    {
        // Create multiple orders
        Order::factory()->count(5)->create(['status' => 'pending']);
        Order::factory()->count(3)->create(['status' => 'processing']);
        Order::factory()->count(10)->create(['status' => 'completed']);

        $response = $this->getJson('/api/v1/analytics/orders/status', [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'pending' => 5,
                'processing' => 3,
                'completed' => 10,
            ],
        ]);
    }

    /**
     * Test order status counts requires authentication
     */
    public function test_order_status_counts_requires_authentication(): void
    {
        $response = $this->getJson('/api/v1/analytics/orders/status');

        $response->assertStatus(401);
    }

    /**
     * Test order status counts requires admin or manager role
     */
    public function test_order_status_counts_requires_admin_or_manager_role(): void
    {
        $response = $this->getJson('/api/v1/analytics/orders/status', [
            'Authorization' => 'Bearer ' . $this->cashierToken,
        ]);

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthorized. Admin or manager role required.',
        ]);
    }

    /**
     * Test manager can access order status counts
     */
    public function test_manager_can_access_order_status_counts(): void
    {
        Order::factory()->create(['status' => 'pending']);

        $response = $this->getJson('/api/v1/analytics/orders/status', [
            'Authorization' => 'Bearer ' . $this->managerToken,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test generate sales report with valid date range
     */
    public function test_generate_sales_report_with_valid_date_range(): void
    {
        // Create a category first
        $category = \App\Models\Category::create([
            'name' => 'Test Category',
            'active' => true,
        ]);

        // Create a product manually
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'price' => 100.00,
            'cost' => 50.00,
            'quantity' => 100,
            'active' => true,
        ]);

        // Create orders with items
        $order = Order::factory()->create([
            'total' => 200.00,
            'created_at' => now()->subDays(5),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00,
            'unit_price' => 100.00,
            'total' => 200.00,
        ]);

        $response = $this->postJson('/api/v1/analytics/sales/report', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'start_date',
                'end_date',
                'total_sales',
                'total_items',
                'revenue',
                'items',
            ],
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals(200.00, $response->json('data.total_sales'));
        $this->assertEquals(2, $response->json('data.total_items'));
    }

    /**
     * Test generate sales report requires start_date and end_date
     */
    public function test_generate_sales_report_requires_dates(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/report', [], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date', 'end_date']);
    }

    /**
     * Test generate sales report rejects invalid date range
     */
    public function test_generate_sales_report_rejects_invalid_date_range(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/report', [
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->subDays(7)->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'success' => false,
        ]);
    }

    /**
     * Test generate sales report requires authentication
     */
    public function test_generate_sales_report_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/report', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test generate sales report requires admin or manager role
     */
    public function test_generate_sales_report_requires_admin_or_manager_role(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/report', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->cashierToken,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test export sales report returns CSV
     */
    public function test_export_sales_report_returns_csv(): void
    {
        // Create a category first
        $category = \App\Models\Category::create([
            'name' => 'Test Category',
            'active' => true,
        ]);

        // Create a product manually
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-002',
            'price' => 100.00,
            'cost' => 50.00,
            'quantity' => 100,
            'active' => true,
        ]);

        // Create orders with items
        $order = Order::factory()->create([
            'total' => 200.00,
            'created_at' => now()->subDays(5),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00,
            'unit_price' => 100.00,
            'total' => 200.00,
        ]);

        $startDate = now()->subDays(7)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $response = $this->postJson('/api/v1/analytics/sales/export', [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=utf-8');
        $response->assertHeader('Content-Disposition', "attachment; filename=\"sales_report_{$startDate}_to_{$endDate}.csv\"");

        // Verify CSV content contains headers
        $content = $response->getContent();
        $this->assertStringContainsString('Date Range', $content);
        $this->assertStringContainsString('Product Name', $content);
        $this->assertStringContainsString('Quantity', $content);
        $this->assertStringContainsString('Amount', $content);
    }

    /**
     * Test export sales report requires dates
     */
    public function test_export_sales_report_requires_dates(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/export', [], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date', 'end_date']);
    }

    /**
     * Test export sales report requires authentication
     */
    public function test_export_sales_report_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/export', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test export sales report requires admin or manager role
     */
    public function test_export_sales_report_requires_admin_or_manager_role(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/export', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->cashierToken,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test empty report returns valid structure
     */
    public function test_empty_report_returns_valid_structure(): void
    {
        $response = $this->postJson('/api/v1/analytics/sales/report', [
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->adminToken,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'total_sales' => 0,
                'total_items' => 0,
                'revenue' => 0,
                'items' => [],
            ],
        ]);
    }
}
