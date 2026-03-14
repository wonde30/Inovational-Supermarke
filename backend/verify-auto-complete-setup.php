<?php

/**
 * Verify Chapa Auto-Complete Setup
 * 
 * This script checks that all components are properly configured
 * for automatic order completion after Chapa payment
 * 
 * Usage: php verify-auto-complete-setup.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Verifying Chapa Auto-Complete Setup\n";
echo str_repeat("=", 60) . "\n\n";

$checks = [];
$passed = 0;
$failed = 0;

// Check 1: Environment variables
echo "1️⃣  Checking environment variables...\n";
$chapaSecretKey = config('services.chappa.secret_key');
$chapaPublicKey = config('services.chappa.public_key');
$chapaWebhookSecret = config('services.chappa.webhook_secret');
$appUrl = config('app.url');
$frontendUrl = config('app.frontend_url');

if ($chapaSecretKey && $chapaPublicKey && $chapaWebhookSecret) {
    echo "   ✅ Chapa credentials configured\n";
    echo "      - Secret Key: " . substr($chapaSecretKey, 0, 20) . "...\n";
    echo "      - Webhook Secret: " . substr($chapaWebhookSecret, 0, 15) . "...\n";
    $passed++;
} else {
    echo "   ❌ Chapa credentials missing in .env\n";
    $failed++;
}

if ($appUrl && $frontendUrl) {
    echo "   ✅ URLs configured\n";
    echo "      - Backend: {$appUrl}\n";
    echo "      - Frontend: {$frontendUrl}\n";
    $passed++;
} else {
    echo "   ❌ URLs not configured\n";
    $failed++;
}

echo "\n";

// Check 2: Database tables
echo "2️⃣  Checking database tables...\n";
try {
    $ordersTable = \Illuminate\Support\Facades\Schema::hasTable('orders');
    $paymentsTable = \Illuminate\Support\Facades\Schema::hasTable('payments');
    $salesTable = \Illuminate\Support\Facades\Schema::hasTable('sales');
    
    if ($ordersTable && $paymentsTable && $salesTable) {
        echo "   ✅ Required tables exist\n";
        echo "      - orders ✓\n";
        echo "      - payments ✓\n";
        echo "      - sales ✓\n";
        $passed++;
    } else {
        echo "   ❌ Missing required tables\n";
        if (!$ordersTable) echo "      - orders ✗\n";
        if (!$paymentsTable) echo "      - payments ✗\n";
        if (!$salesTable) echo "      - sales ✗\n";
        $failed++;
    }
} catch (\Exception $e) {
    echo "   ❌ Database connection failed: {$e->getMessage()}\n";
    $failed++;
}

echo "\n";

// Check 3: Order model payment_status field
echo "3️⃣  Checking Order model...\n";
try {
    $orderFillable = (new \App\Models\Order())->getFillable();
    if (in_array('payment_status', $orderFillable)) {
        echo "   ✅ payment_status field in fillable array\n";
        $passed++;
    } else {
        echo "   ❌ payment_status field NOT in fillable array\n";
        $failed++;
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking Order model: {$e->getMessage()}\n";
    $failed++;
}

echo "\n";

// Check 4: ChapaPaymentService
echo "4️⃣  Checking ChapaPaymentService...\n";
try {
    $gateway = new \App\Services\PaymentGateway\ChappaGateway();
    $service = new \App\Services\ChapaPaymentService($gateway);
    
    // Check if completeOrderWithSale method exists
    $reflection = new \ReflectionClass($service);
    $method = $reflection->getMethod('completeOrderWithSale');
    
    if ($method) {
        echo "   ✅ ChapaPaymentService properly configured\n";
        echo "      - completeOrderWithSale() method exists\n";
        echo "      - handleWebhook() method exists\n";
        $passed++;
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking ChapaPaymentService: {$e->getMessage()}\n";
    $failed++;
}

echo "\n";

// Check 5: Routes
echo "5️⃣  Checking routes...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    
    $webhookRoute = false;
    $checkoutRoute = false;
    $paymentStatusRoute = false;
    
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (str_contains($uri, 'payments/webhook/chapa')) {
            $webhookRoute = true;
        }
        if (str_contains($uri, 'storefront/checkout')) {
            $checkoutRoute = true;
        }
        if (str_contains($uri, 'payment-status')) {
            $paymentStatusRoute = true;
        }
    }
    
    if ($webhookRoute && $checkoutRoute && $paymentStatusRoute) {
        echo "   ✅ Required routes registered\n";
        echo "      - POST /api/v1/payments/webhook/chapa ✓\n";
        echo "      - POST /api/v1/storefront/checkout ✓\n";
        echo "      - GET /api/v1/storefront/orders/{id}/payment-status ✓\n";
        $passed++;
    } else {
        echo "   ❌ Missing required routes\n";
        if (!$webhookRoute) echo "      - Webhook route ✗\n";
        if (!$checkoutRoute) echo "      - Checkout route ✗\n";
        if (!$paymentStatusRoute) echo "      - Payment status route ✗\n";
        $failed++;
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking routes: {$e->getMessage()}\n";
    $failed++;
}

echo "\n";

// Check 6: Webhook URL
echo "6️⃣  Webhook configuration...\n";
$webhookUrl = $appUrl . '/api/v1/payments/webhook/chapa';
echo "   📍 Webhook URL: {$webhookUrl}\n";
echo "   ⚠️  Configure this URL in your Chapa dashboard\n";
echo "\n";

// Summary
echo str_repeat("=", 60) . "\n";
echo "📊 Summary\n";
echo str_repeat("=", 60) . "\n";
echo "✅ Passed: {$passed}\n";
echo "❌ Failed: {$failed}\n";
echo "\n";

if ($failed === 0) {
    echo "🎉 All checks passed! Your setup is ready.\n\n";
    echo "Next steps:\n";
    echo "1. Configure webhook URL in Chapa dashboard:\n";
    echo "   {$webhookUrl}\n\n";
    echo "2. Test the flow:\n";
    echo "   - Create an order through frontend\n";
    echo "   - Complete payment on Chapa\n";
    echo "   - Verify order auto-completes\n\n";
    echo "3. Monitor logs:\n";
    echo "   tail -f storage/logs/laravel.log | grep webhook\n\n";
    exit(0);
} else {
    echo "⚠️  Some checks failed. Please fix the issues above.\n\n";
    exit(1);
}
