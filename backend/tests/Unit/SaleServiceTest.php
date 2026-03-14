<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Services\SaleService;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-based tests for Sales Module
 * 
 * Feature: ibms-proper-structure
 * Validates: Requirements 5.3, 5.5, 5.6, 5.7
 */
class SaleServiceTest extends TestCase
{
    use RefreshDatabase;

    private $faker;
    private SaleService $saleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->saleService = new SaleService();
    }

    /**
     * Property 10: Cart Calculation Accuracy
     * 
     * For any cart state with items, the following SHALL hold:
     * - line_total = quantity * unit_price for each item
     * - subtotal = sum(line_totals)
     * - tax = subtotal * tax_rate
     * - total = subtotal + tax - discount
     * 
     * @test
     * @dataProvider cartCalculationDataProvider
     */
    public function cart_calculation_accuracy(
        array $productData,
        float $discount,
        float $taxRate
    ): void {
        // Create category
        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create products and prepare items
        $items = [];
        $expectedSubtotal = 0;

        foreach ($productData as $data) {
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $data['price'],
                'cost' => $data['price'] * 0.7,
                'quantity' => 1000, // Enough stock
                'reorder_level' => 10,
            ]);

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
            ];

            // Calculate expected line total
            $expectedSubtotal += $data['price'] * $data['quantity'];
        }

        // Calculate totals using service
        $result = $this->saleService->calculateTotals($items, $discount, $taxRate);

        // Property: subtotal = sum(line_totals)
        $this->assertEquals(
            round($expectedSubtotal, 2),
            $result['subtotal'],
            'Subtotal must equal sum of line totals'
        );

        // Property: tax = subtotal * tax_rate / 100
        $expectedTax = round(($expectedSubtotal * $taxRate) / 100, 2);
        $this->assertEquals(
            $expectedTax,
            $result['tax'],
            'Tax must equal subtotal * tax_rate / 100'
        );

        // Property: total = subtotal + tax - discount
        $expectedTotal = round(max(0, $expectedSubtotal + $expectedTax - $discount), 2);
        $this->assertEquals(
            $expectedTotal,
            $result['total'],
            'Total must equal subtotal + tax - discount'
        );

        // Property: line_total = quantity * unit_price for each item
        foreach ($result['items'] as $index => $item) {
            $expectedLineTotal = round($item['quantity'] * $item['unit_price'], 2);
            $this->assertEquals(
                $expectedLineTotal,
                $item['total'],
                "Line total for item {$index} must equal quantity * unit_price"
            );
        }
    }

    /**
     * Property 11: Invoice Number Uniqueness
     * 
     * For any two completed sales, their invoice numbers SHALL be different.
     * 
     * @test
     */
    public function invoice_number_uniqueness(): void
    {
        $invoiceNumbers = [];
        
        // Generate 20 invoice numbers
        for ($i = 0; $i < 20; $i++) {
            $invoiceNumber = Sale::generateInvoiceNumber();
            
            // Property: Each invoice number must be unique
            $this->assertNotContains(
                $invoiceNumber,
                $invoiceNumbers,
                "Invoice number {$invoiceNumber} was generated more than once"
            );
            
            $invoiceNumbers[] = $invoiceNumber;
        }

        // Verify all 20 are unique
        $this->assertCount(20, array_unique($invoiceNumbers));
    }

    /**
     * Property 12: Sale Stock Deduction
     * 
     * For any completed sale, for each sale item, the product's quantity
     * SHALL decrease by exactly the sold quantity.
     * 
     * @test
     * @dataProvider stockDeductionDataProvider
     */
    public function sale_stock_deduction(array $productData): void
    {
        // Create user
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('password'),
            'role' => 'cashier',
        ]);

        // Create category
        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create products and track initial quantities
        $items = [];
        $initialQuantities = [];

        foreach ($productData as $data) {
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $this->faker->word(),
                'sku' => $this->faker->unique()->uuid(),
                'price' => $data['price'],
                'cost' => $data['price'] * 0.7,
                'quantity' => $data['initial_stock'],
                'reorder_level' => 10,
            ]);

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $data['sale_quantity'],
            ];

            $initialQuantities[$product->id] = $data['initial_stock'];
        }

        // Create sale
        $sale = $this->saleService->createSale(
            userId: $user->id,
            items: $items,
            paymentMethod: 'cash'
        );

        // Property: Each product's quantity must decrease by exactly the sold quantity
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $expectedQuantity = $initialQuantities[$item['product_id']] - $item['quantity'];
            
            $this->assertEquals(
                $expectedQuantity,
                $product->quantity,
                "Product {$product->id} quantity must decrease by exactly {$item['quantity']}"
            );
        }
    }

    /**
     * Property 13: Stock Availability Enforcement
     * 
     * For any product, attempting to add a quantity greater than available_quantity
     * to a sale SHALL be rejected.
     * 
     * @test
     * @dataProvider stockAvailabilityDataProvider
     */
    public function stock_availability_enforcement(
        int $availableStock,
        int $requestedQuantity
    ): void {
        // Create category
        $category = Category::create([
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ]);

        // Create product with limited stock
        $product = Product::create([
            'category_id' => $category->id,
            'name' => $this->faker->word(),
            'sku' => $this->faker->unique()->uuid(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'cost' => $this->faker->randomFloat(2, 5, 500),
            'quantity' => $availableStock,
            'reorder_level' => 10,
        ]);

        $items = [
            ['product_id' => $product->id, 'quantity' => $requestedQuantity],
        ];

        $errors = $this->saleService->validateStockAvailability($items);

        if ($requestedQuantity > $availableStock) {
            // Property: Request exceeding available stock must be rejected
            $this->assertNotEmpty(
                $errors,
                "Request for {$requestedQuantity} units must be rejected when only {$availableStock} available"
            );
        } else {
            // Property: Request within available stock must be accepted
            $this->assertEmpty(
                $errors,
                "Request for {$requestedQuantity} units must be accepted when {$availableStock} available"
            );
        }
    }

    /**
     * Data provider for cart calculation - generates 10 random test cases
     */
    public static function cartCalculationDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 10; $i++) {
            $numProducts = $faker->numberBetween(1, 5);
            $productData = [];

            for ($j = 0; $j < $numProducts; $j++) {
                $productData[] = [
                    'price' => $faker->randomFloat(2, 1, 1000),
                    'quantity' => $faker->numberBetween(1, 10),
                ];
            }

            $testCases["case_{$i}"] = [
                $productData,
                $faker->randomFloat(2, 0, 100), // discount
                $faker->randomFloat(2, 0, 25),  // tax rate
            ];
        }

        return $testCases;
    }

    /**
     * Data provider for stock deduction - generates 10 random test cases
     */
    public static function stockDeductionDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 10; $i++) {
            $numProducts = $faker->numberBetween(1, 3);
            $productData = [];

            for ($j = 0; $j < $numProducts; $j++) {
                $initialStock = $faker->numberBetween(50, 200);
                $productData[] = [
                    'price' => $faker->randomFloat(2, 10, 500),
                    'initial_stock' => $initialStock,
                    'sale_quantity' => $faker->numberBetween(1, min(10, $initialStock)),
                ];
            }

            $testCases["case_{$i}"] = [$productData];
        }

        return $testCases;
    }

    /**
     * Data provider for stock availability - generates 10 random test cases
     */
    public static function stockAvailabilityDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];

        for ($i = 0; $i < 10; $i++) {
            $availableStock = $faker->numberBetween(1, 100);
            
            // Mix of valid and invalid requests
            $requestedQuantity = $faker->boolean(70)
                ? $faker->numberBetween(1, $availableStock) // Valid request
                : $faker->numberBetween($availableStock + 1, $availableStock + 50); // Invalid request

            $testCases["case_{$i}"] = [$availableStock, $requestedQuantity];
        }

        return $testCases;
    }
}
