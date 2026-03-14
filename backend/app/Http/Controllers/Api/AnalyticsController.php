<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderAnalyticsService;
use App\Services\SalesReportService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AnalyticsController extends Controller
{
    use ApiResponse;

    /**
     * @var OrderAnalyticsService
     */
    protected OrderAnalyticsService $orderAnalyticsService;

    /**
     * @var SalesReportService
     */
    protected SalesReportService $salesReportService;

    /**
     * AnalyticsController constructor.
     *
     * @param OrderAnalyticsService $orderAnalyticsService
     * @param SalesReportService $salesReportService
     */
    public function __construct(
        OrderAnalyticsService $orderAnalyticsService,
        SalesReportService $salesReportService
    ) {
        $this->orderAnalyticsService = $orderAnalyticsService;
        $this->salesReportService = $salesReportService;
    }

    /**
     * Get order status counts
     * 
     * GET /api/v1/analytics/orders/status
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function orderStatusCounts(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            $counts = $this->orderAnalyticsService->getOrderStatusCounts($user);
            
            return $this->success($counts, 'Order status counts retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Failed to retrieve order status counts', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()?->id,
            ]);
            
            return $this->serverError('Failed to retrieve order status counts');
        }
    }

    /**
     * Generate sales report
     * 
     * POST /api/v1/analytics/sales/report
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function generateSalesReport(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
            
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $user = $request->user();
            
            $report = $this->salesReportService->generateReport($startDate, $endDate, $user);
            
            return $this->success($report, 'Sales report generated successfully');
        } catch (ValidationException $e) {
            return $this->validationError($e->errors(), 'Validation failed');
        } catch (\Exception $e) {
            Log::error('Failed to generate sales report', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()?->id,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
            
            return $this->serverError('Failed to generate sales report');
        }
    }

    /**
     * Export sales report to CSV
     * 
     * POST /api/v1/analytics/sales/export
     * 
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function exportSalesReport(Request $request): Response|JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
            
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $user = $request->user();
            
            // Generate report
            $report = $this->salesReportService->generateReport($startDate, $endDate, $user);
            
            // Export to CSV
            $csvContent = $this->salesReportService->exportToCsv($report);
            
            // Generate filename with date range
            $filename = sprintf(
                'sales_report_%s_to_%s.csv',
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            );
            
            // Return CSV as download
            return response($csvContent, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
        } catch (ValidationException $e) {
            return $this->validationError($e->errors(), 'Validation failed');
        } catch (\Exception $e) {
            Log::error('Failed to export sales report', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()?->id,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
            
            return $this->serverError('Failed to export sales report');
        }
    }
}
