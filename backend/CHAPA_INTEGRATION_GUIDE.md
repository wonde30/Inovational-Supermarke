# Chapa Payment Integration Guide

## Overview
This guide explains how to use the Chapa payment gateway integration in the Smart SuperMarket application.

---

## Configuration

### Step 1: Get Chapa Credentials

1. Sign up at [Chapa Dashboard](https://dashboard.chapa.co/)
2. Get your API keys:
   - Secret Key
   - Public Key (optional)
   - Webhook Secret

### Step 2: Configure .env

Add these to your `backend/.env` file:

```env
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-xxxxxxxxxxxxxxxxxx
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-xxxxxxxxxxxxxxxxxx
CHAPPA_WEBHOOK_SECRET=your_webhook_secret_here

# Frontend URL for payment redirect
FRONTEND_URL=http://localhost:3001
```

**Important:** 
- Use `test` mode for development
- Use `live` mode for production
- Never commit real API keys to version control

---

## Payment Flow

### Complete Checkout Flow

```
1. Customer adds items to cart
   ↓
2. Customer proceeds to checkout
   ↓
3. Backend creates order and initializes Chapa payment
   ↓
4. Customer is redirected to Chapa checkout page
   ↓
5. Customer completes payment on Chapa
   ↓
6. Chapa sends webhook to backend
   ↓
7. Backend verifies payment and completes order
   ↓
8. Customer is redirected back to frontend
```

---

## API Endpoints

### 1. Checkout (Recommended Method)

**Endpoint:** `POST /api/v1/storefront/checkout`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 5,
      "quantity": 1
    }
  ],
  "payment_method": "chapa",
  "shipping_address": "123 Main St, Kombolcha",
  "phone": "+251911234567"
}
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Checkout successful",
  "data": {
    "order": {
      "id": 1,
      "order_number": "ORD-20260309-ABC123",
      "total": 1500.50,
      "status": "pending",
      "payment_status": "pending",
      "customer": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      },
      "orderItems": [...]
    },
    "payment": {
      "gateway": "chapa",
      "transaction_id": "TX-1234567890",
      "checkout_url": "https://checkout.chapa.co/checkout/payment/TX-1234567890",
      "status": "pending"
    }
  }
}
```

**What to do with the response:**
1. Save the `transaction_id` for tracking
2. Redirect user to `checkout_url`
3. User completes payment on Chapa
4. Chapa redirects back to your `return_url`

---

### 2. Initialize Payment for Existing Order

**Endpoint:** `POST /api/v1/storefront/orders/{order_id}/pay`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "payment_method": "chapa"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Payment initialized successfully",
  "data": {
    "transaction_id": "TX-1234567890",
    "checkout_url": "https://checkout.chapa.co/checkout/payment/TX-1234567890",
    "status": "pending"
  }
}
```

---

### 3. Check Payment Status

**Endpoint:** `GET /api/v1/storefront/orders/{order_id}/payment-status`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Payment status retrieved",
  "data": {
    "order_status": "completed",
    "payment_status": "paid",
    "payment": {
      "transaction_id": "TX-1234567890",
      "status": "completed",
      "amount": 1500.50,
      "gateway": "chapa",
      "verified_at": "2026-03-09T10:30:00Z"
    }
  }
}
```

---

### 4. Webhook Endpoint (Called by Chapa)

**Endpoint:** `POST /api/v1/payments/webhook/chapa`

**This is called automatically by Chapa - you don't need to call it manually**

Chapa will send payment status updates to this endpoint.

**Webhook Payload Example:**
```json
{
  "tx_ref": "TX-1234567890",
  "status": "success",
  "amount": 1500.50,
  "currency": "ETB",
  "payment_method": "telebirr",
  "customer_email": "john@example.com"
}
```

---

## Frontend Integration

### React/Next.js Example

```javascript
// 1. Checkout
const checkout = async (cartItems) => {
  try {
    const response = await fetch('http://localhost:8000/api/v1/storefront/checkout', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        items: cartItems,
        payment_method: 'chapa',
        shipping_address: shippingAddress,
        phone: phoneNumber,
      }),
    });

    const data = await response.json();

    if (data.success && data.data.payment?.checkout_url) {
      // Redirect to Chapa checkout
      window.location.href = data.data.payment.checkout_url;
    }
  } catch (error) {
    console.error('Checkout failed:', error);
  }
};

// 2. Handle return from Chapa
// In your payment callback page (e.g., /payment/callback)
useEffect(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  const txRef = urlParams.get('tx_ref');

  if (status === 'success') {
    // Payment successful
    // Fetch order details or show success message
    checkPaymentStatus(orderId);
  } else {
    // Payment failed or cancelled
    // Show error message
  }
}, []);

