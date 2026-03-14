<?php
/**
 * Download real product images from Unsplash/Pexels (free to use)
 * These are placeholder URLs that work offline once downloaded
 */

$products = [
    1 => ['name' => 'Samsung Galaxy A14', 'search' => 'smartphone'],
    2 => ['name' => 'Tecno Spark 10', 'search' => 'android phone'],
    3 => ['name' => 'Phone Charger USB-C', 'search' => 'phone charger'],
    4 => ['name' => 'Earphones Wired', 'search' => 'earphones'],
    5 => ['name' => 'Power Bank 10000mAh', 'search' => 'power bank'],
    6 => ['name' => 'Bluetooth Speaker', 'search' => 'bluetooth speaker'],
    7 => ['name' => 'Teff Flour 25kg', 'search' => 'flour bag'],
    8 => ['name' => 'Cooking Oil 3L', 'search' => 'cooking oil bottle'],
    9 => ['name' => 'Sugar 1kg', 'search' => 'sugar package'],
    10 => ['name' => 'Coffee Beans 500g', 'search' => 'coffee beans'],
    11 => ['name' => 'Rice 5kg', 'search' => 'rice bag'],
    12 => ['name' => 'Pasta 500g', 'search' => 'pasta package'],
    13 => ['name' => 'Men T-Shirt', 'search' => 'tshirt'],
    14 => ['name' => 'Women Dress', 'search' => 'dress'],
    15 => ['name' => 'Children Shoes', 'search' => 'kids shoes'],
    16 => ['name' => 'Men Jeans', 'search' => 'jeans'],
    17 => ['name' => 'Socks Pack (3)', 'search' => 'socks'],
    18 => ['name' => 'Plastic Bucket 20L', 'search' => 'plastic bucket'],
    19 => ['name' => 'Broom', 'search' => 'broom'],
    20 => ['name' => 'Dish Soap 500ml', 'search' => 'dish soap'],
    21 => ['name' => 'Laundry Detergent 1kg', 'search' => 'detergent'],
    22 => ['name' => 'Plastic Chairs', 'search' => 'plastic chair'],
    23 => ['name' => 'Exercise Book 100pg', 'search' => 'notebook'],
    24 => ['name' => 'Ball Pen Blue', 'search' => 'pen'],
    25 => ['name' => 'Pencil HB', 'search' => 'pencil'],
    26 => ['name' => 'A4 Paper Ream', 'search' => 'paper stack'],
    27 => ['name' => 'Ruler 30cm', 'search' => 'ruler'],
    28 => ['name' => 'Body Lotion 400ml', 'search' => 'lotion bottle'],
    29 => ['name' => 'Shampoo 500ml', 'search' => 'shampoo bottle'],
    30 => ['name' => 'Soap Bar', 'search' => 'soap bar'],
    31 => ['name' => 'Toothpaste 100ml', 'search' => 'toothpaste'],
    32 => ['name' => 'Vaseline 250ml', 'search' => 'vaseline jar'],
];

// Using picsum.photos for placeholder images (works offline once cached)
// In production, you would upload real product photos

$imageDir = __DIR__ . '/../frontend/public/images/products/';

if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
}

echo "Product images directory: $imageDir\n";
echo "Images will be served from /images/products/\n";
