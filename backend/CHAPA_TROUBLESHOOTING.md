# Chapa Payment Troubleshooting Guide

Common issues and solutions for Chapa payment integration.

---

## Table of Contents

1. [Configuration Issues](#configuration-issues)
2. [Payment Initialization Errors](#payment-initialization-errors)
3. [Webhook Problems](#webhook-problems)
4. [API Response Errors](#api-response-errors)
5. [Database Issues](#database-issues)
6. [Testing Problems](#testing-problems)

---

## Configuration Issues

### Issue: "Chapa secret key not configured"

**Symptoms:**
- Payment initialization fails
- Error: "Payment initialization failed"
- Logs show: "Chapa secret key not configured"

**Solution:**

1. Check `.env` file:
```bash
cat backend/.env | grep CHAPPA
```

2. Ensure these variables are set:
```env
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-your_actual_key_here
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-your_public_key_here
CHAPPA_WEBHOOK_SECRET=your_webhook_secret_here
```

3. Clear config cache:
```bash
cd backend
php artisan config:clear
php artisan config:cache
```

4. Verify configuration:
```bash
php artisan tinker
>>> config('services.chappa.secret_key')
```

Should return your key, not `null`.

---

### Issue: "Invalid API key"

**Symptoms:**
- Chapa API returns 401 Unauthorized
- Error: "Invalid API key"

**Solution:**

1. Verify your API key in Chapa dashboard:
   - Login to https://dashboard.chapa.co/
   - Go to Settings → API Keys
   - Copy the correct key

2. Check key format:
   - Test keys start with: `CHASECK_TEST-`
   - Live keys start with: `CHASECK_LIVE-`

3. Ensure no extra spaces:
```env
# Wrong
CHAPPA_SECRET_KEY= CHASECK_TEST-abc123

# Correct
CHAPPA_SECRET_KEY=CHASECK_TEST-abc123
```

4. Update `.env` and clear cache:
```bash
php artisan config:clear
```

---

## Payment Initialization Errors

### Issue: "Payment initialization failed"

**Symptoms:**
- Checkout returns error
- No checkout URL generated
- Order created but payment not initialized

**Debugging Steps:**

1. Check Laravel logs:
```bash
tail -f backend/storage/logs/laravel.log
```

2. Look for Chapa API response:
```
[2026-03-10 10:30:00] local.INFO: Chapa API Response
{
  "status_code": 400,
  "response": {
    "message": "Invalid phone number format"
  }
}
```

3. Common causes:

**a) Invalid phone number:**
```json
// Wrong
"phone": "0911234567"

// Correct
"phone": "+251911234567"
```

**b) Missing required fields:**
```json
{
  "items": [...],
  "payment_method": "chapa",
  "phone": "+251911234567"  // Required!
}
```

**c) Insufficient stock:**
- Check product quantity before checkout
- Error: "Insufficient stock for Product X"

**d) Network issues:**
- Check internet connection
- Verify Chapa API status
- Try again after a few minutes

---

### Issue: "Checkout URL not returned"

**Symptoms:**
- Payment initialized but no `checkout_url` in response
- Response has `transaction_id` but missing URL

**Solution:**

1. Check Chapa API response in logs:
```bash
grep "Chapa API Response" backend/storage/logs/laravel.log
```

2. Verify response structure:
```json
{
  "status": "success",
  "data": {
    "tx_ref": "TX-123",
    "checkout_url": "https://checkout.chapa.co/..."
  }
}
```

3. If `checkout_url` is missing, contact Chapa support.

---

## Webhook Problems

### Issue: "Webhook not working"

**Symptoms:**
- Payment completed on Chapa but order status not updated
- Webhook logs show no incoming requests
- Order remains in "pending" status

**Solution:**

**For Local Development:**

1. Use ngrok to expose localhost:
```bash
# Install ngrok from https://ngrok.com/

# Start ngrok
ngrok http 8000

# Copy the HTTPS URL
# Example: https://abc123.ngrok.io
```

2. Configure webhook in Chapa dashboard:
```
Webhook URL: https://abc123.ngrok.io/api/v1/payments/webhook/chapa
```

3. Test webhook:
```bash
curl -X POST https://abc123.ngrok.io/api/v1/payments/webhook/chapa \
  -H "Content-Type: application/json" \
  -H "X-Chapa-Signature: test" \
  -d '{"tx_ref":"TEST-123","status":"success"}'
```

**For Production:**

1. Ensure HTTPS is enabled
2. Configure webhook URL:
```
https://yourdomain.com/api/v1/payments/webhook/chapa
```

3. Verify webhook endpoint is accessible:
```bash
curl -X POST https://yourdomain.com/api/v1/payments/webhook/chapa \
  -H "Content-Type: application/json" \
  -d '{"test":"data"}'
```

Should return 200 or 400, not 404.

---

### Issue: "Invalid webhook signature"

**Symptoms:**
- Webhook received but rejected
- Error: "Invalid signature"
- Logs show: "Invalid webhook signature received"

**Solution:**

1. Check webhook secret in `.env`:
```env
CHAPPA_WEBHOOK_SECRET=your_webhook_secret_here
```

2. Get correct webhook secret from Chapa dashboard:
   - Settings → Webhooks
   - Copy the webhook secret

3. Update `.env` and clear cache:
```bash
php artisan config:clear
```

4. Verify signature generation:
```php
$payload = ['tx_ref' => 'TEST-123', 'status' => 'success'];
$secret = config('services.chappa.webhook_secret');
$signature = hash_hmac('sha256', json_encode($payload), $secret);
echo $signature;
```

---

### Issue: "Duplicate webhook processing"

**Symptoms:**
- Same webhook received multiple times
- Order completed multiple times
- Duplicate sale records

**Solution:**

The system handles this automatically with idempotent processing:

```php
// In ChapaPaymentService::handleWebhook()
if ($payment->status === 'completed') {
    return ['success' => true, 'message' => 'Payment already processed'];
}
```

If you still see duplicates:

1. Check webhook logs in Chapa dashboard
2. Verify webhook URL is correct (no duplicates)
3. Check for multiple webhook configurations

---

## API Response Errors

### Issue: "Array to string conversion"

**Symptoms:**
- Error: "Array to string conversion"
- Payment initialization fails

**Cause:**
Chapa API returned an array in error field instead of string.

**Solution:**

Already fixed in `ChappaGateway.php`:

```php
$errorMessage = is_array($responseData['error']) 
    ? json_encode($responseData['error']) 
    : $responseData['error'];
```

If you still see this error:

1. Update `ChappaGateway.php` with the latest version
2. Clear cache:
```bash
php artisan config:clear
composer dump-autoload
```

---

### Issue: "Undefined array key 'tx_ref'"

**Symptoms:**
- Error when processing Chapa response
- Payment initialization fails

**Cause:**
Chapa API response structure different than expected.

**Solution:**

1. Check actual response in logs:
```bash
grep "Chapa API Response" backend/storage/logs/laravel.log | tail -1
```

2. Update `ChappaGateway.php` to handle missing keys:
```php
'transaction_id' => $data['tx_ref'] ?? $txRef,
'checkout_url' => $data['checkout_url'] ?? null,
```

---

## Database Issues

### Issue: "Payment record not created"

**Symptoms:**
- Checkout successful but no payment in database
- Webhook fails to find payment

**Solution:**

1. Check database connection:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

2. Verify payments table exists:
```bash
php artisan migrate:status
```

3. Check for migration errors:
```bash
php artisan migrate
```

4. Manually check database:
```sql
SELECT * FROM payments ORDER BY id DESC LIMIT 5;
```

---

### Issue: "Order not found for webhook"

**Symptoms:**
- Webhook received but order not found
- Error: "Payment not found"

**Solution:**

1. Check transaction ID in webhook payload:
```json
{
  "tx_ref": "TX-1710001234567"
}
```

2. Search for payment in database:
```sql
SELECT * FROM payments WHERE transaction_id = 'TX-1710001234567';
```

3. If not found, check:
   - Payment was created during initialization
   - Transaction ID matches exactly
   - No database errors during creation

---

## Testing Problems

### Issue: "Test script fails"

**Symptoms:**
- `php test-chapa-complete.php` shows errors
- Tests fail at various stages

**Solutions:**

**Test 1 fails (Configuration):**
```bash
# Check .env file
cat backend/.env | grep CHAPPA

# Clear cache
php artisan config:clear
```

**Test 2 fails (API Connectivity):**
```bash
# Check internet connection
ping api.chapa.co

# Check firewall
# Ensure port 443 (HTTPS) is open
```

**Test 3 fails (Payment Initialization):**
```bash
# Check API key validity
# Login to Chapa dashboard and verify key

# Check logs
tail -f backend/storage/logs/laravel.log
```

**Test 4 fails (Service Layer):**
```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Run migrations
php artisan migrate
```

---

### Issue: "Cannot test with real payment"

**Symptoms:**
- Want to test but don't want to use real money
- Need test credentials

**Solution:**

1. Use test mode:
```env
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-your_test_key
```

2. Get test credentials from Chapa:
   - Login to dashboard
   - Switch to test mode
   - Use test payment methods

3. Test payment methods:
   - Test Telebirr numbers
   - Test CBE Birr accounts
   - Test card numbers

Check Chapa documentation for current test credentials.

---

## Common Error Messages

| Error | Cause | Solution |
|-------|-------|----------|
| "Invalid API key" | Wrong or expired key | Update key in .env |
| "Payment initialization failed" | Various causes | Check logs for details |
| "Insufficient stock" | Product out of stock | Restock product |
| "Invalid phone number" | Wrong format | Use +251XXXXXXXXX |
| "Order not found" | Wrong order ID | Verify order exists |
| "Payment already exists" | Duplicate payment | Use existing payment |
| "Invalid signature" | Wrong webhook secret | Update webhook secret |
| "Order already completed" | Order already paid | Cannot pay again |

---

## Debug Checklist

When facing issues, check these in order:

- [ ] Configuration in `.env` is correct
- [ ] Config cache cleared (`php artisan config:clear`)
- [ ] API key is valid and active
- [ ] Internet connection working
- [ ] Chapa API status is operational
- [ ] Database connection working
- [ ] Migrations are up to date
- [ ] Laravel logs checked (`storage/logs/laravel.log`)
- [ ] Phone number in correct format
- [ ] Products have sufficient stock
- [ ] Webhook URL is accessible (for production)
- [ ] Webhook secret is correct

---

## Getting Help

If you're still stuck:

1. **Check Laravel logs:**
```bash
tail -100 backend/storage/logs/laravel.log
```

2. **Enable debug mode:**
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

3. **Test with Postman:**
   - Import `CHAPA_POSTMAN_COLLECTION_V2.json`
   - Test each endpoint individually

4. **Contact Chapa support:**
   - Email: support@chapa.co
   - Dashboard: https://dashboard.chapa.co/support

5. **Check Chapa documentation:**
   - https://developer.chapa.co/docs

---

## Useful Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check configuration
php artisan tinker
>>> config('services.chappa')

# Check database
php artisan tinker
>>> \App\Models\Payment::latest()->first()

# View logs
tail -f storage/logs/laravel.log

# Test Chapa integration
php test-chapa-complete.php

# Run migrations
php artisan migrate

# Seed test data
php artisan db:seed
```

---

**Last Updated:** March 10, 2026
**Version:** 1.0.0
