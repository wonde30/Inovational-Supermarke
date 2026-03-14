# Quick Start: Chapa Auto-Complete Orders

## ✅ Setup Complete!

Your system is now configured to automatically complete orders when customers pay through Chapa. No admin approval needed!

## How to Test

### 1. Start Your Servers

```bash
# Terminal 1 - Backend
cd backend
php artisan serve

# Terminal 2 - Frontend
cd frontend
npm run dev
```

### 2. Make a Test Purchase

1. Open browser: `http://localhost:3000`
2. Login as customer
3. Add products to cart
4. Click "Checkout"
5. Select "Chapa" payment method
6. Enter phone: `+251911234567` (or `0911234567`)
7. Click "Pay Now"
8. Complete payment on Chapa page
9. You'll be redirected back with success message

### 3. Verify Auto-Completion

**Option A: Check "My Orders" Page**
- Go to "My Orders" in the menu
- Your order should show: ✅ Completed
- Invoice number displayed

**Option B: Check Database**
```sql
SELECT order_number, status, payment_status, sale_id 
FROM orders 
ORDER BY created_at DESC 
LIMIT 1;
```

Should show:
- `status`: "completed"
- `payment_status`: "paid"
- `sale_id`: (number)

## Webhook Configuration

### For Local Testing (with ngrok)

1. Install ngrok: https://ngrok.com/download

2. Start ngrok:
```bash
ngrok http 8000
```

3. Copy the HTTPS URL (e.g., `https://abc123.ngrok.io`)

4. Configure in Chapa dashboard:
```
Webhook URL: https://abc123.ngrok.io/api/v1/payments/webhook/chapa
```

### For Production

Configure in Chapa dashboard:
```
Webhook URL: https://yourdomain.com/api/v1/payments/webhook/chapa
```

## Verification Commands

### Check Setup
```bash
cd backend
php verify-auto-complete-setup.php
```

### Test Webhook Flow
```bash
cd backend
php test-webhook-flow.php TX-YOUR-TRANSACTION-ID
```

### Monitor Logs
```bash
# All logs
tail -f storage/logs/laravel.log

# Webhook logs only
tail -f storage/logs/laravel.log | grep webhook

# Payment logs only
tail -f storage/logs/laravel.log | grep payment
```

## What Happens Automatically

```
Customer Pays
     ↓
Chapa Webhook → Your Server
     ↓
✅ Order Status: "completed"
✅ Payment Status: "paid"
✅ Sale Record: Created with invoice
✅ Customer Notification: "Order completed! 🎉"
```

## Status Indicators

| Icon | Status | Meaning |
|------|--------|---------|
| ⏳ | Pending | Awaiting payment |
| ✅ | Completed | Payment received, order fulfilled |
| ❌ | Cancelled | Order cancelled |

## Troubleshooting

### Order stays "Pending"

**Check webhook is configured:**
```
Chapa Dashboard → Settings → Webhook URL
Should be: http://localhost:8000/api/v1/payments/webhook/chapa
```

**Check logs:**
```bash
tail -f storage/logs/laravel.log | grep webhook
```

### "No transaction reference found"

This means the payment wasn't initialized properly. Check:
1. Chapa credentials in `.env`
2. Customer email is valid format
3. Phone number is valid (+251... format)

### Frontend shows old status

Frontend polls every 10 seconds. Either:
- Wait 10 seconds
- Refresh the page

## Configuration Files

### Backend (.env)
```env
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-9OWHgYHvdm1jM3QUpgBNNdGTsRh5ygA2
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-9OWHgYHvdm1jM3QUpgBNNdGTsRh5ygA2
CHAPPA_WEBHOOK_SECRET=chapa_webhook_secret_2026
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
```

### Chapa Dashboard
- Webhook URL: `http://localhost:8000/api/v1/payments/webhook/chapa`
- Mode: Test
- Webhook Secret: `chapa_webhook_secret_2026`

## API Endpoints

### Customer Endpoints
```
POST   /api/v1/storefront/checkout
GET    /api/v1/storefront/orders
GET    /api/v1/storefront/orders/{id}/payment-status
```

### Webhook Endpoint (Chapa → Backend)
```
POST   /api/v1/payments/webhook/chapa
```

## Support Files

| File | Purpose |
|------|---------|
| `CHAPA_AUTO_COMPLETE_SUMMARY.md` | Overview and summary |
| `CHAPA_AUTO_COMPLETE_IMPLEMENTATION.md` | Technical details |
| `verify-auto-complete-setup.php` | Verify setup |
| `test-webhook-flow.php` | Test webhook processing |

## Success Checklist

- [x] ✅ Chapa credentials configured
- [x] ✅ Database tables exist
- [x] ✅ Order model has payment_status field
- [x] ✅ ChapaPaymentService configured
- [x] ✅ Routes registered
- [ ] ⚠️  Webhook URL configured in Chapa dashboard (YOU NEED TO DO THIS)

## Next Steps

1. **Configure Webhook in Chapa Dashboard**
   - Login to Chapa dashboard
   - Go to Settings → Webhooks
   - Add: `http://localhost:8000/api/v1/payments/webhook/chapa`

2. **Test the Flow**
   - Make a test purchase
   - Complete payment
   - Verify order auto-completes

3. **Monitor First Payment**
   ```bash
   tail -f storage/logs/laravel.log | grep webhook
   ```

4. **Go to Production**
   - Update Chapa credentials to live keys
   - Set `CHAPPA_MODE=live`
   - Update webhook URL to production domain

---

## 🎉 You're Ready!

Your Chapa payment integration is fully automated. Orders will complete automatically when customers pay successfully.

**Questions?** Check the documentation files or run the verification script.

**Date**: March 10, 2026
