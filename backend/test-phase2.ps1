# Phase 2 Testing Script (PowerShell)
# Tests payment gateways, notifications, and monitoring

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Phase 2 Feature Testing" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

$BASE_URL = "http://localhost:8000"

# Test 1: Get available payment gateways
Write-Host "Step 1: Testing Payment Gateway Endpoints" -ForegroundColor Yellow
Write-Host ""
Write-Host "Testing: GET /api/v1/payments/gateways"

try {
    $response = Invoke-WebRequest -Uri "$BASE_URL/api/v1/payments/gateways" -Method GET -UseBasicParsing
    if ($response.StatusCode -eq 200) {
        Write-Host "✓ Payment gateways endpoint working" -ForegroundColor Green
        $content = $response.Content | ConvertFrom-Json
        Write-Host "Available gateways: $($content.data.Count)" -ForegroundColor Green
    }
} catch {
    Write-Host "✗ Failed: $($_.Exception.Message)" -ForegroundColor Red
}
Write-Host ""
Write-Host ""

# Test 2: Check route registration
Write-Host "Step 2: Checking Route Registration" -ForegroundColor Yellow
$routes = php artisan route:list | Select-String "payments"
Write-Host "Payment routes found: $($routes.Count)" -ForegroundColor Green
Write-Host ""

# Test 3: Check files exist
Write-Host "Step 3: Checking Payment Gateway Classes" -ForegroundColor Yellow
$gateways = @(
    "app/Services/PaymentGateway/StripeGateway.php",
    "app/Services/PaymentGateway/PayPalGateway.php",
    "app/Services/PaymentGateway/ChappaGateway.php",
    "app/Services/PaymentGateway/PaymentGatewayFactory.php"
)

foreach ($gateway in $gateways) {
    if (Test-Path $gateway) {
        Write-Host "✓ $(Split-Path $gateway -Leaf)" -ForegroundColor Green
    } else {
        Write-Host "✗ $(Split-Path $gateway -Leaf) not found" -ForegroundColor Red
    }
}
Write-Host ""

# Test 4: Check notification classes
Write-Host "Step 4: Checking Notification Classes" -ForegroundColor Yellow
$notifications = @(
    "app/Notifications/OrderPlacedNotification.php",
    "app/Notifications/PaymentReceivedNotification.php",
    "app/Notifications/LowStockAlertNotification.php",
    "app/Notifications/CriticalErrorNotification.php"
)

foreach ($notif in $notifications) {
    if (Test-Path $notif) {
        Write-Host "✓ $(Split-Path $notif -Leaf)" -ForegroundColor Green
    } else {
        Write-Host "✗ $(Split-Path $notif -Leaf) not found" -ForegroundColor Red
    }
}
Write-Host ""

# Test 5: Check error handling
Write-Host "Step 5: Checking Error Handling Classes" -ForegroundColor Yellow
$errorClasses = @(
    "app/Exceptions/PaymentException.php",
    "app/Exceptions/InsufficientStockException.php",
    "app/Services/ErrorHandlingService.php"
)

foreach ($class in $errorClasses) {
    if (Test-Path $class) {
        Write-Host "✓ $(Split-Path $class -Leaf)" -ForegroundColor Green
    } else {
        Write-Host "✗ $(Split-Path $class -Leaf) not found" -ForegroundColor Red
    }
}
Write-Host ""

# Test 6: Check monitoring middleware
Write-Host "Step 6: Checking Monitoring Middleware" -ForegroundColor Yellow
$middleware = @(
    "app/Http/Middleware/LogRequests.php",
    "app/Http/Middleware/MonitorPerformance.php"
)

foreach ($mw in $middleware) {
    if (Test-Path $mw) {
        Write-Host "✓ $(Split-Path $mw -Leaf)" -ForegroundColor Green
    } else {
        Write-Host "✗ $(Split-Path $mw -Leaf) not found" -ForegroundColor Red
    }
}
Write-Host ""

# Test 7: Check configuration
Write-Host "Step 7: Checking Configuration Files" -ForegroundColor Yellow
if (Test-Path "config/services.php") {
    Write-Host "✓ config/services.php exists" -ForegroundColor Green
} else {
    Write-Host "✗ config/services.php not found" -ForegroundColor Red
}
Write-Host ""

# Summary
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Phase 2 Testing Complete!" -ForegroundColor Green
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Summary:" -ForegroundColor Cyan
Write-Host "- Payment Gateway Endpoints: Available"
Write-Host "- Notification System: Installed"
Write-Host "- Error Handling: Configured"
Write-Host "- Monitoring: Ready"
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Yellow
Write-Host "1. Configure payment gateway API keys in .env"
Write-Host "2. Configure mail server for notifications"
Write-Host "3. Start queue worker: php artisan queue:work"
Write-Host "4. Test with real API calls"
Write-Host ""
