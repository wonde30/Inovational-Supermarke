<?php

/**
 * Test Chapa Webhook Flow
 * 
 * This script simulates a Chapa webhook to test the auto-complete order functionality
 * 
 * Usage:
 * 1. Create an order through the frontend
 * 2. Note the transaction_id from the payment
 * 3. Run: php test-webhook-flow.php {transaction_id}
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Payment;
use App\Models\Order;
use App\Services\ChapaPaymentService;
use App\Services\PaymentGateway\ChappaGateway;

// Get transaction ID from command line
$transactionId = $argv[1] ?? null;

if (!$transactionId) {
    echo "❌ Usage: php test-webhook-flow.php {transaction_id}\n";
    echo "\nExample: php test-webhook-flow.php TX-20260310-ABC123\n";
    exit(1);
}

echo "🔍 Testing Webhook Flow for Transaction: {$transactionId}\n";
echo str_repeat("=", 60) . "\n\n";

// Find payment
$payment = Payment::where('transaction_id', $transactionId)->first();

if (!$payment) {
    echo "❌ Payment not found with transaction_id: {$transactionId}\n";
    echo "\n💡 Tip: Create an order first through the frontend\n";
    exit(1);
}

echo "✅ Payment found:\n";
echo "   - ID: {$payment->id}\n";
echo "   - Order ID: {$payment->order_id}\n";
echo "   - Amount: ETB {$payment->amount}\n";
echo "   - Current Status: {$payment->status}\n\n";

// Find order
$order = Order::with(['orderItems.product', 'customer'])->find($payment->order_id);

if (!$order) {
    echo "❌ Order not found\n";
    exit(1);
}

echo "✅ Order found:\n";
echo "   - Order Number: {$order->order_number}\n";
echo "   - Customer: {$order->customer->name}\n";
echo "   - Total: ETB {$order->total}\n";
echo "   - Current Status: {$order->status}\n";
echo "   - Payment Status: " . ($order->payment_status ?? 'not set') . "\n\n";

if ($order->status === 'completed') {
    echo "⚠️  Order already completed\n";
    if ($order->sale_id) {
        $sale = \App\Models\Sale::find($order->sale_id);
        echo "   - Sale Invoice: {$sale->invoice_number}\n";
    }
    echo "\n";
    exit(0);
}

// Simulate webhook payload
$webhookPayload = [
    'tx_ref' => $transactionId,
    'status' => 'success',
    'payment_method' => 'telebirr',
    'amount' => (float) $payment->amount,
    'currency' => 'ETB',
    'charge' => 0,
    'created_at' => now()->toISOString(),
];

echo "📤 Simulating Chapa webhook...\n";
echo json_encode($webhookPayload, JSON_PRETTY_PRINT) . "\n\n";

// Generate signature
$webhookSecret = config('services.chappa.webhook_secret');
$signature = hash_hmac('sha256', json_encode($webhookPayload), $webhookSecret);

echo "🔐 Generated signature: {$signature}\n\n";

// Process webhook
$gateway = new ChappaGateway();
$service = new ChapaPaymentService($gateway);

echo "⚙️  Processing webhook...\n";
$result = $service->handleWebhook($webhookPayload, $signature);

if ($result['success']) {
    echo "✅ Webhook processed successfully!\n\n";
    
    // Reload order
    $order->refresh();
    $payment->refresh();
    
    echo "📊 Updated Status:\n";
    echo "   - Payment Status: {$payment->status}\n";
    echo "   - Order Status: {$order->status}\n";
    echo "   - Order Payment Status: " . ($order->payment_status ?? 'not set') . "\n";
    
    if ($order->sale_id) {
        $sale = \App\Models\Sale::find($order->sale_id);
        echo "   - Sale Created: ✅\n";
        echo "   - Invoice Number: {$sale->invoice_number}\n";
        echo "   - Sale Status: {$sale->status}\n";
        echo "   - Sale Payment Status: {$sale->payment_status}\n";
    }
    
    echo "\n🎉 Order auto-completed successfully!\n";
    echo "   Customer can now see order as 'Completed' in My Orders page\n";
    
} else {
    echo "❌ Webhook processing failed: {$result['message']}\n";
    exit(1);
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ Test completed successfully!\n";
