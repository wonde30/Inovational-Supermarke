<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get first 5 products with QR codes
$products = \App\Models\Product::whereNotNull('qr_code')->limit(5)->get();

echo "\n=== QR CODES GENERATED ===\n\n";

foreach ($products as $product) {
    echo "Product: {$product->name}\n";
    echo "QR Code: {$product->qr_code}\n";
    echo "Price: ETB {$product->price}\n";
    echo "Stock: {$product->quantity}\n";
    echo "---\n\n";
}

echo "✅ Total products with QR codes: " . \App\Models\Product::whereNotNull('qr_code')->count() . "\n\n";
