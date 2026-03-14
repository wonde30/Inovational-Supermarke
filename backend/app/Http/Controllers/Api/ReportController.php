<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use ApiResponse;

    public function salesReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Sale::with('user', 'saleItems.product')
            ->where('status', 'completed');

        if (isset($validated['start_date'])) {
            $query->whereDate('created_at', '>=', $validated['start_date']);
        }

        if (isset($validated['end_date'])) {
            $query->whereDate('created_at', '<=', $validated['end_date']);
        }

        $sales = $query->orderBy('created_at', 'desc')->get();

        $summary = [
            'total_sales' => $sales->count(),
            'total_revenue' => round($sales->sum('total'), 2),
            'total_tax' => round($sales->sum('tax'), 2),
            'total_discount' => round($sales->sum('discount'), 2),
            'average_sale' => $sales->count() > 0 
                ? round($sales->sum('total') / $sales->count(), 2) 
                : 0,
        ];

        return $this->success([
            'summary' => $summary,
            'sales' => $sales,
        ]);
    }

    public function profitReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.status', 'completed');

        if (isset($validated['start_date'])) {
            $query->whereDate('sales.created_at', '>=', $validated['start_date']);
        }

        if (isset($validated['end_date'])) {
            $query->whereDate('sales.created_at', '<=', $validated['end_date']);
        }

        $items = $query->select(
            'sale_items.*',
            'products.cost',
            'products.name as product_name'
        )->get();

        $totalRevenue = $items->sum('total');
        $totalCost = $items->sum(function ($item) {
            return $item->cost * $item->quantity;
        });
        $grossProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 
            ? ($grossProfit / $totalRevenue) * 100 
            : 0;

        return $this->success([
            'total_revenue' => round($totalRevenue, 2),
            'total_cost' => round($totalCost, 2),
            'gross_profit' => round($grossProfit, 2),
            'profit_margin' => round($profitMargin, 2),
        ]);
    }

    public function topProducts(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $limit = $validated['limit'] ?? 10;

        $query = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(sale_items.quantity) as total_quantity'),
                DB::raw('SUM(sale_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku');

        if (isset($validated['start_date'])) {
            $query->whereDate('sales.created_at', '>=', $validated['start_date']);
        }

        if (isset($validated['end_date'])) {
            $query->whereDate('sales.created_at', '<=', $validated['end_date']);
        }

        $topProducts = $query->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();

        return $this->success($topProducts);
    }
}
