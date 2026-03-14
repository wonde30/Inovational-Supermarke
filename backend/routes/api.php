<?php

use App\Http\Controllers\Api\AdvancedReportController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BackupController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Storefront\CartController;
use App\Http\Controllers\Api\Storefront\OrderController as StorefrontOrderController;
use App\Http\Controllers\Api\Storefront\ProductController as StorefrontProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API v1 Routes
Route::prefix('v1')->group(function () {
    // Health check endpoint
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is running',
            'data' => [
                'version' => '1.0.0',
                'timestamp' => now()->toISOString()
            ]
        ]);
    });

    // Auth routes (public)
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1'); // 3 attempts per minute
        // Note: Email verification route moved to web.php for proper redirects
        Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->middleware('throttle:2,1');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:3,1');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:3,1');
        Route::post('/verify-reset-token', [AuthController::class, 'verifyResetToken']);
        Route::get('/languages', [AuthController::class, 'getLanguages']); // Public endpoint for available languages
        
        // Social Authentication
        Route::get('/google', [\App\Http\Controllers\Api\SocialAuthController::class, 'redirectToGoogle']);
        Route::get('/google/callback', [\App\Http\Controllers\Api\SocialAuthController::class, 'handleGoogleCallback']);
    });

    // Protected auth routes
    Route::middleware(['auth:sanctum', 'check.token.expiration'])->prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::patch('/language', [AuthController::class, 'updateLanguage']); // Update language preference
        Route::put('/profile', [AuthController::class, 'updateProfile']); // Update profile
        Route::put('/password', [AuthController::class, 'updatePassword']); // Update password
    });

    // Protected routes
    Route::middleware(['auth:sanctum', 'check.token.expiration'])->group(function () {
        Route::get('/user', function (Request $request) {
            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $request->user()
            ]);
        });

        // Products routes (Admin/Manager can manage, Cashier can view)
        Route::middleware(['permission:manage_inventory'])->group(function () {
            Route::post('/products', [ProductController::class, 'store']);
            Route::put('/products/{product}', [ProductController::class, 'update']);
            Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        });
        
        // All authenticated users can view products
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{product}', [ProductController::class, 'show']);

        // Categories routes (Admin/Manager only)
        Route::middleware(['permission:manage_inventory'])->group(function () {
            Route::apiResource('categories', CategoryController::class);
        });

        // Sales routes (Admin/Manager/Cashier)
        Route::middleware(['permission:access_pos'])->prefix('sales')->group(function () {
            Route::get('/', [SaleController::class, 'index']);
            Route::post('/', [SaleController::class, 'store']);
            Route::get('/{sale}', [SaleController::class, 'show']);
            Route::post('/calculate-totals', [SaleController::class, 'calculateTotals']);
            Route::post('/validate-stock', [SaleController::class, 'validateStock']);
        });

        // Customer routes (Admin/Manager can manage, Customers can view own data)
        Route::middleware(['permission:manage_orders'])->group(function () {
            Route::apiResource('customers', CustomerController::class);
        });

        // Supplier routes
        Route::middleware(['permission:manage_suppliers'])->group(function () {
            Route::apiResource('suppliers', SupplierController::class);
            Route::post('/suppliers/{supplier}/create-user-account', [SupplierController::class, 'createUserAccount']);
        });

        // Supplier dashboard (for supplier users)
        Route::middleware(['role:supplier'])->group(function () {
            Route::get('/supplier/dashboard', [SupplierController::class, 'dashboard']);
        });

        // Purchase Order routes
        Route::prefix('purchase-orders')->group(function () {
            // Admin/Manager can manage all purchase orders
            Route::middleware(['permission:manage_orders'])->group(function () {
                Route::get('/', [PurchaseOrderController::class, 'index']);
                Route::post('/', [PurchaseOrderController::class, 'store']);
                Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'show']);
                Route::put('/{purchaseOrder}', [PurchaseOrderController::class, 'update']);
                Route::delete('/{purchaseOrder}', [PurchaseOrderController::class, 'destroy']);
            });

            // Suppliers can view and update their own purchase orders
            Route::middleware(['role:supplier'])->group(function () {
                Route::get('/', [PurchaseOrderController::class, 'index']);
                Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'show']);
                Route::put('/{purchaseOrder}', [PurchaseOrderController::class, 'update']);
                Route::patch('/{purchaseOrder}/delivery-status', [PurchaseOrderController::class, 'updateDeliveryStatus']);
                Route::patch('/{purchaseOrder}/confirm-stock', [PurchaseOrderController::class, 'confirmStock']);
            });
        });

        // Dashboard route (Admin/Manager/Cashier)
        Route::middleware(['role:admin,manager,cashier'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index']);
        });

        // Report routes (Admin/Manager)
        Route::middleware(['permission:view_reports'])->prefix('reports')->group(function () {
            Route::get('/sales', [ReportController::class, 'salesReport']);
            Route::get('/profit', [ReportController::class, 'profitReport']);
            Route::get('/top-products', [ReportController::class, 'topProducts']);
        });

        // Backup routes (Admin only)
        Route::middleware(['role:admin'])->prefix('backup')->group(function () {
            Route::post('/create', [BackupController::class, 'backup']);
            Route::get('/list', [BackupController::class, 'list']);
            Route::post('/restore', [BackupController::class, 'restore']);
            Route::get('/download/{filename}', [BackupController::class, 'download']);
            Route::delete('/{filename}', [BackupController::class, 'delete']);
        });

        // Users routes (Admin only)
        Route::middleware(['role:admin'])->group(function () {
            Route::apiResource('users', UserController::class);
        });

        // Orders routes (Admin/Manager) - Customer orders management
        Route::middleware(['permission:manage_orders'])->prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/statistics', [OrderController::class, 'statistics']);
            Route::get('/{order}', [OrderController::class, 'show']);
            Route::patch('/{order}/status', [OrderController::class, 'updateStatus']);
        });

        // Advanced Reports routes (Admin/Manager)
        Route::middleware(['permission:view_reports'])->prefix('advanced')->group(function () {
            Route::get('/stock-alerts', [AdvancedReportController::class, 'stockAlerts']);
            Route::get('/stock-alerts/statistics', [AdvancedReportController::class, 'stockAlertStatistics']);
            Route::post('/stock-alerts/{alert}/resolve', [AdvancedReportController::class, 'resolveAlert']);
            Route::get('/audit-logs', [AdvancedReportController::class, 'auditLogs']);
            Route::get('/daily-summary', [AdvancedReportController::class, 'dailySummary']);
            Route::get('/cashier-performance', [AdvancedReportController::class, 'cashierPerformance']);
            Route::get('/product-profitability', [AdvancedReportController::class, 'productProfitability']);
            Route::get('/dead-stock', [AdvancedReportController::class, 'deadStock']);
            Route::get('/expiring-products', [AdvancedReportController::class, 'expiringProducts']);
            Route::get('/sales-trend', [AdvancedReportController::class, 'salesTrend']);
            Route::get('/export', [AdvancedReportController::class, 'exportReport']);
        });

        // Analytics routes (Admin/Manager)
        Route::middleware(['permission:view_reports'])->prefix('analytics')->group(function () {
            Route::get('/orders/status', [AnalyticsController::class, 'orderStatusCounts']);
            Route::post('/sales/report', [AnalyticsController::class, 'generateSalesReport']);
            Route::post('/sales/export', [AnalyticsController::class, 'exportSalesReport']);
        });

        // Delivery Staff routes
        Route::middleware(['role:delivery_staff,admin,manager'])->prefix('delivery')->group(function () {
            Route::get('/assignments', [OrderController::class, 'deliveryAssignments']);
            Route::patch('/orders/{order}/delivery-status', [OrderController::class, 'updateDeliveryStatus']);
        });

        // Customer-specific routes
        Route::middleware(['role:customer'])->prefix('customer')->group(function () {
            Route::get('/orders', [OrderController::class, 'customerOrders']);
            Route::get('/orders/{order}', [OrderController::class, 'customerOrderDetails']);
        });

        // Payment routes
        Route::prefix('payments')->group(function () {
            Route::get('/gateways', [\App\Http\Controllers\Api\PaymentController::class, 'gateways']);
            Route::post('/initiate', [\App\Http\Controllers\Api\PaymentController::class, 'initiate']);
            Route::post('/{payment}/process', [\App\Http\Controllers\Api\PaymentController::class, 'process']);
            Route::get('/verify/{transactionId}', [\App\Http\Controllers\Api\PaymentController::class, 'verify']);
            Route::post('/{payment}/refund', [\App\Http\Controllers\Api\PaymentController::class, 'refund']);
            Route::get('/history', [\App\Http\Controllers\Api\PaymentController::class, 'history']);
            
            // Chapa payment integration (admin-dashboard-analytics feature)
            Route::post('/initialize', [\App\Http\Controllers\Api\PaymentController::class, 'initializePayment'])->middleware('throttle:10,1');
            Route::get('/{transactionId}/verify', [\App\Http\Controllers\Api\PaymentController::class, 'verifyPayment']);
            Route::post('/manual-verify', [\App\Http\Controllers\Api\PaymentController::class, 'manualVerify']);
            Route::post('/complete-order', [\App\Http\Controllers\Api\PaymentController::class, 'completeOrderAfterPayment']);
        });
    });

    // Payment callback (webhook) - public endpoint
    Route::post('/payments/callback', [\App\Http\Controllers\Api\PaymentController::class, 'callback']);
    
    // Chapa webhook - public endpoint (admin-dashboard-analytics feature)
    Route::post('/payments/webhook/chapa', [\App\Http\Controllers\Api\PaymentController::class, 'chapaWebhook'])->withoutMiddleware(['auth:sanctum']);

    // Storefront routes (public)
    Route::prefix('storefront')->group(function () {
        Route::get('/products', [StorefrontProductController::class, 'index']);
        Route::get('/products/{product}', [StorefrontProductController::class, 'show']);
        Route::get('/categories', [StorefrontProductController::class, 'categories']);
        
        // QR Code scanning
        Route::get('/products/scan/{qr_code}', [\App\Http\Controllers\Api\Storefront\QRScanController::class, 'scan']);
        
        Route::post('/cart/calculate', [CartController::class, 'calculateTotals']);
        Route::post('/cart/validate-stock', [CartController::class, 'validateStock']);
        
        // Protected storefront routes (require login)
        Route::middleware(['auth:sanctum', 'check.token.expiration'])->group(function () {
            // Cart management
            Route::get('/cart', [\App\Http\Controllers\Api\Storefront\CartController::class, 'show']);
            Route::post('/cart/add', [\App\Http\Controllers\Api\Storefront\CartController::class, 'addProduct']);
            Route::patch('/cart/items/{item}', [\App\Http\Controllers\Api\Storefront\CartController::class, 'updateQuantity']);
            Route::delete('/cart/items/{item}', [\App\Http\Controllers\Api\Storefront\CartController::class, 'removeItem']);
            Route::delete('/cart', [\App\Http\Controllers\Api\Storefront\CartController::class, 'clear']);
            
            // Checkout
            Route::post('/checkout', [\App\Http\Controllers\Api\Storefront\CheckoutController::class, 'process']);
            
            // Orders
            Route::post('/orders', [StorefrontOrderController::class, 'store']);
            Route::get('/orders', [StorefrontOrderController::class, 'index']);
            Route::get('/orders/{order}', [StorefrontOrderController::class, 'show']);
            Route::post('/orders/{order}/cancel', [StorefrontOrderController::class, 'cancel']);
            Route::post('/orders/{order}/pay', [\App\Http\Controllers\Api\Storefront\CheckoutController::class, 'initializePayment']);
            Route::get('/orders/{order}/payment-status', [\App\Http\Controllers\Api\Storefront\CheckoutController::class, 'checkPaymentStatus']);
        });
    });
});