// 3. Check payment status
const checkPaymentStatus = async (orderId) => {
  try {
    const response = await fetch(
      `http://localhost:8000/api/v1/storefront/orders/${orderId}/payment-status`,
      {
        headers: {
          'Authorization': `Bearer ${token}`,
        },
      }
    );

    const data = await response.json();
    
    if (data.data.payment_status === 'paid') {
      // Show success message
      // Redirect to order confirmation page
    }
  } catch (error) {
    console.error('Failed to check payment status:', error);
  }
};
```

---

## Testing

### Test with Chapa Test Mode

1. Set `CHAPPA_MODE=test` in `.env`
2. Use test API keys from Chapa dashboard
3. Use test payment methods:
   - Test Telebirr: Use test phone numbers provided by Chapa
   - Test cards: Use test card numbers provided by Chapa

### Test Credentials (Example)

Chapa provides test credentials in their dashboard. Common test scenarios:

- **Successful Payment:** Use approved test card/phone
- **Failed Payment:** Use declined test card/phone
- **Pending Payment:** Some test numbers simulate pending status

---

## Webhook Configuration

### Configure Webhook URL in Chapa Dashboard

1. Login to [Chapa Dashboard](https://dashboard.chapa.co/)
2. Go to Settings → Webhooks
3. Add webhook URL: `https://yourdomain.com/api/v1/payments/webhook/chapa`
4. Copy the webhook secret
5. Add to `.env`: `CHAPPA_WEBHOOK_SECRET=your_secret`

**Important for Local Development:**

Chapa cannot reach `localhost`. Use one of these solutions:

1. **ngrok** (Recommended):
   ```bash
   ngrok http 8000
   ```
   Then use the ngrok URL: `https://abc123.ngrok.io/api/v1/payments/webhook/chapa`

2. **Expose.dev**:
   ```bash
   expose share http://localhost:8000
   ```

3. **Deploy to staging server** for testing

---

## Troubleshooting

### Issue: "Payment initialization failed"

**Possible causes:**
1. Invalid API key
2. API key not configured
3. Network error

**Solution:**
```bash
# Check configuration
php artisan tinker
>>> config('services.chappa.secret_key')

# Should return your API key, not null
```

### Issue: "Checkout URL not returned"

**Check logs:**
```bash
tail -f storage/logs/laravel.log
```

Look for Chapa API errors.

### Issue: "Webhook not working"

**Checklist:**
- [ ] Webhook URL is publicly accessible
- [ ] Webhook secret is configured correctly
- [ ] Webhook endpoint doesn't require authentication
- [ ] Check webhook logs in Chapa dashboard

**Test webhook manually:**
```bash
curl -X POST http://localhost:8000/api/v1/payments/webhook/chapa \
  -H "Content-Type: application/json" \
  -H "X-Chapa-Signature: test_signature" \
  -d '{
    "tx_ref": "TX-test",
    "status": "success",
    "amount": 100,
    "currency": "ETB"
  }'
```

### Issue: "Order created but payment not initialized"

**Check:**
1. Chapa credentials in `.env`
2. Network connectivity
3. Chapa API status
4. Laravel logs for detailed error

---

## Security Best Practices

1. **Never expose API keys:**
   - Don't commit to git
   - Use environment variables
   - Rotate keys regularly

2. **Verify webhook signatures:**
   - Always verify `X-Chapa-Signature` header
   - Use HMAC-SHA256 verification

3. **Use HTTPS in production:**
   - Chapa requires HTTPS for webhooks
   - Use SSL certificates

4. **Validate amounts:**
   - Always verify payment amount matches order total
   - Check currency matches

5. **Handle idempotency:**
   - Webhook may be called multiple times
   - Check if payment already processed

---

## Production Checklist

Before going live:

- [ ] Change `CHAPPA_MODE=live`
- [ ] Use live API keys
- [ ] Configure production webhook URL (HTTPS)
- [ ] Test with real small amounts
- [ ] Set up monitoring and alerts
- [ ] Configure proper error handling
- [ ] Set up backup payment methods
- [ ] Test refund process
- [ ] Document customer support procedures

---

## Support

- **Chapa Documentation:** https://developer.chapa.co/docs
- **Chapa Support:** support@chapa.co
- **Laravel Logs:** `storage/logs/laravel.log`

---

## API Reference Summary

| Endpoint | Method | Auth | Description |
|----------|--------|------|-------------|
| `/api/v1/storefront/checkout` | POST | Yes | Complete checkout with payment |
| `/api/v1/storefront/orders/{id}/pay` | POST | Yes | Initialize payment for order |
| `/api/v1/storefront/orders/{id}/payment-status` | GET | Yes | Check payment status |
| `/api/v1/payments/webhook/chapa` | POST | No | Webhook from Chapa |
| `/api/v1/payments/initialize` | POST | Yes | Admin: Initialize payment |
| `/api/v1/payments/{id}/verify` | GET | Yes | Admin: Verify payment |

---

**Last Updated:** March 9, 2026
**Chapa API Version:** v1
