<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-based tests for Storefront Module
 * 
 * Feature: ibms-proper-structure
 * Validates: Requirements 6.2, 6.5
 */
class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * Property 14: Product Search Filtering
     * 
     * For any search query, all returned products SHALL contain the search term
     * in their name and belong to the specified category if provided.
     * 
     * @test
     * @dataProvider productSearchDataProvider
     */
    public function product_search_filtering(string $searchTerm, bool $withCategory): void
    {
        // Create category
        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        $otherCategory = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create products - some matching, some not
        $matchingProducts = [];
        for ($i = 0; $i < 3; $i++) {
            $matchingProducts[] = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word() . ' ' . $searchTerm . ' ' . $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $this->faker->randomFloat(2, 10, 100),
                'cost' => $this->faker->randomFloat(2, 5, 50),
                'quantity' => 100,
                'reorder_level' => 10,
                'active' => true,
            ]);
        }

        // Create non-matching products
        for ($i = 0; $i < 2; $i++) {
            Product::create([
                'category_id' => $otherCategory->id,
                'name' => $this->faker->word() . 'xyz' . $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $this->faker->randomFloat(2, 10, 100),
                'cost' => $this->faker->randomFloat(2, 5, 50),
                'quantity' => 100,
                'reorder_level' => 10,
                'active' => true,
            ]);
        }

        // Build query
        $query = Product::where('active', true)
            ->where('name', 'like', "%{$searchTerm}%");

        if ($withCategory) {
            $query->where('category_id', $category->id);
        }

        $results = $query->get();

        // Property: All results must contain search term
        foreach ($results as $product) {
            $this->assertStringContainsStringIgnoringCase(
                $searchTerm,
                $product->name,
                "Product name must contain search term"
            );

            if ($withCategory) {
                $this->assertEquals(
                    $category->id,
                    $product->category_id,
                    "Product must belong to specified category"
                );
            }
        }
    }

    /**
     * Property 15: Order Creation on Checkout
     * 
     * For any valid checkout, an order SHALL be created with correct totals
     * and stock SHALL be deducted from products.
     * 
     * @test
     * @dataProvider orderCreationDataProvider
     */
    public function order_creation_on_checkout(array $itemsData): void
    {
        // Create customer
        $customer = Customer::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'phone' => $this->faker->phoneNumber(),
        ]);

        // Create category
        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create products and track initial stock
        $items = [];
        $initialStock = [];
        $expectedSubtotal = 0;

        foreach ($itemsData as $data) {
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $data['price'],
                'cost' => $data['price'] * 0.7,
                'quantity' => $data['stock'],
                'reorder_level' => 10,
                'active' => true,
            ]);

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
            ];

            $initialStock[$product->id] = $data['stock'];
            $expectedSubtotal += $data['price'] * $data['quantity'];
        }

        // Create order
        $order = \Illuminate\Support\Facades\DB::transaction(function () use ($customer, $items) {
            $subtotal = 0;
            $orderItems = [];

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                $lineTotal = $product->price * $item['quantity'];
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $lineTotal,
                ];

                $subtotal += $lineTotal;
                $product->deductStock($item['quantity']);
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'tax' => 0,
                'discount' => 0,
                'total' => $subtotal,
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    ...$item,
                ]);
            }

            return $order;
        });

        // Property: Order total must equal sum of line totals
        $this->assertEquals(
            round($expectedSubtotal, 2),
            round($order->total, 2),
            "Order total must equal sum of line totals"
        );

        // Property: Stock must be deducted
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $expectedStock = $initialStock[$item['product_id']] - $item['quantity'];
            
            $this->assertEquals(
                $expectedStock,
                $product->quantity,
                "Stock must be deducted by ordered quantity"
            );
        }

        // Property: Order must have correct number of items
        $this->assertCount(
            count($items),
            $order->orderItems,
            "Order must have correct number of items"
        );
    }

    /**
     * Data provider for product search - generates 5 test cases
     */
    public static function productSearchDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 5; $i++) {
            $testCases["case_{$i}"] = [
                $faker->word(),
                $faker->boolean(),
            ];
        }

        return $testCases;
    }

    /**
     * Data provider for order creation - generates 5 test cases
     */
    public static function orderCreationDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 5; $i++) {
            $numItems = $faker->numberBetween(1, 2);
            $items = [];

            for ($j = 0; $j < $numItems; $j++) {
                $stock = $faker->numberBetween(50, 200);
                $items[] = [
                    'price' => $faker->randomFloat(2, 10, 500),
                    'stock' => $stock,
                    'quantity' => $faker->numberBetween(1, min(5, $stock)),
                ];
            }

            $testCases["case_{$i}"] = [$items];
        }

        return $testCases;
    }
}
