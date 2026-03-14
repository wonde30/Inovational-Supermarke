<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of purchase orders
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = PurchaseOrder::with(['supplier', 'user', 'items.product']);

        // Filter by supplier if user is a supplier
        if ($user->isSupplier()) {
            $supplier = $user->supplier;
            if (!$supplier) {
                return $this->error('Supplier profile not found', 404);
            }
            $query->where('supplier_id', $supplier->id);
        }

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('supplier_id') && $user->canManageOrders()) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $purchaseOrders = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return $this->paginated($purchaseOrders);
    }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'expected_delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity_ordered' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Create purchase order
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => PurchaseOrder::generatePoNumber(),
                'supplier_id' => $validated['supplier_id'],
                'user_id' => $request->user()->id,
                'status' => PurchaseOrder::STATUS_PENDING,
                'order_date' => now(),
                'expected_delivery_date' => $validated['expected_delivery_date'],
                'notes' => $validated['notes'] ?? null,
                'total_amount' => 0, // Will be calculated below
            ]);

            $totalAmount = 0;

            // Create purchase order items
            foreach ($validated['items'] as $item) {
                $totalPrice = $item['quantity_ordered'] * $item['unit_price'];
                $totalAmount += $totalPrice;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'quantity_received' => 0,
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            // Update total amount
            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();

            $purchaseOrder->load(['supplier', 'items.product']);

            return $this->success($purchaseOrder, 'Purchase order created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->serverError('Failed to create purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified purchase order
     */
    public function show(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $user = $request->user();

        // Check if supplier can only view their own purchase orders
        if ($user->isSupplier()) {
            $supplier = $user->supplier;
            if (!$supplier || $purchaseOrder->supplier_id !== $supplier->id) {
                return $this->forbidden('You can only view your own purchase orders');
            }
        }

        $purchaseOrder->load(['supplier', 'user', 'items.product']);

        return $this->success($purchaseOrder);
    }

    /**
     * Update the specified purchase order
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $user = $request->user();

        // Suppliers can only update certain fields
        if ($user->isSupplier()) {
            $supplier = $user->supplier;
            if (!$supplier || $purchaseOrder->supplier_id !== $supplier->id) {
                return $this->forbidden('You can only update your own purchase orders');
            }

            if (!$purchaseOrder->canBeUpdatedBySupplier()) {
                return $this->error('Purchase order cannot be updated in current status', 422);
            }

            $validated = $request->validate([
                'status' => ['sometimes', Rule::in([
                    PurchaseOrder::STATUS_CONFIRMED,
                    PurchaseOrder::STATUS_SHIPPED,
                    PurchaseOrder::STATUS_DELIVERED
                ])],
                'actual_delivery_date' => 'nullable|date',
                'supplier_notes' => 'nullable|string',
            ]);
        } else {
            // Admin/Manager can update more fields
            $validated = $request->validate([
                'supplier_id' => 'sometimes|exists:suppliers,id',
                'status' => ['sometimes', Rule::in(array_keys(PurchaseOrder::getStatuses()))],
                'expected_delivery_date' => 'sometimes|date',
                'actual_delivery_date' => 'nullable|date',
                'notes' => 'nullable|string',
                'supplier_notes' => 'nullable|string',
            ]);
        }

        $purchaseOrder->update($validated);
        $purchaseOrder->load(['supplier', 'user', 'items.product']);

        return $this->success($purchaseOrder, 'Purchase order updated successfully');
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy(PurchaseOrder $purchaseOrder): JsonResponse
    {
        if ($purchaseOrder->status !== PurchaseOrder::STATUS_PENDING) {
            return $this->error('Only pending purchase orders can be deleted', 422);
        }

        $purchaseOrder->delete();

        return $this->success(null, 'Purchase order deleted successfully');
    }

    /**
     * Update delivery status (for suppliers)
     */
    public function updateDeliveryStatus(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $user = $request->user();

        if (!$user->isSupplier()) {
            return $this->forbidden('Only suppliers can update delivery status');
        }

        $supplier = $user->supplier;
        if (!$supplier || $purchaseOrder->supplier_id !== $supplier->id) {
            return $this->forbidden('You can only update your own purchase orders');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in([
                PurchaseOrder::STATUS_CONFIRMED,
                PurchaseOrder::STATUS_SHIPPED,
                PurchaseOrder::STATUS_DELIVERED
            ])],
            'actual_delivery_date' => 'nullable|date',
            'supplier_notes' => 'nullable|string',
        ]);

        $purchaseOrder->update($validated);
        $purchaseOrder->load(['supplier', 'items.product']);

        return $this->success($purchaseOrder, 'Delivery status updated successfully');
    }

    /**
     * Confirm stock supply (for suppliers)
     */
    public function confirmStock(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $user = $request->user();

        if (!$user->isSupplier()) {
            return $this->forbidden('Only suppliers can confirm stock');
        }

        $supplier = $user->supplier;
        if (!$supplier || $purchaseOrder->supplier_id !== $supplier->id) {
            return $this->forbidden('You can only confirm stock for your own purchase orders');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.quantity_received' => 'required|integer|min:0',
            'items.*.notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['items'] as $itemData) {
                $item = PurchaseOrderItem::where('id', $itemData['id'])
                    ->where('purchase_order_id', $purchaseOrder->id)
                    ->first();

                if ($item) {
                    $item->update([
                        'quantity_received' => $itemData['quantity_received'],
                        'notes' => $itemData['notes'] ?? $item->notes,
                    ]);

                    // Update product stock if fully received
                    if ($item->isFullyReceived()) {
                        $product = $item->product;
                        $product->increment('stock_quantity', $item->quantity_received);
                    }
                }
            }

            // Check if all items are fully received
            $allItemsReceived = $purchaseOrder->items()
                ->whereColumn('quantity_received', '<', 'quantity_ordered')
                ->count() === 0;

            if ($allItemsReceived && $purchaseOrder->status !== PurchaseOrder::STATUS_DELIVERED) {
                $purchaseOrder->update([
                    'status' => PurchaseOrder::STATUS_DELIVERED,
                    'actual_delivery_date' => now(),
                ]);
            }

            DB::commit();

            $purchaseOrder->load(['supplier', 'items.product']);

            return $this->success($purchaseOrder, 'Stock confirmation updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->serverError('Failed to confirm stock: ' . $e->getMessage());
        }
    }
}