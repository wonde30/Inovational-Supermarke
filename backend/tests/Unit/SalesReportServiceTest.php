<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\SalesReportService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SalesReportServiceTest extends TestCase
{
    use RefreshDatabase;

    private SalesReportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SalesReportService();
    }

    /** @test */
    public function it_generates_report_with_correct_structure()
    {
        // Requirement 4.1: Test that the service returns proper report structure
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $result = $this->service->generateReport($startDate, $endDate);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('start_date', $result);
        $this->assertArrayHasKey('end_date', $result);
        $this->assertArrayHasKey('total_sales', $result);
        $this->assertArrayHasKey('total_items', $result);
        $this->assertArrayHasKey('revenue', $result);
        $this->assertArrayHasKey('items', $result);
    }

    /** @test */
    public function it_returns_empty_report_for_no_orders_in_range()
    {
        // Requirement 4.2: Test with no orders in range
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $result = $this->service->generateReport($startDate, $endDate);

        $this->assertEquals(0, $result['total_sales']);
        $this->assertEquals(0, $result['total_items']);
        $this->assertEquals(0, $result['revenue']);
        $this->assertEmpty($result['items']);
    }

    /** @test */
    public function it_calculates_correct_totals_for_single_order()
    {
        // Requirement 4.3: Test total calculations
        $category = Category::create(['name' => 'Test Category']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'price' => 50.00,
            'cost' => 30.00,
            'quantity' => 100,
        ]);
        $order = Order::factory()->create([
            'total' => 100.00,
            'created_at' => Carbon::now(),
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 50.00,
            'total' => 100.00,
        ]);

        $startDate = Carbon::now()->subDays(1);
        $endDate = Carbon::now()->addDays(1);

        $result = $this->service->generateReport($startDate, $endDate);

        $this->assertEquals(100.00, $result['total_sales']);
        $this->assertEquals(2, $result['total_items']);
        $this->assertEquals(100.00, $result['revenue']);
        $this->assertCount(1, $result['items']);
    }

    /** @test */
    public function it_filters_orders_by_date_range()
    {
        // Requirement 4.2: Test date range filtering
        $category = Category::create(['name' => 'Test Category']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-002',
            'price' => 50.00,
            'cost' => 30.00,
            'quantity' => 100,
        ]);
        
        // Order within range
        $orderInRange = Order::factory()->create([
            'total' => 100.00,
            'created_at' => Carbon::now()->subDays(3),
        ]);
        OrderItem::create([
            'order_id' => $orderInRange->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 50.00,
            'total' => 100.00,
        ]);

        // Order outside range
        $orderOutsideRange = Order::factory()->create([
            'total' => 200.00,
            'created_at' => Carbon::now()->subDays(10),
        ]);
        OrderItem::create([
            'order_id' => $orderOutsideRange->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_price' => 66.67,
            'total' => 200.00,
        ]);

        $startDate = Carbon::now()->subDays(5);
        $endDate = Carbon::now();

        $result = $this->service->generateReport($startDate, $endDate);

        // Should only include the order within range
        $this->assertEquals(100.00, $result['total_sales']);
        $this->assertEquals(2, $result['total_items']);
    }

    /** @test */
    public function it_rejects_invalid_date_range()
    {
        // Requirement 4.5: Test invalid date range rejection
        $this->expectException(ValidationException::class);

        $startDate = Carbon::now();
        $endDate = Carbon::now()->subDays(7); // End before start

        $this->service->generateReport($startDate, $endDate);
    }

    /** @test */
    public function it_aggregates_items_by_product()
    {
        // Test that multiple order items for the same product are aggregated
        $category = Category::create(['name' => 'Test Category']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-003',
            'price' => 25.00,
            'cost' => 15.00,
            'quantity' => 100,
        ]);
        
        $order1 = Order::factory()->create([
            'total' => 100.00,
            'created_at' => Carbon::now(),
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 25.00,
            'total' => 50.00,
        ]);

        $order2 = Order::factory()->create([
            'total' => 150.00,
            'created_at' => Carbon::now(),
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_price' => 25.00,
            'total' => 75.00,
        ]);

        $startDate = Carbon::now()->subDays(1);
        $endDate = Carbon::now()->addDays(1);

        $result = $this->service->generateReport($startDate, $endDate);

        $this->assertCount(1, $result['items']);
        $this->assertEquals(5, $result['items'][0]['quantity']); // 2 + 3
        $this->assertEquals(125.00, $result['items'][0]['amount']); // 50 + 75
    }

    /** @test */
    public function it_exports_report_to_csv_format()
    {
        // Requirement 5.3: Test CSV export
        $reportData = [
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-31',
            'total_sales' => 500.00,
            'total_items' => 10,
            'revenue' => 500.00,
            'items' => [
                [
                    'product_id' => 1,
                    'product_name' => 'Product A',
                    'quantity' => 5,
                    'amount' => 250.00,
                ],
                [
                    'product_id' => 2,
                    'product_name' => 'Product B',
                    'quantity' => 5,
                    'amount' => 250.00,
                ],
            ],
        ];

        $csv = $this->service->exportToCsv($reportData);

        $this->assertIsString($csv);
        $this->assertStringContainsString('Date Range', $csv);
        $this->assertStringContainsString('Product Name', $csv);
        $this->assertStringContainsString('Quantity', $csv);
        $this->assertStringContainsString('Amount', $csv);
        $this->assertStringContainsString('Product A', $csv);
        $this->assertStringContainsString('Product B', $csv);
    }

    /** @test */
    public function it_validates_date_range_with_equal_dates()
    {
        // Test that start_date = end_date is valid
        $date = Carbon::now();

        $result = $this->service->generateReport($date, $date);

        $this->assertIsArray($result);
        $this->assertEquals($date->format('Y-m-d'), $result['start_date']);
        $this->assertEquals($date->format('Y-m-d'), $result['end_date']);
    }
}
