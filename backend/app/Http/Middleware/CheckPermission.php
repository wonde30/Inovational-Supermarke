<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $hasPermission = match($permission) {
            'manage_inventory' => $user->canManageInventory(),
            'view_reports' => $user->canViewReports(),
            'access_pos' => $user->canAccessPOS(),
            'manage_suppliers' => $user->canManageSuppliers(),
            'manage_orders' => $user->canManageOrders(),
            'manage_deliveries' => $user->canManageDeliveries(),
            'view_purchase_orders' => $user->canViewPurchaseOrders(),
            'manage_users' => $user->canManageUsers(),
            'access_customer_data' => $user->canAccessCustomerData(),
            default => false
        };

        if (!$hasPermission) {
            return response()->json([
                'success' => false,
                'message' => "Unauthorized. Permission '{$permission}' required."
            ], 403);
        }

        return $next($request);
    }
}