<?php

/**
 * Database Setup Verification Script
 * Run: php verify-setup.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "==========================================\n";
echo "Smart SuperMarket - Setup Verification\n";
echo "==========================================\n\n";

// Check database connection
try {
    DB::connection()->getPdo();
    echo "✅ Database connection: OK\n";
} catch (Exception $e) {
    echo "❌ Database connection: FAILED\n";
    echo "   Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Check tables
$tables = [
    'users',
    'password_reset_tokens',
    'categories',
    'products',
    'sales',
    'sale_items',
    'customers',
    'suppliers',
    'orders',
    'order_items',
    'carts',
    'cart_items',
    'payments',
    'stock_alerts',
    'audit_logs',
    'daily_summaries',
];

echo "\n📊 Checking Tables:\n";
foreach ($tables as $table) {
    try {
        DB::table($table)->count();
        echo "   ✅ {$table}\n";
    } catch (Exception $e) {
        echo "   ❌ {$table} - MISSING\n";
    }
}

// Check data
echo "\n📦 Data Verification:\n";
echo "   Users: " . App\Models\User::count() . " (Expected: 6)\n";
echo "   Products: " . App\Models\Product::count() . " (Expected: 32)\n";
echo "   Categories: " . App\Models\Category::count() . " (Expected: 6)\n";
echo "   Customers: " . App\Models\Customer::count() . " (Expected: 7)\n";
echo "   Suppliers: " . App\Models\Supplier::count() . " (Expected: 6)\n";

// Check email verification
echo "\n📧 Email Verification:\n";
$verifiedUsers = App\Models\User::whereNotNull('email_verified_at')->count();
$totalUsers = App\Models\User::count();
echo "   Verified Users: {$verifiedUsers}/{$totalUsers}\n";

if ($verifiedUsers === $totalUsers) {
    echo "   ✅ All users verified\n";
} else {
    echo "   ⚠️  Some users not verified\n";
}

// Check password reset table
echo "\n🔐 Password Reset:\n";
try {
    $resetTokens = DB::table('password_reset_tokens')->count();
    echo "   ✅ Password reset table exists\n";
    echo "   Active reset tokens: {$resetTokens}\n";
} catch (Exception $e) {
    echo "   ❌ Password reset table missing\n";
}

// Check Chapa payment configuration
echo "\n💳 Payment Gateway (Chapa):\n";
$chapaKey = config('services.chappa.secret_key');
$chapaWebhook = config('services.chappa.webhook_secret');

if ($chapaKey) {
    echo "   ✅ Chapa secret key configured\n";
} else {
    echo "   ⚠️  Chapa secret key not configured\n";
}

if ($chapaWebhook) {
    echo "   ✅ Chapa webhook secret configured\n";
} else {
    echo "   ⚠️  Chapa webhook secret not configured\n";
}

// Check mail configuration
echo "\n📬 Email Configuration:\n";
$mailHost = config('mail.mailers.smtp.host');
$mailFrom = config('mail.from.address');

if ($mailHost && $mailFrom) {
    echo "   ✅ Email configured\n";
    echo "   Host: {$mailHost}\n";
    echo "   From: {$mailFrom}\n";
} else {
    echo "   ⚠️  Email not fully configured\n";
}

// Check user roles
echo "\n👥 User Roles:\n";
$roles = ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'];
foreach ($roles as $role) {
    $count = App\Models\User::where('role', $role)->count();
    echo "   {$role}: {$count}\n";
}

// Check default admin
echo "\n🔑 Default Admin Account:\n";
$admin = App\Models\User::where('email', 'admin@example.com')->first();
if ($admin) {
    echo "   ✅ Admin account exists\n";
    echo "   Email: admin@example.com\n";
    echo "   Password: password (⚠️  Change in production!)\n";
    echo "   Email Verified: " . ($admin->email_verified_at ? "Yes" : "No") . "\n";
    echo "   Active: " . ($admin->is_active ? "Yes" : "No") . "\n";
} else {
    echo "   ❌ Admin account not found\n";
}

// Summary
echo "\n==========================================\n";
echo "✅ Setup Verification Complete!\n";
echo "==========================================\n\n";

echo "🚀 Next Steps:\n";
echo "   1. Start the server: php artisan serve\n";
echo "   2. Login with: admin@example.com / password\n";
echo "   3. Configure Chapa payment gateway in .env\n";
echo "   4. Test email verification flow\n";
echo "   5. Test password reset flow\n\n";

echo "📚 Documentation:\n";
echo "   - Database Setup: DATABASE_SETUP.md\n";
echo "   - API Routes: routes/api.php\n";
echo "   - Controllers: app/Http/Controllers/Api/\n\n";
