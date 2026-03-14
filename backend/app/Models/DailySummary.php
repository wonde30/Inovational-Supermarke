<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailySummary extends Model
{
    protected $fillable = [
        'summary_date',
        'total_sales',
        'transaction_count',
        'total_cost',
        'gross_profit',
        'cash_sales',
        'credit_sales',
        'products_sold',
        'top_products',
        'cashier_performance',
    ];

    protected $casts = [
        'summary_date' => 'date',
        'total_sales' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'gross_profit' => 'decimal:2',
        'cash_sales' => 'decimal:2',
        'credit_sales' => 'decimal:2',
        'top_products' => 'array',
        'cashier_performance' => 'array',
    ];

    /**
     * Generate daily summary for a specific date
     */
    public static function generateForDate($date): self
    {
        $sales = Sale::whereDate('created_at', $date)->get();
        
        $totalSales = $sales->sum('total');
        $transactionCount = $sales->count();
        
        // Calculate cost from sale items
        $totalCost = 0;
        $productsSold = 0;
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $totalCost += ($item->product->cost ?? 0) * $item->quantity;
                $productsSold += $item->quantity;
            }
        }

        $cashSales = $sales->where('payment_method', 'cash')->sum('total');
        $creditSales = $sales->where('payment_method', 'credit')->sum('total');

        // Top products
        $topProducts = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.created_at', $date)
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as qty'), DB::raw('SUM(sale_items.total) as revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get()
            ->toArray();

        // Cashier performance
        $cashierPerformance = $sales->groupBy('user_id')->map(function ($userSales) {
            return [
                'name' => $userSales->first()->user->name ?? 'Unknown',
                'transactions' => $userSales->count(),
                'total' => $userSales->sum('total'),
            ];
        })->values()->toArray();

        return self::updateOrCreate(
            ['summary_date' => $date],
            [
                'total_sales' => $totalSales,
                'transaction_count' => $transactionCount,
                'total_cost' => $totalCost,
                'gross_profit' => $totalSales - $totalCost,
                'cash_sales' => $cashSales,
                'credit_sales' => $creditSales,
                'products_sold' => $productsSold,
                'top_products' => $topProducts,
                'cashier_performance' => $cashierPerformance,
            ]
        );
    }
}
