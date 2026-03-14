<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $today = now()->startOfDay();

        // Today's sales total
        $todaySales = Sale::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        // Total products count
        $totalProducts = Product::where('active', true)->count();

        // Low stock count
        $lowStockCount = Product::where('active', true)
            ->whereColumn('quantity', '<', 'reorder_level')
            ->count();

        // Recent sales (last 10)
        $recentSales = Sale::with('user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Monthly sales (current month)
        $monthlySales = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('total');

        // Total customers
        $totalCustomers = \App\Models\Customer::count();

        return $this->success([
            'today_sales' => round($todaySales, 2),
            'monthly_sales' => round($monthlySales, 2),
            'total_products' => $totalProducts,
            'low_stock_count' => $lowStockCount,
            'total_customers' => $totalCustomers,
            'recent_sales' => $recentSales,
        ]);
    }
}
