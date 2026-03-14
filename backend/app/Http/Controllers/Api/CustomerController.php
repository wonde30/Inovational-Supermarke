<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('name')->paginate($request->per_page ?? 15);

        return $this->paginated($customers);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer = Customer::create($validated);

        return $this->success($customer, 'Customer created successfully', 201);
    }

    public function show(Customer $customer): JsonResponse
    {
        return $this->success($customer->load('orders'));
    }

    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer->update($validated);

        return $this->success($customer, 'Customer updated successfully');
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return $this->success(null, 'Customer deleted successfully');
    }
}
