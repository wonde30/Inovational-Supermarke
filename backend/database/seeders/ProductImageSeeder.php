<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Map product IDs to their image files
        // Images should be placed in frontend/public/images/products/
        $products = Product::all();
        
        foreach ($products as $product) {
            // Use product ID as image filename (JPG format - real photos)
            $product->update(['image' => '/images/products/' . $product->id . '.jpg']);
        }
        
        $this->command->info('Product images updated with real JPG photos!');
        $this->command->info('Images are in frontend/public/images/products/ (1.jpg, 2.jpg, etc.)');
    }
}
