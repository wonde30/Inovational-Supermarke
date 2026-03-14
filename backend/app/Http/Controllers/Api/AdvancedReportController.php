<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\DailySummary;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockAlert;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancedReportController extends Controller
{
    use ApiResponse;

    /**
     * Get stock alerts (low stock, expiring, expired)
     */
    public function stockAlerts(Request $request)
    {
        // First, scan all products and generate any missing alerts
        $this->generateMissingAlerts();
        
        $alerts = StockAlert::with('product.category')
            ->where('is_resolved', false)
            ->orderByDesc('created_at')
            ->get();

        // Group by type
        $grouped = [
            'out_of_stock' => $alerts->where('alert_type', 'out_of_stock')->values(),
            'low_stock' => $alerts->where('alert_type', 'low_stock')->values(),
            'expiring_soon' => $alerts->where('alert_type', 'expiring_soon')->values(),
            'expired' => $alerts->where('alert_type', 'expired')->values(),
        ];

        return $this->success([
            'alerts' => $alerts,
            'grouped' => $grouped,
            'counts' => [
                'out_of_stock' => $grouped['out_of_stock']->count(),
                'low_stock' => $grouped['low_stock']->count(),
                'expiring_soon' => $grouped['expiring_soon']->count(),
                'expired' => $grouped['expired']->count(),
                'total' => $alerts->count(),
            ]
        ], 'Stock alerts retrieved');
    }

    /**
     * Get stock alert statistics for notifications
     */
    public function stockAlertStatistics()
    {
        // Generate any missing alerts first
        $this->generateMissingAlerts();
        
        $alerts = StockAlert::where('is_resolved', false)->get();
        
        $counts = [
            'out_of_stock' => $alerts->where('alert_type', 'out_of_stock')->count(),
            'low_stock' => $alerts->where('alert_type', 'low_stock')->count(),
            'expiring_soon' => $alerts->where('alert_type', 'expiring_soon')->count(),
            'expired' => $alerts->where('alert_type', 'expired')->count(),
            'total' => $alerts->count(),
        ];

        // Get recent alerts (last 5 minutes) for notifications
        $recentAlerts = StockAlert::with('product')
            ->where('is_resolved', false)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($alert) {
                return [
                    'id' => $alert->id,
                    'type' => $alert->alert_type,
                    'product_name' => $alert->product->name,
                    'product_sku' => $alert->product->sku,
                    'current_stock' => $alert->product->quantity,
                    'created_at' => $alert->created_at,
                ];
            });

        return $this->success([
            'counts' => $counts,
            'recent_alerts' => $recentAlerts,
            'timestamp' => now(),
        ], 'Stock alert statistics retrieved');
    }

    /**
     * Generate missing stock alerts for all products
     */
    private function generateMissingAlerts()
    {
        // Get all products (include inactive to track all inventory)
        $products = Product::all();
        
        foreach ($products as $product) {
            // Check for out of stock (quantity is 0 or less)
            if ($product->quantity <= 0) {
                StockAlert::createIfNotExists($product->id, 'out_of_stock');
                // Also resolve any low_stock alert since it's now out_of_stock
                StockAlert::where('product_id', $product->id)
                    ->where('alert_type', 'low_stock')
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            } 
            // Check for low stock (quantity > 0 but <= reorder_level, and reorder_level > 0)
            elseif ($product->reorder_level > 0 && $product->quantity <= $product->reorder_level) {
                StockAlert::createIfNotExists($product->id, 'low_stock');
                // Resolve any out_of_stock alert since we have some stock now
                StockAlert::where('product_id', $product->id)
                    ->where('alert_type', 'out_of_stock')
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            }
            // Stock is healthy - resolve any stock alerts
            else {
                StockAlert::where('product_id', $product->id)
                    ->whereIn('alert_type', ['low_stock', 'out_of_stock'])
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            }
            
            // Check for expired products (expiry_date is in the past)
            if ($product->expiry_date && $product->expiry_date->isPast()) {
                StockAlert::createIfNotExists($product->id, 'expired');
                // Resolve expiring_soon since it's now expired
                StockAlert::where('product_id', $product->id)
                    ->where('alert_type', 'expiring_soon')
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            }
            // Check for expiring soon (within 30 days and not yet expired)
            elseif ($product->expiry_date && $product->expiry_date->isFuture() && $product->expiry_date->diffInDays(now()) <= 30) {
                StockAlert::createIfNotExists($product->id, 'expiring_soon');
                // Resolve any expired alert if product is not actually expired
                StockAlert::where('product_id', $product->id)
                    ->where('alert_type', 'expired')
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            }
            // Expiry is healthy (more than 30 days or no expiry) - resolve expiry alerts
            else {
                StockAlert::where('product_id', $product->id)
                    ->whereIn('alert_type', ['expiring_soon', 'expired'])
                    ->where('is_resolved', false)
                    ->update(['is_resolved' => true, 'resolved_at' => now()]);
            }
        }
    }

    /**
     * Resolve a stock alert
     */
    public function resolveAlert(StockAlert $alert)
    {
        $alert->resolve();
        AuditLog::log('resolve_alert', 'StockAlert', $alert->id, null, null, 'Resolved stock alert');
        
        return $this->success($alert, 'Alert resolved');
    }

    /**
     * Get audit logs for fraud prevention
     */
    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user')
            ->orderByDesc('created_at');

        if ($request->has('action')) {
            $query->where('action', $request->action);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate($request->get('per_page', 50));

        return $this->paginated($logs, 'Audit logs retrieved');
    }

    /**
     * Get daily summary
     */
    public function dailySummary(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        
        // Generate or get existing summary
        $summary = DailySummary::generateForDate($date);

        return $this->success($summary, 'Daily summary retrieved');
    }

    /**
     * Get cashier performance report
     */
    public function cashierPerformance(Request $request)
    {
        $startDate = $request->get('start_date', today()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', today()->toDateString());

        $performance = Sale::with('user')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select('user_id', 
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('AVG(total) as average_sale'),
                DB::raw('SUM(discount) as total_discounts')
            )
            ->groupBy('user_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'name' => $item->user->name ?? 'Unknown',
                    'transaction_count' => $item->transaction_count,
                    'total_sales' => $item->total_sales,
                    'average_sale' => round($item->average_sale, 2),
                    'total_discounts' => $item->total_discounts,
                ];
            });

        return $this->success($performance, 'Cashier performance retrieved');
    }

    /**
     * Get product profitability ranking
     */
    public function productProfitability(Request $request)
    {
        $startDate = $request->get('start_date', today()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', today()->toDateString());

        $products = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(sale_items.quantity) as units_sold'),
                DB::raw('SUM(sale_items.total) as revenue'),
                DB::raw('SUM(sale_items.quantity * products.cost) as cost'),
                DB::raw('SUM(sale_items.total) - SUM(sale_items.quantity * products.cost) as profit')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('profit')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                $item->profit_margin = $item->revenue > 0 
                    ? round(($item->profit / $item->revenue) * 100, 2) 
                    : 0;
                return $item;
            });

        return $this->success($products, 'Product profitability retrieved');
    }

    /**
     * Get dead stock (slow moving items)
     */
    public function deadStock()
    {
        // Products with no sales in last 60 days
        $deadStock = Product::whereDoesntHave('saleItems', function ($query) {
                $query->whereHas('sale', fn($q) => $q->where('created_at', '>=', now()->subDays(60)));
            })
            ->where('quantity', '>', 0)
            ->with('category')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category->name ?? 'N/A',
                    'quantity' => $product->quantity,
                    'value' => $product->quantity * $product->cost,
                    'days_without_sale' => 60,
                ];
            });

        $totalValue = $deadStock->sum('value');

        return $this->success([
            'products' => $deadStock,
            'total_items' => $deadStock->count(),
            'total_value' => $totalValue,
        ], 'Dead stock retrieved');
    }

    /**
     * Get expiring products (FIFO enforcement)
     */
    public function expiringProducts()
    {
        $products = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(60))
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date')
            ->with('category')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'batch_number' => $product->batch_number,
                    'category' => $product->category->name ?? 'N/A',
                    'quantity' => $product->quantity,
                    'expiry_date' => $product->expiry_date->format('Y-m-d'),
                    'days_until_expiry' => $product->expiry_date->diffInDays(now(), false),
                    'is_expired' => $product->is_expired,
                    'status' => $product->is_expired ? 'EXPIRED' : ($product->is_expiring_soon ? 'EXPIRING SOON' : 'OK'),
                ];
            });

        return $this->success([
            'products' => $products,
            'expired_count' => $products->where('is_expired', true)->count(),
            'expiring_soon_count' => $products->where('status', 'EXPIRING SOON')->count(),
        ], 'Expiring products retrieved');
    }

    /**
     * Get sales trend (moving average)
     */
    public function salesTrend(Request $request)
    {
        $days = $request->get('days', 30);
        
        $dailySales = Sale::where('created_at', '>=', now()->subDays($days))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as transactions')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate 7-day moving average
        $trend = [];
        $salesArray = $dailySales->toArray();
        
        for ($i = 0; $i < count($salesArray); $i++) {
            $start = max(0, $i - 6);
            $slice = array_slice($salesArray, $start, $i - $start + 1);
            $movingAvg = count($slice) > 0 ? array_sum(array_column($slice, 'total')) / count($slice) : 0;
            
            $trend[] = [
                'date' => $salesArray[$i]['date'],
                'total' => $salesArray[$i]['total'],
                'transactions' => $salesArray[$i]['transactions'],
                'moving_average' => round($movingAvg, 2),
            ];
        }

        return $this->success([
            'trend' => $trend,
            'period_total' => $dailySales->sum('total'),
            'period_transactions' => $dailySales->sum('transactions'),
            'daily_average' => $dailySales->count() > 0 ? round($dailySales->sum('total') / $dailySales->count(), 2) : 0,
        ], 'Sales trend retrieved');
    }

    /**
     * Generate and export report (PDF/CSV ready)
     */
    public function exportReport(Request $request)
    {
        $type = $request->get('type', 'daily');
        $format = $request->get('format', 'json');
        $date = $request->get('date', today()->toDateString());

        $data = [];

        switch ($type) {
            case 'daily':
                $data = DailySummary::generateForDate($date)->toArray();
                break;
            case 'stock':
                $data = Product::with('category')->get()->toArray();
                break;
            case 'sales':
                $data = Sale::with(['user', 'saleItems.product'])
                    ->whereDate('created_at', $date)
                    ->get()
                    ->toArray();
                break;
        }

        if ($format === 'csv') {
            // Return CSV-ready data
            return response()->json([
                'success' => true,
                'data' => $data,
                'format' => 'csv',
                'filename' => "ibms_{$type}_report_{$date}.csv"
            ]);
        }

        return $this->success($data, 'Report generated');
    }
}
