# Chapa Payment API Reference

Complete API documentation for the Chapa payment integration in Smart SuperMarket.

---

## Table of Contents

1. [Authentication](#authentication)
2. [Storefront Endpoints](#storefront-endpoints)
3. [Admin Endpoints](#admin-endpoints)
4. [Webhook Endpoint](#webhook-endpoint)
5. [Error Codes](#error-codes)
6. [Testing Guide](#testing-guide)

---

## Authentication

Most endpoints require authentication using Laravel Sanctum tokens.

**Header:**
```
Authorization: Bearer {your_token}
```

**Get Token:**
```bash
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

---

## Storefront Endpoints

### 1. Complete Checkout with Payment

Create an order and initialize Chapa payment in one request.

**Endpoint:** `POST /api/v1/storefront/checkout`

**Authentication:** Required

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
  "shipping_address": "123 Main St, Addis Ababa",
  "phone": "+251911234567"
}
```

**Validation Rules:**
- `items`: required, array, min 1 item
- `items.*.product_id`: required, must exist in products table
- `items.*.quantity`: required, integer, min 1
- `payment_method`: required, one of: chapa, cash, card
- `shipping_address`: optional, string
- `phone`: required, valid phone format (+251XXXXXXXXX or 09XXXXXXXX)

**Success Response (201):**
```json
{
  "success": true,
  "message": "Checkout successful",
  "data": {
    "order": {
      "id": 15,
      "order_number": "ORD-20260310-ABC123",
      "customer_id": 1,
      "subtotal": 1304.35,
      "tax": 195.65,
      "discount": 0,
      "total": 1500.00,
      "status": "pending",
      "payment_status": "pending",
      "created_at": "2026-03-10T10:30:00.000000Z",
      "customer": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
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

**Error Responses:**

*Insufficient Stock (422):*
```json
{
  "success": false,
  "message": "Insufficient stock for Rice 5kg. Available: 5",
  "data": null
}
```

*Validation Error (422):*
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "phone": ["Phone number is required for Chapa payment"]
  }
}
```

*Payment Initialization Failed (422):*
```json
{
  "success": false,
  "message": "Order created but payment initialization failed: Invalid API key",
  "data": {
    "order": { /* order details */ }
  }
}
```

**Frontend Implementation:**
```javascript
const checkout = async (cartItems, shippingAddress, phone) => {
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
        phone: phone,
      }),
    });

    const data = await response.json();

    if (data.success && data.data.payment?.checkout_url) {
      // Redirect to Chapa checkout
      window.location.href = data.data.payment.checkout_url;
    } else {
      // Handle error
      alert(data.message);
    }
  } catch (error) {
    console.error('Checkout failed:', error);
  }
};
```

---

### 2. Initialize Payment for Existing Order

Initialize Chapa payment for an order that was already created.

**Endpoint:** `POST /api/v1/storefront/orders/{order_id}/pay`

**Authentication:** Required

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
    "transaction_id": "TX-1710001234567",
    "checkout_url": "https://checkout.chapa.co/checkout/payment/TX-1710001234567",
    "status": "pending"
  }
}
```

**Error Responses:**

*Order Not Found (404):*
```json
{
  "success": false,
  "message": "Order not found",
  "data": null
}
```

*Order Already Completed (422):*
```json
{
  "success": false,
  "message": "Order already completed",
  "data": null
}
```

**Frontend Implementation:**
```javascript
const payForOrder = async (orderId) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/storefront/orders/${orderId}/pay`,
    {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        payment_method: 'chapa'
      })
    }
  );

  const data = await response.json();

  if (data.success) {
    window.location.href = data.data.checkout_url;
  }
};
```

---

### 3. Check Payment Status

Check the current payment status of an order.

**Endpoint:** `GET /api/v1/storefront/orders/{order_id}/payment-status`

**Authentication:** Required

**Success Response (200):**
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
      "verified_at": "2026-03-10T10:35:00.000000Z"
    }
  }
}
```

**Payment Status Values:**
- `pending`: Payment not yet completed
- `paid`: Payment successful
- `failed`: Payment failed
- `expired`: Payment link expired

**Order Status Values:**
- `pending`: Order awaiting payment
- `processing`: Order being prepared
- `completed`: Order completed
- `cancelled`: Order cancelled

**Frontend Implementation:**
```javascript
// Call this after user returns from Chapa
const checkPaymentStatus = async (orderId) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/storefront/orders/${orderId}/payment-status`,
    {
      headers: {
        'Authorization': `Bearer ${token}`,
      }
    }
  );

  const data = await response.json();

  if (data.data.payment_status === 'paid') {
    // Show success message
    showSuccessMessage('Payment successful!');
    redirectToOrderConfirmation(orderId);
  } else if (data.data.payment_status === 'failed') {
    // Show error message
    showErrorMessage('Payment failed. Please try again.');
  }
};
```

---

## Admin Endpoints

### 1. Initialize Payment (Admin)

Admin endpoint to initialize payment for any order.

**Endpoint:** `POST /api/v1/payments/initialize`

**Authentication:** Required (Admin/Manager)

**Request Body:**
```json
{
  "order_id": 15
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Payment initialized successfully",
  "data": {
    "transaction_id": "TX-1710001234567",
    "checkout_url": "https://checkout.chapa.co/checkout/payment/TX-1710001234567",
    "status": "pending"
  }
}
```

---

### 2. Verify Payment (Admin)

Verify payment status by transaction ID.

**Endpoint:** `GET /api/v1/payments/{transaction_id}/verify`

**Authentication:** Required (Admin/Manager)

**Success Response (200):**
```json
{
  "success": true,
  "message": "Payment status retrieved successfully",
  "data": {
    "transaction_id": "TX-1710001234567",
    "status": "completed",
    "verified": true,
    "amount": 1500.00,
    "currency": "ETB",
    "verified_at": "2026-03-10T10:35:00.000000Z"
  }
}
```

---

## Webhook Endpoint

### Chapa Webhook

This endpoint is called automatically by Chapa when payment status changes.

**Endpoint:** `POST /api/v1/payments/webhook/chapa`

**Authentication:** None (verified by signature)

**Headers:**
```
X-Chapa-Signature: {hmac_sha256_signature}
Content-Type: application/json
```

**Request Body (from Chapa):**
```json
{
  "tx_ref": "TX-1710001234567",
  "status": "success",
  "amount": 1500.00,
  "currency": "ETB",
  "payment_method": "telebirr",
  "customer_email": "john@example.com",
  "customer_name": "John Doe",
  "created_at": "2026-03-10T10:30:00Z"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Webhook processed successfully",
  "data": null
}
```

**What Happens:**
1. Signature is verified using HMAC-SHA256
2. Payment record is updated
3. If payment successful:
   - Order status → `completed`
   - Sale record is created
   - Stock is already deducted (done during checkout)
4. Notifications sent (if configured)

**Webhook Configuration:**

In Chapa Dashboard:
```
Webhook URL: https://yourdomain.com/api/v1/payments/webhook/chapa
```

For local testing with ngrok:
```bash
ngrok http 8000
# Use: https://abc123.ngrok.io/api/v1/payments/webhook/chapa
```

---

## Error Codes

| Code | Message | Description |
|------|---------|-------------|
| 200 | Success | Request successful |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid request data |
| 401 | Unauthorized | Authentication required |
| 404 | Not Found | Resource not found |
| 422 | Validation Error | Request validation failed |
| 500 | Server Error | Internal server error |

---

## Testing Guide

### 1. Test Configuration

```bash
cd backend
php test-chapa-complete.php
```

This will test:
- ✅ Configuration
- ✅ API connectivity
- ✅ Payment initialization
- ✅ Service layer
- ✅ Webhook security

### 2. Test Checkout Flow

**Step 1: Login**
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

**Step 2: Checkout**
```bash
curl -X POST http://localhost:8000/api/v1/storefront/checkout \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {"product_id": 1, "quantity": 2}
    ],
    "payment_method": "chapa",
    "shipping_address": "123 Main St",
    "phone": "+251911234567"
  }'
```

**Step 3: Open Checkout URL**

Copy the `checkout_url` from response and open in browser.

**Step 4: Complete Payment**

Use Chapa test credentials to complete payment.

**Step 5: Check Status**
```bash
curl -X GET http://localhost:8000/api/v1/storefront/orders/15/payment-status \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Test Webhook Locally

```bash
curl -X POST http://localhost:8000/api/v1/payments/webhook/chapa \
  -H "Content-Type: application/json" \
  -H "X-Chapa-Signature: test_signature" \
  -d '{
    "tx_ref": "TX-test",
    "status": "success",
    "amount": 100,
    "currency": "ETB",
    "payment_method": "telebirr"
  }'
