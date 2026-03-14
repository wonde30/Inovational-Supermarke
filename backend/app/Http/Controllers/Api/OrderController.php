<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    /**
     * Real-World Inventory System Flow:
     * 
     * 1. Customer places ORDER (online/storefront) → Status: pending
     * 2. Staff processes ORDER → Status: processing  
     * 3. ORDER completed & paid → Creates SALE record → Order Status: completed
     * 4. SALE = Financial transaction for accounting/reports
     * 
     * Orders = Customer-facing requests (can be pending, cancelled)
     * Sales = Business/accounting records (completed transactions)
     */

    /**
     * Get all orders (Admin/Manager)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['customer', 'orderItems.product', 'sale'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by order number or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate($request->per_page ?? 15);

        return $this->paginated($orders, 'Orders retrieved successfully');
    }

    /**
     * Get a specific order
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['customer', 'orderItems.product', 'sale']);
        return $this->success($order, 'Order retrieved successfully');
    }

    /**
     * Update order status
     * When status changes to 'completed', automatically create a Sale record
     */
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];
        
        // Prevent changing status of already completed orders
        if ($oldStatus === 'completed') {
            return $this->error('Cannot change status of completed orders', 422);
        }

        // If cancelling, restore stock (only if not already cancelled)
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->product->increment('quantity', $item->quantity);
            }
        }

        // If un-cancelling (rare), deduct stock again
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                if ($item->product->quantity < $item->quantity) {
                    return $this->error("Insufficient stock for {$item->product->name}", 422);
                }
                $item->product->decrement('quantity', $item->quantity);
            }
        }

        // IMPORTANT: When order is completed, create a Sale record
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $sale = $this->createSaleFromOrder($order, $validated['payment_method'] ?? 'cash');
            $order->sale_id = $sale->id;
        }

        $order->status = $newStatus;
        $order->save();

        // Log the action
        AuditLog::log(
            'update_order_status',
            'Order',
            $order->id,
            ['status' => $oldStatus],
            ['status' => $newStatus],
            "Order status changed from {$oldStatus} to {$newStatus}"
        );

        return $this->success(
            $order->fresh()->load(['customer', 'orderItems.product', 'sale']), 
            $newStatus === 'completed' 
                ? 'Order completed and sale record created' 
                : 'Order status updated'
        );
    }

    /**
     * Create a Sale record from a completed Order
     * This links the customer order to the accounting/financial record
     */
    private function createSaleFromOrder(Order $order, string $paymentMethod): Sale
    {
        return DB::transaction(function () use ($order, $paymentMethod) {
            // Generate unique invoice number
            $lastSale = Sale::whereDate('created_at', today())->orderBy('id', 'desc')->first();
            $nextNumber = $lastSale ? ((int) substr($lastSale->invoice_number, -4)) + 1 : 1;
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            
            // Ensure uniqueness
            while (Sale::where('invoice_number', $invoiceNumber)->exists()) {
                $nextNumber++;
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }

            // Create sale record
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => auth()->id(), // Staff who processed the order
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'discount' => $order->discount,
                'total' => $order->total,
                'payment_method' => $paymentMethod,
                'payment_status' => 'paid',
                'status' => 'completed',
                'customer_name' => $order->customer->name ?? null,
                'notes' => "From Order #{$order->order_number}",
            ]);

            // Create sale items from order items
            foreach ($order->orderItems as $orderItem) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $orderItem->product_id,
                    'quantity' => $orderItem->quantity,
                    'unit_price' => $orderItem->unit_price,
                    'total' => $orderItem->total,
                ]);
            }

            // Log the sale creation
            AuditLog::log(
                'create_sale_from_order',
                'Sale',
                $sale->id,
                null,
                ['order_id' => $order->id, 'invoice_number' => $invoiceNumber],
                "Sale created from Order #{$order->order_number}"
            );

            return $sale;
        });
    }

    /**
     * Get order statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total'),
            'this_month_revenue' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'completed')
                ->sum('total'),
        ];

        return $this->success($stats, 'Order statistics retrieved');
    }
}
