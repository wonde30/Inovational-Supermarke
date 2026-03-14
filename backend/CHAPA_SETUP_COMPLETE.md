# ✅ Chapa Payment Integration - Setup Complete!

## What Was Fixed

### 1. **Storefront Order Controller Updated**
   - Added automatic Chapa payment initialization when `payment_method=chapa`
   - Returns payment data including `checkout_url` for redirect

### 2. **New Checkout Controller Created**
   - `app/Http/Controllers/Api/Storefront/CheckoutController.php`
   - Handles complete checkout flow with payment
   - Supports payment initialization for existing orders
   - Includes payment status checking

### 3. **New API Routes Added**
   ```
   POST /api/v1/storefront/checkout
   POST /api/v1/storefront/orders/{id}/pay
   GET  /api/v1/storefront/orders/{id}/payment-status
   ```

### 4. **Documentation Created**
   - `CHAPA_INTEGRATION_GUIDE.md` - Complete integration guide
   - `test-chapa.php` - Test script to verify setup

---

## 🚀 How to Use (Frontend Integration)

### Method 1: Complete Checkout (Recommended)

```javascript
// When user clicks "Pay with Chapa" button
const checkout = async () => {
  const response = await fetch('http://localhost:8000/api/v1/storefront/checkout', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${userToken}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      items: [
        { product_id: 1, quantity: 2 },
        { product_id: 5, quantity: 1 }
      ],
      payment_method: 'chapa',
      shipping_address: '123 Main St, Kombolcha',
      phone: '+251911234567'
    })
  });

  const data = await response.json();

  if (data.success && data.data.payment?.checkout_url) {
    // Redirect user to Chapa payment page
    window.location.href = data.data.payment.checkout_url;
  }
};
```

### Method 2: Pay for Existing Order

```javascript
// If order already exists, initialize payment
const payForOrder = async (orderId) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/storefront/orders/${orderId}/pay`,
    {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${userToken}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        payment_method: 'chapa'
      })
    }
  );

  const data = await response.json();

  if (data.success && data.data.checkout_url) {
    // Redirect to Chapa
    window.location.href = data.data.checkout_url;
  }
};
```

### Method 3: Check Payment Status

```javascript
// After user returns from Chapa, check payment status
const checkPayment = async (orderId) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/storefront/orders/${orderId}/payment-status`,
    {
      headers: {
        'Authorization': `Bearer ${userToken}`,
      }
    }
  );

  const data = await response.json();

  if (data.data.payment_status === 'paid') {
    // Show success message
    console.log('Payment successful!');
  }
};
```

---

## ⚙️ Required Configuration

### Step 1: Get Chapa API Keys

1. Go to https://dashboard.chapa.co/
2. Sign up or login
3. Navigate to Settings → API Keys
4. Copy your **Secret Key**

### Step 2: Update .env File

Open `backend/.env` and add:

```env
# Chapa Payment Gateway
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-your_actual_key_here
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-your_public_key_here
CHAPPA_WEBHOOK_SECRET=your_webhook_secret_here
```

**Important:**
- Use `test` mode for development
- Use `live` mode for production
- Get real keys from Chapa dashboard

### Step 3: Test the Integration

```bash
cd backend
php test-chapa.php
```

This will verify:
- ✅ Configuration is correct
- ✅ Chapa API is accessible
- ✅ Payment initialization works
- ✅ Returns checkout URL

---

## 🔄 Complete Payment Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    PAYMENT FLOW                              │
└─────────────────────────────────────────────────────────────┘

1. Frontend: User adds items to cart
   └─> Items stored in cart

2. Frontend: User clicks "Checkout with Chapa"
   └─> POST /api/v1/storefront/checkout
       {
         items: [...],
         payment_method: "chapa",
         shipping_address: "...",
         phone: "..."
       }

3. Backend: Creates order and initializes Chapa payment
   └─> Returns: {
         order: {...},
         payment: {
           checkout_url: "https://checkout.chapa.co/...",
           transaction_id: "TX-123..."
         }
       }

4. Frontend: Redirects user to checkout_url
   └─> window.location.href = checkout_url

5. User: Completes payment on Chapa website
   └─> Selects payment method (Telebirr, CBE Birr, etc.)
   └─> Enters payment details
   └─> Confirms payment

6. Chapa: Sends webhook to backend
   └─> POST /api/v1/payments/webhook/chapa
       {
         tx_ref: "TX-123...",
         status: "success",
         amount: 1500.50,
         payment_method: "telebirr"
       }

7. Backend: Verifies webhook signature
   └─> Updates payment status
   └─> Completes order
   └─> Creates sale record

8. Chapa: Redirects user back to frontend
   └─> http://localhost:3001/payment/callback?status=success&tx_ref=TX-123

9. Frontend: Shows success message
   └─> GET /api/v1/storefront/orders/{id}/payment-status
   └─> Displays order confirmation
```

---

## 🧪 Testing Guide

### Test in Development

1. **Set test mode:**
   ```env
   CHAPPA_MODE=test
   CHAPPA_SECRET_KEY=CHASECK_TEST-...
   ```

2. **Run test script:**
   ```bash
   php test-chapa.php
   ```

3. **Test checkout flow:**
   - Create order via API
   - Get checkout URL
   - Open URL in browser
   - Use Chapa test credentials
   - Complete test payment

### Test Credentials

Chapa provides test payment methods:
- Test Telebirr numbers
- Test CBE Birr accounts
- Test card numbers

Check Chapa documentation for current test credentials.

---

## 🔧 Webhook Setup

### For Local Development

Chapa cannot reach `localhost`, so use **ngrok**:

```bash
# Install ngrok
# Download from https://ngrok.com/