```

---

## Payment Flow Diagram

```
┌─────────────┐
│   Customer  │
└──────┬──────┘
       │
       │ 1. Add items to cart
       ▼
┌─────────────────────┐
│  POST /checkout     │
│  - items            │
│  - payment_method   │
│  - phone            │
└──────┬──────────────┘
       │
       │ 2. Create order & initialize payment
       ▼
┌─────────────────────┐
│   Backend           │
│  - Validate stock   │
│  - Create order     │
│  - Call Chapa API   │
└──────┬──────────────┘
       │
       │ 3. Return checkout URL
       ▼
┌─────────────────────┐
│  Chapa Checkout     │
│  - Select method    │
│  - Enter details    │
│  - Confirm payment  │
└──────┬──────────────┘
       │
       │ 4. Send webhook
       ▼
┌─────────────────────┐
│  POST /webhook      │
│  - Verify signature │
│  - Update payment   │
│  - Complete order   │
│  - Create sale      │
└──────┬──────────────┘
       │
       │ 5. Redirect to frontend
       ▼
┌─────────────────────┐
│  Payment Callback   │
│  - Check status     │
│  - Show result      │
└─────────────────────┘
```

---

## Environment Variables

```env
# Chapa Configuration
CHAPPA_MODE=test                                    # test or live
CHAPPA_SECRET_KEY=CHASECK_TEST-your_key_here       # Required
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-your_key_here       # Optional
CHAPPA_WEBHOOK_SECRET=your_webhook_secret          # Required for webhooks

# Application URLs
APP_URL=http://localhost:8000                       # Backend URL
FRONTEND_URL=http://localhost:3001                  # Frontend URL
```

---

## Support

- **Chapa Docs:** https://developer.chapa.co/docs
- **Chapa Support:** support@chapa.co
- **Laravel Logs:** `storage/logs/laravel.log`

---

**Last Updated:** March 10, 2026
**Version:** 1.0.0
