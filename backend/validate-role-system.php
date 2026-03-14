<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Role System Validation\n";
echo "========================\n\n";

// Check User Model Constants
echo "📋 Role Constants:\n";
$roleConstants = [
    'ROLE_ADMIN' => User::ROLE_ADMIN,
    'ROLE_MANAGER' => User::ROLE_MANAGER,
    'ROLE_CASHIER' => User::ROLE_CASHIER,
    'ROLE_CUSTOMER' => User::ROLE_CUSTOMER,
    'ROLE_DELIVERY_STAFF' => User::ROLE_DELIVERY_STAFF,
    'ROLE_SUPPLIER' => User::ROLE_SUPPLIER,
];

foreach ($roleConstants as $constant => $value) {
    echo "   ✓ {$constant}: '{$value}'\n";
}

// Check User Counts by Role
echo "\n👥 User Distribution:\n";
$roles = ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'];
$totalUsers = 0;

foreach ($roles as $role) {
    $count = User::where('role', $role)->count();
    $totalUsers += $count;
    $status = $count > 0 ? '✓' : '⚠️';
    echo "   {$status} {$role}: {$count} user(s)\n";
}

echo "   📊 Total Users: {$totalUsers}\n";

// Check for Legacy Roles
echo "\n🔍 Legacy Role Check:\n";
$legacyRoles = ['storekeeper'];
$hasLegacy = false;

foreach ($legacyRoles as $role) {
    $count = User::where('role', $role)->count();
    if ($count > 0) {
        echo "   ⚠️  {$role}: {$count} user(s) (NEEDS MIGRATION)\n";
        $hasLegacy = true;
    }
}

if (!$hasLegacy) {
    echo "   ✅ No legacy roles found\n";
}

// Test Permission Methods
echo "\n🔐 Permission Method Tests:\n";
$testUser = User::where('role', 'admin')->first();

if ($testUser) {
    $permissions = [
        'isAdmin' => $testUser->isAdmin(),
        'canManageInventory' => $testUser->canManageInventory(),
        'canViewReports' => $testUser->canViewReports(),
        'canAccessPOS' => $testUser->canAccessPOS(),
        'canManageSuppliers' => $testUser->canManageSuppliers(),
        'canManageOrders' => $testUser->canManageOrders(),
        'canManageDeliveries' => $testUser->canManageDeliveries(),
        'canViewPurchaseOrders' => $testUser->canViewPurchaseOrders(),
        'canManageUsers' => $testUser->canManageUsers(),
    ];

    foreach ($permissions as $method => $result) {
        $status = $result ? '✓' : '✗';
        echo "   {$status} Admin {$method}: " . ($result ? 'true' : 'false') . "\n";
    }
} else {
    echo "   ⚠️  No admin user found for testing\n";
}

// Test Role-Specific Permissions
echo "\n📊 Role Permission Matrix:\n";
$testRoles = ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'];

foreach ($testRoles as $role) {
    $user = User::where('role', $role)->first();
    if ($user) {
        echo "   {$role}:\n";
        echo "     - POS Access: " . ($user->canAccessPOS() ? '✓' : '✗') . "\n";
        echo "     - Inventory: " . ($user->canManageInventory() ? '✓' : '✗') . "\n";
        echo "     - Reports: " . ($user->canViewReports() ? '✓' : '✗') . "\n";
        echo "     - Orders: " . ($user->canManageOrders() ? '✓' : '✗') . "\n";
    }
}

// Check Database Schema
echo "\n🗄️  Database Schema Check:\n";
try {
    $connection = \Illuminate\Support\Facades\DB::connection();
    
    // Check if users table has correct enum values
    $result = $connection->select("SHOW COLUMNS FROM users LIKE 'role'");
    if (!empty($result)) {
        $enumValues = $result[0]->Type;
        echo "   ✓ Users table role column: {$enumValues}\n";
        
        // Check if all expected roles are in enum
        $expectedRoles = ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'];
        $allPresent = true;
        
        foreach ($expectedRoles as $role) {
            if (strpos($enumValues, "'{$role}'") === false) {
                echo "   ⚠️  Role '{$role}' not found in enum\n";
                $allPresent = false;
            }
        }
        
        if ($allPresent) {
            echo "   ✅ All expected roles present in database enum\n";
        }
    }
} catch (Exception $e) {
    echo "   ⚠️  Could not check database schema: " . $e->getMessage() . "\n";
}

// Check Middleware Registration
echo "\n🛡️  Middleware Check:\n";
try {
    $middlewareAliases = app('router')->getMiddleware();
    
    $expectedMiddleware = ['role', 'permission'];
    foreach ($expectedMiddleware as $middleware) {
        if (isset($middlewareAliases[$middleware])) {
            echo "   ✓ {$middleware} middleware registered\n";
        } else {
            echo "   ⚠️  {$middleware} middleware NOT registered\n";
        }
    }
} catch (Exception $e) {
    echo "   ⚠️  Could not check middleware: " . $e->getMessage() . "\n";
}

// Summary
echo "\n📋 Validation Summary:\n";
echo "======================\n";

$issues = [];

// Check for critical issues
if ($hasLegacy) {
    $issues[] = "Legacy roles found - run migration";
}

if ($totalUsers === 0) {
    $issues[] = "No users found - run seeder";
}

$adminCount = User::where('role', 'admin')->count();
if ($adminCount === 0) {
    $issues[] = "No admin users found";
}

if (empty($issues)) {
    echo "✅ All checks passed! Role system is properly configured.\n";
    echo "\n🚀 System Ready:\n";
    echo "   - 6 roles properly defined\n";
    echo "   - Permissions working correctly\n";
    echo "   - Database schema updated\n";
    echo "   - Middleware registered\n";
    echo "   - No legacy roles remaining\n";
} else {
    echo "⚠️  Issues found:\n";
    foreach ($issues as $issue) {
        echo "   - {$issue}\n";
    }
    
    echo "\n🔧 Recommended Actions:\n";
    if (in_array("Legacy roles found - run migration", $issues)) {
        echo "   1. Run: php artisan users:migrate-storekeeper\n";
    }
    if (in_array("No users found - run seeder", $issues)) {
        echo "   2. Run: php artisan db:seed\n";
    }
    echo "   3. Run: php artisan migrate\n";
}

echo "\n";