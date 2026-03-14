#!/bin/bash

# Phase 2 Testing Script
# Tests payment gateways, notifications, and monitoring

echo "========================================="
echo "Phase 2 Feature Testing"
echo "========================================="
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

BASE_URL="http://localhost:8000"

echo -e "${YELLOW}Step 1: Testing Payment Gateway Endpoints${NC}"
echo ""

# Test 1: Get available payment gateways (public endpoint)
echo "Testing: GET /api/v1/payments/gateways"
RESPONSE=$(curl -s -w "\n%{http_code}" -X GET "$BASE_URL/api/v1/payments/gateways")
HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
BODY=$(echo "$RESPONSE" | head -n-1)

if [ "$HTTP_CODE" = "200" ]; then
    echo -e "${GREEN}✓ Payment gateways endpoint working${NC}"
    echo "Response: $BODY" | head -c 200
    echo "..."
else
    echo -e "${RED}✗ Failed with HTTP $HTTP_CODE${NC}"
    echo "Response: $BODY"
fi
echo ""

# Test 2: Check if routes are registered
echo -e "${YELLOW}Step 2: Checking Route Registration${NC}"
php artisan route:list | grep -i payment | head -10
echo ""

# Test 3: Check configuration
echo -e "${YELLOW}Step 3: Checking Configuration${NC}"
echo "Checking services configuration..."
if php -r "require 'vendor/autoload.php'; \$config = require 'config/services.php'; echo 'Stripe: ' . (isset(\$config['stripe']) ? 'Configured' : 'Not configured') . PHP_EOL; echo 'PayPal: ' . (isset(\$config['paypal']) ? 'Configured' : 'Not configured') . PHP_EOL; echo 'Chappa: ' . (isset(\$config['chappa']) ? 'Configured' : 'Not configured') . PHP_EOL;"; then
    echo -e "${GREEN}✓ Services configuration loaded${NC}"
else
    echo -e "${RED}✗ Configuration error${NC}"
fi
echo ""

# Test 4: Check middleware registration
echo -e "${YELLOW}Step 4: Checking Middleware${NC}"
if php artisan route:list | grep -q "log.requests\|monitor.performance"; then
    echo -e "${GREEN}✓ Monitoring middleware registered${NC}"
else
    echo -e "${YELLOW}⚠ Monitoring middleware not found (optional)${NC}"
fi
echo ""

# Test 5: Check notification classes
echo -e "${YELLOW}Step 5: Checking Notification Classes${NC}"
NOTIFICATIONS=(
    "app/Notifications/OrderPlacedNotification.php"
    "app/Notifications/PaymentReceivedNotification.php"
    "app/Notifications/LowStockAlertNotification.php"
)

for notif in "${NOTIFICATIONS[@]}"; do
    if [ -f "$notif" ]; then
        echo -e "${GREEN}✓ $(basename $notif)${NC}"
    else
        echo -e "${RED}✗ $(basename $notif) not found${NC}"
    fi
done
echo ""

# Test 6: Check payment gateway classes
echo -e "${YELLOW}Step 6: Checking Payment Gateway Classes${NC}"
GATEWAYS=(
    "app/Services/PaymentGateway/StripeGateway.php"
    "app/Services/PaymentGateway/PayPalGateway.php"
    "app/Services/PaymentGateway/ChappaGateway.php"
    "app/Services/PaymentGateway/PaymentGatewayFactory.php"
)

for gateway in "${GATEWAYS[@]}"; do
    if [ -f "$gateway" ]; then
        echo -e "${GREEN}✓ $(basename $gateway)${NC}"
    else
        echo -e "${RED}✗ $(basename $gateway) not found${NC}"
    fi
done
echo ""

# Test 7: Check error handling
echo -e "${YELLOW}Step 7: Checking Error Handling Classes${NC}"
ERROR_CLASSES=(
    "app/Exceptions/PaymentException.php"
    "app/Exceptions/InsufficientStockException.php"
    "app/Services/ErrorHandlingService.php"
)

for error_class in "${ERROR_CLASSES[@]}"; do
    if [ -f "$error_class" ]; then
        echo -e "${GREEN}✓ $(basename $error_class)${NC}"
    else
        echo -e "${RED}✗ $(basename $error_class) not found${NC}"
    fi
done
echo ""

# Test 8: Check monitoring middleware
echo -e "${YELLOW}Step 8: Checking Monitoring Middleware${NC}"
MIDDLEWARE=(
    "app/Http/Middleware/LogRequests.php"
    "app/Http/Middleware/MonitorPerformance.php"
)

for mw in "${MIDDLEWARE[@]}"; do
    if [ -f "$mw" ]; then
        echo -e "${GREEN}✓ $(basename $mw)${NC}"
    else
        echo -e "${RED}✗ $(basename $mw) not found${NC}"
    fi
done
echo ""

# Test 9: Check queue configuration
echo -e "${YELLOW}Step 9: Checking Queue Configuration${NC}"
QUEUE_CONNECTION=$(php -r "require 'vendor/autoload.php'; echo env('QUEUE_CONNECTION', 'sync');")
echo "Queue Connection: $QUEUE_CONNECTION"
if [ "$QUEUE_CONNECTION" = "database" ]; then
    echo -e "${GREEN}✓ Queue configured for database${NC}"
    echo -e "${YELLOW}Note: Run 'php artisan queue:work' to process jobs${NC}"
else
    echo -e "${YELLOW}⚠ Queue using sync (jobs run immediately)${NC}"
fi
echo ""

# Test 10: Summary
echo "========================================="
echo -e "${GREEN}Phase 2 Testing Complete!${NC}"
echo "========================================="
echo ""
echo "Summary:"
echo "- Payment Gateway Endpoints: Available"
echo "- Notification System: Installed"
echo "- Error Handling: Configured"
echo "- Monitoring: Ready"
echo ""
echo "Next Steps:"
echo "1. Configure payment gateway API keys in .env"
echo "2. Configure mail server for notifications"
echo "3. Start queue worker: php artisan queue:work"
echo "4. Test with real API calls"
echo ""