# Start ngrok
ngrok http 8000

# Copy the HTTPS URL (e.g., https://abc123.ngrok.io)
# Configure in Chapa dashboard:
# Webhook URL: https://abc123.ngrok.io/api/v1/payments/webhook/chapa
```

### For Production

1. Deploy your application to a server with HTTPS
2. Configure webhook URL in Chapa dashboard:
   ```
   https://yourdomain.com/api/v1/payments/webhook/chapa
   ```
3. Copy webhook secret from Chapa
4. Add to production `.env`:
   ```env
   CHAPPA_WEBHOOK_SECRET=your_webhook_secret
   ```

---

## 📝 API Response Examples

### Successful Checkout Response

```json
{
  "success": true,
  "message": "Checkout successful",
  "data": {
    "order": {
      "id": 15,
      "order_number": "ORD-20260309-XYZ789",
      "customer_id": 1,
      "subtotal": 1304.35,
      "tax": 195.65,
      "total": 1500.00,
      "status": "pending",
      "payment_status": "pending",
      "customer": {
        "id": 1,
        "name": "Almaz Tadesse",
        "email": "almaz@email.com",
        "phone": "+251911234567"
      },
      "orderItems": [
        {
          "id": 25,
          "product_id": 1,
          "quantity": 2,
          "unit_price": 450.00,
          "total": 900.00,
          "product": {
            "id": 1,
            "name": "Rice 5kg",
            "sku": "FOOD-002"
          }
        }
      ]
    },
    "payment": {
      "gateway": "chapa",
      "transaction_id": "TX-1710001234567",
      "checkout_url": "https://checkout.chapa.co/checkout/payment/TX-1710001234567",
      "status": "pending"
    }
  }
}
```

### Payment Status Response

```json
{
  "success": true,
  "message": "Payment status retrieved",
  "data": {
    "order_status": "completed",
    "payment_status": "paid",
    "payment": {
      "transaction_id": "TX-1710001234567",
      "status": "completed",
      "amount": 1500.00,
      "gateway": "chapa",
      "verified_at": "2026-03-09T14:30:00.000000Z"
    }
  }
}
```

---

## ❌ Common Errors & Solutions

### Error: "Payment initialization failed"

**Cause:** Invalid or missing API key

**Solution:**
```bash
# Check configuration
php artisan tinker
>>> config('services.chappa.secret_key')

# Should return your key, not null
# If null, add to .env:
CHAPPA_SECRET_KEY=your_key_here

# Clear config cache
php artisan config:clear
```

### Error: "Checkout URL not returned"

**Cause:** Chapa API error or network issue

**Solution:**
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify API key is correct
3. Check Chapa API status
4. Ensure internet connection

### Error: "Webhook not working"

**Cause:** Webhook URL not accessible or signature mismatch

**Solution:**
1. Use ngrok for local testing
2. Verify webhook secret matches
3. Check webhook logs in Chapa dashboard
4. Ensure endpoint is public (no auth required)

---

## 📚 Files Created/Modified

### New Files
- ✅ `app/Http/Controllers/Api/Storefront/CheckoutController.php`
- ✅ `CHAPA_INTEGRATION_GUIDE.md`
- ✅ `CHAPA_SETUP_COMPLETE.md`
- ✅ `test-chapa.php`

### Modified Files
- ✅ `app/Http/Controllers/Api/Storefront/OrderController.php`
- ✅ `routes/api.php`

### Existing Files (Already Working)
- ✅ `app/Services/ChapaPaymentService.php`
- ✅ `app/Services/PaymentGateway/ChappaGateway.php`
- ✅ `app/Http/Controllers/Api/PaymentController.php`

---

## ✅ Checklist

Before testing:
- [ ] Chapa account created
- [ ] API keys obtained
- [ ] `.env` file updated with keys
- [ ] Config cache cleared (`php artisan config:clear`)
- [ ] Test script runs successfully (`php test-chapa.php`)

For production:
- [ ] Change to live mode
- [ ] Use live API keys
- [ ] Configure webhook URL (HTTPS)
- [ ] Test with small real amounts
- [ ] Set up monitoring

---

## 🎯 Next Steps

1. **Get Chapa API Keys:**
   - Sign up at https://dashboard.chapa.co/
   - Get test API keys

2. **Configure .env:**
   ```env
   CHAPPA_SECRET_KEY=your_key_here
   ```

3. **Test Integration:**
   ```bash
   php test-chapa.php
   ```

4. **Integrate Frontend:**
   - Use checkout endpoint
   - Redirect to checkout_url
   - Handle payment callback

5. **Test Complete Flow:**
   - Place test order
   - Complete payment on Chapa
   - Verify order completion

---

## 📞 Support

- **Chapa Docs:** https://developer.chapa.co/docs
- **Chapa Support:** support@chapa.co
- **Laravel Logs:** `storage/logs/laravel.log`
- **Integration Guide:** `CHAPA_INTEGRATION_GUIDE.md`

---

**Status:** ✅ Integration Complete - Ready for Configuration
**Date:** March 9, 2026
**Version:** 1.0
