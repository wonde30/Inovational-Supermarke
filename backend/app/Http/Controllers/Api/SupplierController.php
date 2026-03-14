<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Supplier::with(['user', 'purchaseOrders']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $suppliers = $query->orderBy('name')->paginate($request->per_page ?? 15);

        return $this->paginated($suppliers);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'create_user_account' => 'boolean',
            'user_password' => 'required_if:create_user_account,true|min:8',
        ]);

        try {
            DB::beginTransaction();

            $supplier = Supplier::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'contact_person' => $validated['contact_person'],
                'tax_number' => $validated['tax_number'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Create user account if requested
            if ($validated['create_user_account'] ?? false) {
                if (!$validated['email']) {
                    throw new \Exception('Email is required to create user account');
                }

                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['user_password']),
                    'role' => User::ROLE_SUPPLIER,
                    'is_active' => true,
                ]);

                $supplier->update(['user_id' => $user->id]);
                $supplier->load('user');
            }

            DB::commit();

            return $this->success($supplier, 'Supplier created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->serverError('Failed to create supplier: ' . $e->getMessage());
        }
    }

    public function show(Supplier $supplier): JsonResponse
    {
        $supplier->load(['user', 'purchaseOrders.items.product']);
        return $this->success($supplier);
    }

    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $supplier->update($validated);
        $supplier->load('user');

        return $this->success($supplier, 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        // Check if supplier has any purchase orders
        if ($supplier->purchaseOrders()->count() > 0) {
            return $this->error('Cannot delete supplier with existing purchase orders', 422);
        }

        // Delete associated user account if exists
        if ($supplier->user) {
            $supplier->user->delete();
        }

        $supplier->delete();

        return $this->success(null, 'Supplier deleted successfully');
    }

    /**
     * Get supplier dashboard data (for supplier users)
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->isSupplier()) {
            return $this->forbidden('Only suppliers can access this endpoint');
        }

        $supplier = $user->supplier;
        if (!$supplier) {
            return $this->error('Supplier profile not found', 404);
        }

        $pendingOrders = $supplier->getPendingPurchaseOrders();
        $totalOrders = $supplier->purchaseOrders()->count();
        $completedOrders = $supplier->purchaseOrders()
            ->where('status', 'delivered')
            ->count();

        $dashboardData = [
            'supplier' => $supplier,
            'pending_orders_count' => $pendingOrders->count(),
            'total_orders_count' => $totalOrders,
            'completed_orders_count' => $completedOrders,
            'pending_orders' => $pendingOrders->take(5), // Latest 5 pending orders
        ];

        return $this->success($dashboardData, 'Supplier dashboard data retrieved successfully');
    }

    /**
     * Create user account for existing supplier
     */
    public function createUserAccount(Request $request, Supplier $supplier): JsonResponse
    {
        if ($supplier->user_id) {
            return $this->error('Supplier already has a user account', 422);
        }

        if (!$supplier->email) {
            return $this->error('Supplier must have an email to create user account', 422);
        }

        $validated = $request->validate([
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $supplier->name,
                'email' => $supplier->email,
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_SUPPLIER,
                'is_active' => true,
            ]);

            $supplier->update(['user_id' => $user->id]);
            $supplier->load('user');

            return $this->success($supplier, 'User account created successfully');
        } catch (\Exception $e) {
            return $this->serverError('Failed to create user account: ' . $e->getMessage());
        }
    }
}
