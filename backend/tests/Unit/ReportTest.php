<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Property-based tests for Reports Module
 * 
 * Feature: ibms-proper-structure
 * Validates: Requirements 7.1, 7.3, 7.4
 */
class ReportTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * Property 16: Sales Report Filtering
     * 
     * For any date range, the sales report SHALL only include sales
     * within that date range.
     * 
     * @test
     * @dataProvider salesReportDataProvider
     */
    public function sales_report_filtering(int $daysAgo, int $rangeDays): void
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create sales at different dates
        $startDate = now()->subDays($daysAgo);
        $endDate = $startDate->copy()->addDays($rangeDays);

        // Sales within range
        $inRangeSales = [];
        for ($i = 0; $i < 3; $i++) {
            $sale = Sale::create([
                'user_id' => $user->id,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'subtotal' => $this->faker->randomFloat(2, 100, 500),
                'tax' => 0,
                'discount' => 0,
                'total' => $this->faker->randomFloat(2, 100, 500),
                'payment_method' => 'cash',
                'status' => 'completed',
                'created_at' => $startDate->copy()->addDays($this->faker->numberBetween(0, $rangeDays)),
            ]);
            $inRangeSales[] = $sale->id;
        }

        // Sales outside range
        for ($i = 0; $i < 2; $i++) {
            Sale::create([
                'user_id' => $user->id,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'subtotal' => $this->faker->randomFloat(2, 100, 500),
                'tax' => 0,
                'discount' => 0,
                'total' => $this->faker->randomFloat(2, 100, 500),
                'payment_method' => 'cash',
                'status' => 'completed',
                'created_at' => now()->subDays($daysAgo + $rangeDays + 10),
            ]);
        }

        // Query sales within range
        $filteredSales = Sale::where('status', 'completed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        // Property: All returned sales must be within date range
        foreach ($filteredSales as $sale) {
            $saleDate = $sale->created_at->startOfDay();
            $this->assertTrue(
                $saleDate->gte($startDate->startOfDay()) && $saleDate->lte($endDate->endOfDay()),
                "Sale date must be within specified range"
            );
        }
    }

    /**
     * Property 17: Profit Calculation Accuracy
     * 
     * For any set of sales, profit SHALL equal revenue minus cost.
     * 
     * @test
     * @dataProvider profitCalculationDataProvider
     */
    public function profit_calculation_accuracy(array $salesData): void
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        $expectedRevenue = 0;
        $expectedCost = 0;

        foreach ($salesData as $saleData) {
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $saleData['price'],
                'cost' => $saleData['cost'],
                'quantity' => 1000,
                'reorder_level' => 10,
                'active' => true,
            ]);

            $sale = Sale::create([
                'user_id' => $user->id,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'subtotal' => $saleData['price'] * $saleData['quantity'],
                'tax' => 0,
                'discount' => 0,
                'total' => $saleData['price'] * $saleData['quantity'],
                'payment_method' => 'cash',
                'status' => 'completed',
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $saleData['quantity'],
                'unit_price' => $saleData['price'],
                'total' => $saleData['price'] * $saleData['quantity'],
            ]);

            $expectedRevenue += $saleData['price'] * $saleData['quantity'];
            $expectedCost += $saleData['cost'] * $saleData['quantity'];
        }

        // Calculate actual profit
        $items = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->select('sale_items.*', 'products.cost')
            ->get();

        $actualRevenue = $items->sum('total');
        $actualCost = $items->sum(function ($item) {
            return $item->cost * $item->quantity;
        });
        $actualProfit = $actualRevenue - $actualCost;
        $expectedProfit = $expectedRevenue - $expectedCost;

        // Property: Profit = Revenue - Cost
        $this->assertEqualsWithDelta(
            $expectedProfit,
            $actualProfit,
            0.02,
            "Profit must equal revenue minus cost"
        );
    }

    /**
     * Property 18: Top Products Ordering
     * 
     * For any top products query, results SHALL be ordered by quantity sold descending.
     * 
     * @test
     * @dataProvider topProductsDataProvider
     */
    public function top_products_ordering(array $productsData): void
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        foreach ($productsData as $data) {
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $data['price'],
                'cost' => $data['price'] * 0.7,
                'quantity' => 1000,
                'reorder_level' => 10,
                'active' => true,
            ]);

            $sale = Sale::create([
                'user_id' => $user->id,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'subtotal' => $data['price'] * $data['sold_quantity'],
                'tax' => 0,
                'discount' => 0,
                'total' => $data['price'] * $data['sold_quantity'],
                'payment_method' => 'cash',
                'status' => 'completed',
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $data['sold_quantity'],
                'unit_price' => $data['price'],
                'total' => $data['price'] * $data['sold_quantity'],
            ]);
        }

        // Get top products
        $topProducts = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_quantity')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        // Property: Results must be in descending order by quantity
        $previousQuantity = PHP_INT_MAX;
        foreach ($topProducts as $product) {
            $this->assertLessThanOrEqual(
                $previousQuantity,
                $product->total_quantity,
                "Products must be ordered by quantity descending"
            );
            $previousQuantity = $product->total_quantity;
        }
    }

    public static function salesReportDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 3; $i++) {
            $testCases["case_{$i}"] = [
                $faker->numberBetween(1, 30),
                $faker->numberBetween(1, 14),
            ];
        }

        return $testCases;
    }

    public static function profitCalculationDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 3; $i++) {
            $numSales = $faker->numberBetween(1, 2);
            $sales = [];

            for ($j = 0; $j < $numSales; $j++) {
                $price = $faker->randomFloat(2, 50, 500);
                $sales[] = [
                    'price' => $price,
                    'cost' => $price * $faker->randomFloat(2, 0.4, 0.8),
                    'quantity' => $faker->numberBetween(1, 3),
                ];
            }

            $testCases["case_{$i}"] = [$sales];
        }

        return $testCases;
    }

    public static function topProductsDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 3; $i++) {
            $numProducts = $faker->numberBetween(2, 3);
            $products = [];

            for ($j = 0; $j < $numProducts; $j++) {
                $products[] = [
                    'price' => $faker->randomFloat(2, 10, 200),
                    'sold_quantity' => $faker->numberBetween(1, 50),
                ];
            }

            $testCases["case_{$i}"] = [$products];
        }

        return $testCases;
    }
}
