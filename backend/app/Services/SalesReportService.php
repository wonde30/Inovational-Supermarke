<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesReportService
{
    /**
     * Generate sales report for date range
     * 
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param User|null $user - For role-based filtering
     * @return array Report data with totals and items
     * @throws ValidationException if date range invalid
     */
    public function generateReport(Carbon $startDate, Carbon $endDate, ?User $user = null): array
    {
        // Validate date range
        $this->validateDateRange($startDate, $endDate);

        // Build query for orders within date range
        $query = Order::query()
            ->whereBetween('created_at', [
                $startDate->startOfDay(),
                $endDate->endOfDay()
            ])
            ->with(['orderItems.product']);

        // Apply role-based filtering for provider users
        // Note: Provider filtering requires provider_id column in orders table
        // When provider_id is added to the schema, uncomment the following:
        // if ($user && $user->role === 'provider') {
        //     $query->where('provider_id', $user->id);
        // }

        $orders = $query->get();

        // Calculate totals
        $totalSales = $orders->sum('total');
        $totalItems = $orders->sum(function ($order) {
            return $order->orderItems->sum('quantity');
        });
        $revenue = $totalSales; // Revenue equals total sales

        // Aggregate items by product
        $itemsData = [];
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $productId = $item->product_id;
                $productName = $item->product ? $item->product->name : 'Unknown Product';

                if (!isset($itemsData[$productId])) {
                    $itemsData[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $productName,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $itemsData[$productId]['quantity'] += $item->quantity;
                $itemsData[$productId]['amount'] += $item->total;
            }
        }

        return [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'total_sales' => (float) $totalSales,
            'total_items' => (int) $totalItems,
            'revenue' => (float) $revenue,
            'items' => array_values($itemsData),
        ];
    }

    /**
     * Export report to CSV
     * 
     * @param array $reportData
     * @return string CSV content
     */
    public function exportToCsv(array $reportData): string
    {
        $csv = [];
        
        // Add header row
        $csv[] = ['Date Range', 'Product Name', 'Quantity', 'Amount'];
        
        // Add date range info and items
        $dateRange = "{$reportData['start_date']} to {$reportData['end_date']}";
        
        foreach ($reportData['items'] as $item) {
            $csv[] = [
                $dateRange,
                $item['product_name'],
                $item['quantity'],
                number_format($item['amount'], 2),
            ];
        }
        
        // Convert to CSV string
        $output = fopen('php://temp', 'r+');
        foreach ($csv as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);
        
        return $csvContent;
    }

    /**
     * Validate date range
     * 
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return bool
     * @throws ValidationException
     */
    protected function validateDateRange(Carbon $startDate, Carbon $endDate): bool
    {
        if ($startDate->isAfter($endDate)) {
            throw ValidationException::withMessages([
                'date_range' => ['Start date must be before or equal to end date.'],
            ]);
        }

        return true;
    }
}
