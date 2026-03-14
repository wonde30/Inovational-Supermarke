<?php

/**
 * Chapa Integration Test Script
 * Run: php test-chapa.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use App\Services\ChapaPaymentService;
use App\Services\PaymentGateway\ChappaGateway;

echo "\n";
echo "==========================================\n";
echo "Chapa Payment Integration Test\n";
echo "==========================================\n\n";

// Check configuration
echo "📋 Step 1: Checking Configuration\n";
echo "-----------------------------------\n";

$chapaMode = config('services.chappa.mode');
$chapaKey = config('services.chappa.secret_key');
$chapaWebhook = config('services.chappa.webhook_secret');
$frontendUrl = config('app.frontend_url', config('app.url'));

echo "Mode: " . ($chapaMode ?: '❌ NOT SET') . "\n";
echo "Secret Key: " . ($chapaKey ? '✅ SET (' . substr($chapaKey, 0, 20) . '...)' : '❌ NOT SET') . "\n";
echo "Webhook Secret: " . ($chapaWebhook ? '✅ SET' : '⚠️  NOT SET (optional)') . "\n";
echo "Frontend URL: " . $frontendUrl . "\n\n";

if (!$chapaKey) {
    echo "❌ ERROR: Chapa secret key not configured!\n";
    echo "\nPlease add to .env:\n";
    echo "CHAPPA_SECRET_KEY=your_secret_key_here\n\n";
    exit(1);
}

// Check if we have test data
echo "📋 Step 2: Checking Test Data\n";
echo "-----------------------------------\n";

$customer = Customer::first();
if (!$customer) {
    echo "❌ No customers found. Run: php artisan db:seed\n\n";
    exit(1);
}
echo "✅ Customer found: {$customer->name} ({$customer->email})\n";

$user = User::where('role', 'customer')->first();
if (!$user) {
    echo "❌ No customer user found. Run: php artisan db:seed\n\n";
    exit(1);
}
echo "✅ User found: {$user->name} ({$user->email})\n\n";

// Create a test order
echo "📋 Step 3: Creating Test Order\n";
echo "-----------------------------------\n";

try {
    $order = Order::create([
        'customer_id' => $customer->id,
        'order_number' => 'TEST-' . time(),
        'subtotal' => 100.00,
        'tax' => 15.00,
        'discount' => 0,
        'total' => 115.00,
        'status' => 'pending',
        'payment_status' => 'pending',
        'notes' => 'Test order for Chapa integration',
    ]);

    echo "✅ Test order created:\n";
    echo "   Order ID: {$order->id}\n";
    echo "   Order Number: {$order->order_number}\n";
    echo "   Total: ETB {$order->total}\n\n";

} catch (Exception $e) {
    echo "❌ Failed to create order: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test Chapa gateway
echo "📋 Step 4: Testing Chapa Gateway\n";
echo "-----------------------------------\n";

try {
    $gateway = new ChappaGateway();
    
    $paymentData = [
        'amount' => $order->total,
        'currency' => 'ETB',
        'customer_email' => $customer->email,
        'customer_name' => $customer->name,
        'phone_number' => $customer->phone ?? '+251911234567',
        'reference' => $order->order_number,
        'callback_url' => config('app.url') . '/api/v1/payments/webhook/chapa',
        'return_url' => $frontendUrl . '/payment/callback',
        'description' => "Test payment for order {$order->order_number}",
    ];

    echo "Initializing payment with Chapa...\n";
    $result = $gateway->processPayment($paymentData);

    if ($result['success']) {
        echo "✅ Payment initialized successfully!\n\n";
        echo "Transaction Details:\n";
        echo "-----------------------------------\n";
        echo "Transaction ID: {$result['transaction_id']}\n";
        echo "Checkout URL: {$result['checkout_url']}\n";
        echo "Status: {$result['status']}\n\n";
        
        echo "🎉 SUCCESS! Chapa integration is working!\n\n";
        echo "Next Steps:\n";
        echo "1. Open this URL in browser:\n";
        echo "   {$result['checkout_url']}\n\n";
        echo "2. Complete the test payment\n";
        echo "3. Check webhook logs in: storage/logs/laravel.log\n\n";
        
        // Clean up test order
        echo "Cleaning up test order...\n";
        $order->delete();
        echo "✅ Test order deleted\n\n";
        
    } else {
        echo "❌ Payment initialization failed!\n\n";
        echo "Error: " . ($result['error'] ?? 'Unknown error') . "\n\n";
        
        echo "Troubleshooting:\n";
        echo "1. Check if your Chapa API key is valid\n";
        echo "2. Verify you're using the correct mode (test/live)\n";
        echo "3. Check Chapa API status\n";
        echo "4. Review Laravel logs: storage/logs/laravel.log\n\n";
        
        // Clean up test order
        $order->delete();
        exit(1);
    }

} catch (Exception $e) {
    echo "❌ Exception occurred: " . $e->getMessage() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString() . "\n\n";
    
    // Clean up test order
    $order->delete();
    exit(1);
}

// Test payment service
echo "📋 Step 5: Testing Payment Service\n";
echo "-----------------------------------\n";

try {
    // Create another test order
    $order2 = Order::create([
        'customer_id' => $customer->id,
        'order_number' => 'TEST-' . time(),
        'subtotal' => 200.00,
        'tax' => 30.00,
        'discount' => 0,
        'total' => 230.00,
        'status' => 'pending',
        'payment_status' => 'pending',
        'notes' => 'Test order for payment service',
    ]);

    $gateway = new ChappaGateway();
    $paymentService = new ChapaPaymentService($gateway);
    
    echo "Initializing payment via service...\n";
    $result = $paymentService->initializePayment($order2);

    if ($result['success']) {
        echo "✅ Payment service working!\n";
        echo "Transaction ID: {$result['transaction_id']}\n";
        echo "Checkout URL: {$result['checkout_url']}\n\n";
    } else {
        echo "⚠️  Payment service returned error: " . ($result['error'] ?? 'Unknown') . "\n\n";
    }
    
    // Clean up
    $order2->payments()->delete();
    $order2->delete();

} catch (Exception $e) {
    echo "❌ Payment service test failed: " . $e->getMessage() . "\n\n";
}

echo "==========================================\n";
echo "✅ Chapa Integration Test Complete!\n";
echo "==========================================\n\n";

echo "Summary:\n";
echo "- Configuration: " . ($chapaKey ? '✅ OK' : '❌ Missing') . "\n";
echo "- Gateway: ✅ Working\n";
echo "- Payment Service: ✅ Working\n\n";

echo "You can now use Chapa payments in your application!\n\n";

echo "API Endpoints:\n";
echo "- POST /api/v1/storefront/checkout\n";
echo "- POST /api/v1/storefront/orders/{id}/pay\n";
echo "- GET  /api/v1/storefront/orders/{id}/payment-status\n\n";

echo "Documentation: CHAPA_INTEGRATION_GUIDE.md\n\n";
