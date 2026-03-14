<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Sale;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected SaleService $saleService
    ) {}

    /**
     * List all sales with optional filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Sale::with(['user', 'saleItems.product']);

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate($request->per_page ?? 15);

        return $this->paginated($sales, 'Sales retrieved successfully');
    }

    /**
     * Store a new sale with items.
     */
    public function store(StoreSaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->createSale(
            userId: $request->user()->id,
            items: $request->items,
            paymentMethod: $request->payment_method,
            discount: $request->discount ?? 0,
            taxRate: $request->tax_rate ?? 0
        );

        return $this->created($sale, 'Sale created successfully');
    }

    /**
     * Display a specific sale.
     */
    public function show(Sale $sale): JsonResponse
    {
        $sale->load(['user', 'saleItems.product']);
        
        return $this->success($sale, 'Sale retrieved successfully');
    }

    /**
     * Calculate totals without creating a sale (preview).
     */
    public function calculateTotals(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $totals = $this->saleService->calculateTotals(
            items: $request->items,
            discount: $request->discount ?? 0,
            taxRate: $request->tax_rate ?? 0
        );

        return $this->success($totals, 'Totals calculated successfully');
    }

    /**
     * Validate stock availability for items.
     */
    public function validateStock(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $errors = $this->saleService->validateStockAvailability($request->items);

        if (!empty($errors)) {
            return $this->validationError($errors, 'Stock validation failed');
        }

        return $this->success(null, 'Stock is available for all items');
    }
}
