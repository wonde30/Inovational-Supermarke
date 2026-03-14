<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\StockAlert;
use Illuminate\Console\Command;

class GenerateStockAlerts extends Command
{
    protected $signature = 'alerts:generate';
    protected $description = 'Generate stock alerts for low stock products';

    public function handle()
    {
        $products = Product::whereColumn('quantity', '<=', 'reorder_level')->get();
        
        foreach ($products as $product) {
            $product->checkAndCreateAlerts();
        }

        $this->info('Stock alerts generated: ' . StockAlert::count());
    }
}
