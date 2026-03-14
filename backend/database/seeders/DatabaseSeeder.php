<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========== USERS ==========
        // Admin (Business Owner)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Wonde IT',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Manager
        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Tigist Haile',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ]
        );

        // Cashiers
        User::firstOrCreate(
            ['email' => 'cashier1@example.com'],
            [
                'name' => 'Dawit Tesfaye',
                'password' => Hash::make('password'),
                'role' => 'cashier',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'cashier2@example.com'],
            [
                'name' => 'Meron Alemu',
                'password' => Hash::make('password'),
                'role' => 'cashier',
                'email_verified_at' => now(),
            ]
        );

        // Manager (former storekeeper responsibilities)
        User::firstOrCreate(
            ['email' => 'manager2@example.com'],
            [
                'name' => 'Kebede Worku',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ]
        );

        // Customer
        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Almaz Tadesse',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Delivery Staff
        User::firstOrCreate(
            ['email' => 'delivery@example.com'],
            [
                'name' => 'Getachew Tadesse',
                'password' => Hash::make('password'),
                'role' => 'delivery_staff',
                'email_verified_at' => now(),
            ]
        );

        // Supplier
        User::firstOrCreate(
            ['email' => 'supplier@example.com'],
            [
                'name' => 'Haile Suppliers Ltd',
                'password' => Hash::make('password'),
                'role' => 'supplier',
                'email_verified_at' => now(),
            ]
        );

        // ========== CATEGORIES ==========
        $food = Category::firstOrCreate(['name' => 'Food & Beverages'], ['description' => 'Food items and drinks']);
        $electronics = Category::firstOrCreate(['name' => 'Electronics'], ['description' => 'Electronic devices and accessories']);
        $clothing = Category::firstOrCreate(['name' => 'Clothing'], ['description' => 'Clothes and fashion items']);
        $household = Category::firstOrCreate(['name' => 'Household'], ['description' => 'Home and cleaning supplies']);
        $stationery = Category::firstOrCreate(['name' => 'Stationery'], ['description' => 'Office and school supplies']);
        $cosmetics = Category::firstOrCreate(['name' => 'Cosmetics'], ['description' => 'Beauty and personal care products']);

        // ========== PRODUCTS ==========
        $products = [
            // Food & Beverages
            ['sku' => 'FOOD-001', 'name' => 'Teff Flour 25kg', 'description' => 'Ethiopian teff flour', 'price' => 2800, 'cost' => 2400, 'quantity' => 30, 'reorder_level' => 10, 'category_id' => $food->id, 'image' => 'images/products/teff-flour.jpg'],
            ['sku' => 'FOOD-002', 'name' => 'Rice 5kg', 'description' => 'Long grain white rice', 'price' => 450, 'cost' => 350, 'quantity' => 50, 'reorder_level' => 15, 'category_id' => $food->id, 'image' => 'images/products/rice.jpg'],
            ['sku' => 'FOOD-003', 'name' => 'Sugar 1kg', 'description' => 'White granulated sugar', 'price' => 85, 'cost' => 65, 'quantity' => 100, 'reorder_level' => 30, 'category_id' => $food->id, 'image' => 'images/products/sugar.jpg'],
            ['sku' => 'FOOD-004', 'name' => 'Cooking Oil 1L', 'description' => 'Vegetable cooking oil', 'price' => 180, 'cost' => 140, 'quantity' => 60, 'reorder_level' => 20, 'category_id' => $food->id, 'image' => 'images/products/cooking-oil.jpg'],
            ['sku' => 'FOOD-005', 'name' => 'Coffee Beans 500g', 'description' => 'Ethiopian coffee beans', 'price' => 320, 'cost' => 250, 'quantity' => 40, 'reorder_level' => 12, 'category_id' => $food->id, 'image' => 'images/products/coffee-beans.jpg'],
            ['sku' => 'FOOD-006', 'name' => 'Pasta 500g', 'description' => 'Italian pasta', 'price' => 65, 'cost' => 45, 'quantity' => 80, 'reorder_level' => 25, 'category_id' => $food->id, 'image' => 'images/products/pasta.jpg'],

            // Electronics
            ['sku' => 'ELEC-001', 'name' => 'Samsung Galaxy A14', 'description' => 'Smartphone 128GB', 'price' => 12500, 'cost' => 10000, 'quantity' => 15, 'reorder_level' => 5, 'category_id' => $electronics->id, 'image' => 'images/products/samsung-galaxy-a14.jpg'],
            ['sku' => 'ELEC-002', 'name' => 'Tecno Spark 10', 'description' => 'Smartphone 64GB', 'price' => 8500, 'cost' => 7000, 'quantity' => 20, 'reorder_level' => 6, 'category_id' => $electronics->id, 'image' => 'images/products/tecno-spark.jpg'],
            ['sku' => 'ELEC-003', 'name' => 'Phone Charger USB-C', 'description' => 'Fast charging cable', 'price' => 250, 'cost' => 150, 'quantity' => 50, 'reorder_level' => 15, 'category_id' => $electronics->id, 'image' => 'images/products/phone-charger.jpg'],
            ['sku' => 'ELEC-004', 'name' => 'Earphones', 'description' => 'Wired earphones with mic', 'price' => 180, 'cost' => 120, 'quantity' => 40, 'reorder_level' => 12, 'category_id' => $electronics->id, 'image' => 'images/products/earphones.jpg'],
            ['sku' => 'ELEC-005', 'name' => 'Power Bank 10000mAh', 'description' => 'Portable charger', 'price' => 850, 'cost' => 600, 'quantity' => 25, 'reorder_level' => 8, 'category_id' => $electronics->id, 'image' => 'images/products/power-bank.jpg'],
            ['sku' => 'ELEC-006', 'name' => 'Bluetooth Speaker', 'description' => 'Portable wireless speaker', 'price' => 1200, 'cost' => 900, 'quantity' => 18, 'reorder_level' => 6, 'category_id' => $electronics->id, 'image' => 'images/products/bluetooth-speaker.jpg'],

            // Clothing
            ['sku' => 'CLTH-001', 'name' => 'Men T-Shirt', 'description' => 'Cotton t-shirt size L', 'price' => 350, 'cost' => 220, 'quantity' => 40, 'reorder_level' => 12, 'category_id' => $clothing->id, 'image' => 'images/products/men-tshirt.jpg'],
            ['sku' => 'CLTH-002', 'name' => 'Women Dress', 'description' => 'Casual dress size M', 'price' => 850, 'cost' => 550, 'quantity' => 30, 'reorder_level' => 10, 'category_id' => $clothing->id, 'image' => 'images/products/women-dress.jpg'],
            ['sku' => 'CLTH-003', 'name' => 'Children Shoes', 'description' => 'School shoes black', 'price' => 650, 'cost' => 420, 'quantity' => 25, 'reorder_level' => 8, 'category_id' => $clothing->id, 'image' => 'images/products/children-shoes.jpg'],
            ['sku' => 'CLTH-004', 'name' => 'Men Jeans', 'description' => 'Denim jeans blue', 'price' => 950, 'cost' => 600, 'quantity' => 20, 'reorder_level' => 6, 'category_id' => $clothing->id, 'image' => 'images/products/men-jeans.jpg'],
            ['sku' => 'CLTH-005', 'name' => 'Socks Pack (3)', 'description' => 'Cotton socks pack of 3', 'price' => 120, 'cost' => 70, 'quantity' => 60, 'reorder_level' => 20, 'category_id' => $clothing->id, 'image' => 'images/products/socks.jpg'],

            // Household
            ['sku' => 'HOME-001', 'name' => 'Plastic Bucket 20L', 'description' => 'Heavy duty plastic bucket', 'price' => 180, 'cost' => 120, 'quantity' => 30, 'reorder_level' => 10, 'category_id' => $household->id, 'image' => 'images/products/plastic-bucket.jpg'],
            ['sku' => 'HOME-002', 'name' => 'Broom', 'description' => 'Traditional grass broom', 'price' => 85, 'cost' => 50, 'quantity' => 25, 'reorder_level' => 8, 'category_id' => $household->id, 'image' => 'images/products/broom.jpg'],
            ['sku' => 'HOME-003', 'name' => 'Dish Soap 500ml', 'description' => 'Liquid dish washing soap', 'price' => 75, 'cost' => 50, 'quantity' => 50, 'reorder_level' => 15, 'category_id' => $household->id, 'image' => 'images/products/dish-soap.jpg'],
            ['sku' => 'HOME-004', 'name' => 'Laundry Detergent 1kg', 'description' => 'Powder detergent', 'price' => 145, 'cost' => 100, 'quantity' => 40, 'reorder_level' => 12, 'category_id' => $household->id, 'image' => 'images/products/laundry-detergent.jpg'],
            ['sku' => 'HOME-005', 'name' => 'Plastic Chairs', 'description' => 'Stackable plastic chair', 'price' => 450, 'cost' => 300, 'quantity' => 20, 'reorder_level' => 5, 'category_id' => $household->id, 'image' => 'images/products/plastic-chair.jpg'],

            // Stationery
            ['sku' => 'STAT-001', 'name' => 'Exercise Book 100pg', 'description' => 'Ruled exercise book', 'price' => 25, 'cost' => 15, 'quantity' => 200, 'reorder_level' => 50, 'category_id' => $stationery->id, 'image' => 'images/products/exercise-book.jpg'],
            ['sku' => 'STAT-002', 'name' => 'Ball Pen Blue', 'description' => 'Blue ink ball pen', 'price' => 15, 'cost' => 8, 'quantity' => 300, 'reorder_level' => 80, 'category_id' => $stationery->id, 'image' => 'images/products/pen.svg'],
            ['sku' => 'STAT-003', 'name' => 'Pencil HB', 'description' => 'HB graphite pencil', 'price' => 10, 'cost' => 5, 'quantity' => 250, 'reorder_level' => 60, 'category_id' => $stationery->id, 'image' => 'images/products/pencil.jpg'],
            ['sku' => 'STAT-004', 'name' => 'A4 Paper Ream', 'description' => '500 sheets white paper', 'price' => 380, 'cost' => 300, 'quantity' => 25, 'reorder_level' => 8, 'category_id' => $stationery->id, 'image' => 'images/products/a4-paper.jpg'],
            ['sku' => 'STAT-005', 'name' => 'Ruler 30cm', 'description' => 'Plastic ruler', 'price' => 20, 'cost' => 10, 'quantity' => 100, 'reorder_level' => 30, 'category_id' => $stationery->id, 'image' => 'images/products/ruler.jpg'],

            // Cosmetics
            ['sku' => 'COSM-001', 'name' => 'Body Lotion 400ml', 'description' => 'Moisturizing body lotion', 'price' => 180, 'cost' => 120, 'quantity' => 35, 'reorder_level' => 10, 'category_id' => $cosmetics->id, 'image' => 'images/products/body-lotion.jpg'],
            ['sku' => 'COSM-002', 'name' => 'Shampoo 500ml', 'description' => 'Hair shampoo', 'price' => 150, 'cost' => 95, 'quantity' => 40, 'reorder_level' => 12, 'category_id' => $cosmetics->id, 'image' => 'images/products/shampoo.jpg'],
            ['sku' => 'COSM-003', 'name' => 'Soap Bar', 'description' => 'Bath soap 125g', 'price' => 35, 'cost' => 22, 'quantity' => 100, 'reorder_level' => 30, 'category_id' => $cosmetics->id, 'image' => 'images/products/soap-bar.jpg'],
            ['sku' => 'COSM-004', 'name' => 'Toothpaste 100ml', 'description' => 'Fluoride toothpaste', 'price' => 65, 'cost' => 42, 'quantity' => 60, 'reorder_level' => 20, 'category_id' => $cosmetics->id, 'image' => 'images/products/toothpaste.jpg'],
            ['sku' => 'COSM-005', 'name' => 'Vaseline 250ml', 'description' => 'Petroleum jelly', 'price' => 120, 'cost' => 80, 'quantity' => 45, 'reorder_level' => 15, 'category_id' => $cosmetics->id, 'image' => 'images/products/vaseline.jpg'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }

        // ========== CUSTOMERS ==========
        $customers = [
            ['name' => 'Almaz Tadesse', 'email' => 'almaz@email.com', 'phone' => '+251911234567', 'address' => 'Kombolcha, Zone 1'],
            ['name' => 'Bekele Girma', 'email' => 'bekele@email.com', 'phone' => '+251922345678', 'address' => 'Kombolcha, Kebele 02'],
            ['name' => 'Chaltu Mohammed', 'email' => 'chaltu@email.com', 'phone' => '+251933456789', 'address' => 'Dessie Road, Kombolcha'],
            ['name' => 'Daniel Assefa', 'email' => 'daniel@email.com', 'phone' => '+251944567890', 'address' => 'Industrial Area, Kombolcha'],
            ['name' => 'Eyerusalem Hailu', 'email' => 'eyerusalem@email.com', 'phone' => '+251955678901', 'address' => 'Main Street, Kombolcha'],
            ['name' => 'Fikadu Worku', 'email' => 'fikadu@email.com', 'phone' => '+251966789012', 'address' => 'Market Area, Kombolcha'],
            ['name' => 'Genet Tesfaye', 'email' => 'genet@email.com', 'phone' => '+251977890123', 'address' => 'Bus Station Area, Kombolcha'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }

        // ========== SUPPLIERS ==========
        $suppliers = [
            ['name' => 'Addis Electronics Import', 'email' => 'addis.electronics@email.com', 'phone' => '+251111234567', 'address' => 'Merkato, Addis Ababa', 'contact_person' => 'Ato Tadesse'],
            ['name' => 'Kombolcha Wholesale', 'email' => 'kombolcha.wholesale@email.com', 'phone' => '+251112345678', 'address' => 'Industrial Zone, Kombolcha', 'contact_person' => 'W/ro Tigist'],
            ['name' => 'Dessie Trading PLC', 'email' => 'dessie.trading@email.com', 'phone' => '+251113456789', 'address' => 'Dessie Town', 'contact_person' => 'Ato Mulugeta'],
            ['name' => 'Bahir Dar Textiles', 'email' => 'bd.textiles@email.com', 'phone' => '+251114567890', 'address' => 'Bahir Dar', 'contact_person' => 'Ato Yohannes'],
            ['name' => 'Hawassa Food Distributors', 'email' => 'hawassa.food@email.com', 'phone' => '+251115678901', 'address' => 'Hawassa', 'contact_person' => 'W/ro Marta'],
            ['name' => 'Mekelle Cosmetics', 'email' => 'mekelle.cosmetics@email.com', 'phone' => '+251116789012', 'address' => 'Mekelle', 'contact_person' => 'Ato Gebru'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['email' => $supplier['email']], $supplier);
        }

        echo "\n✅ Database seeded with Ethiopian/Kombolcha sample data!\n";
        echo "📦 Products: 32 items across 6 categories\n";
        echo "👥 Users: 8 (admin, 2 managers, 2 cashiers, customer, delivery staff, supplier)\n";
        echo "🛒 Customers: 7\n";
        echo "🚚 Suppliers: 6\n\n";
    }
}
