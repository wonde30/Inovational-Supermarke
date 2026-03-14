# Chapa Payment Flow - Visual Diagram

## Complete Auto-Complete Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                         CUSTOMER JOURNEY                             │
└─────────────────────────────────────────────────────────────────────┘

    👤 Customer
       │
       ├─► 🛒 Add items to cart
       │
       ├─► 💳 Click "Checkout"
       │
       ├─► Select "Chapa" payment
       │
       ├─► Enter phone: +251911234567
       │
       └─► Click "Pay Now"
              │
              ▼

┌─────────────────────────────────────────────────────────────────────┐
│                      BACKEND: ORDER CREATION                         │
└─────────────────────────────────────────────────────────────────────┘

    📦 CheckoutController.php
       │
       ├─► Create Order
       │   ├─ order_number: ORD-20260310-ABC123
       │   ├─ status: "pending"
       │   ├─ payment_status: "pending"
       │   └─ total: ETB 1,500.00
       │
       ├─► Create OrderItems
       │   └─ Deduct stock immediately
       │
       └─► Initialize Chapa Payment
              │
              ├─► ChapaPaymentService.php
              │   └─► ChappaGateway.php
              │       └─► POST https://api.chapa.co/v1/transaction/initialize
              │
              └─► Create Payment Record
                  ├─ transaction_id: TX-20260310-XYZ789
                  ├─ status: "pending"
                  ├─ checkout_url: https://checkout.chapa.co/...
                  └─ expires_at: +30 minutes
                     │
                     ▼

┌─────────────────────────────────────────────────────────────────────┐
│                    CUSTOMER: CHAPA PAYMENT PAGE                      │
└─────────────────────────────────────────────────────────────────────┘

    🌐 Chapa Checkout Page
       │
       ├─► Customer selects payment method:
       │   ├─ 📱 Telebirr
       │   ├─ 🏦 CBE Birr
       │   ├─ 💰 M-Pesa
       │   └─ 💳 Amole
       │
       ├─► Customer enters PIN/password
       │
       └─► Payment processed
              │
              ├─► ✅ Success → Redirect to frontend
              │   └─ URL: http://localhost:3000/payment/callback?order_id=1&status=success
              │
              └─► ❌ Failed → Redirect to frontend
                  └─ URL: http://localhost:3000/payment/callback?status=failed
                     │
                     ▼

┌─────────────────────────────────────────────────────────────────────┐
│                    CHAPA: WEBHOOK NOTIFICATION                       │
└─────────────────────────────────────────────────────────────────────┘

    🔔 Chapa Server
       │
       └─► POST http://localhost:8000/api/v1/payments/webhook/chapa
           │
           ├─ Headers:
           │  └─ X-Chapa-Signature: abc123...
           │
           └─ Body:
              {
                "tx_ref": "TX-20260310-XYZ789",
                "status": "success",
                "payment_method": "telebirr",
                "amount": 1500.00,
                "currency": "ETB"
              }
              │
              ▼

┌─────────────────────────────────────────────────────────────────────┐
│                  BACKEND: WEBHOOK PROCESSING                         │
└─────────────────────────────────────────────────────────────────────┘

    🔐 PaymentController.php → chapaWebhook()
       │
       ├─► 1. Verify Signature
       │   ├─ Get webhook secret from .env
       │   ├─ Compute HMAC-SHA256
       │   └─ Compare signatures
       │      │
       │      ├─► ✅ Valid → Continue
       │      └─► ❌ Invalid → Return 401
       │
       ├─► 2. Find Payment Record
       │   └─ WHERE transaction_id = "TX-20260310-XYZ789"
       │      │
       │      ├─► ✅ Found → Continue
       │      └─► ❌ Not found → Return 404
       │
       ├─► 3. Check Duplicate
       │   └─ IF payment.status === "completed"
       │      └─► Return 200 (already processed)
       │
       ├─► 4. Update Payment
       │   ├─ status: "completed"
       │   ├─ payment_method: "telebirr"
       │   ├─ webhook_data: {...}
       │   └─ verified_at: now()
       │
       └─► 5. Complete Order
              │
              ▼

    🎯 ChapaPaymentService.php → completeOrderWithSale()
       │
       ├─► Start Database Transaction
       │
       ├─► Create Sale Record
       │   ├─ invoice_number: INV-20260310-0001
       │   ├─ total: ETB 1,500.00
       │   ├─ payment_method: "telebirr"
       │   ├─ payment_status: "paid"
       │   └─ status: "completed"
       │
       ├─► Create SaleItems
       │   └─ Copy from OrderItems
       │
       ├─► Update Order
       │   ├─ status: "completed" ✅
       │   ├─ payment_status: "paid" ✅
       │   └─ sale_id: 123
       │
       ├─► Create Audit Log
       │
       └─► Commit Transaction
              │
              ▼

┌─────────────────────────────────────────────────────────────────────┐
│                   FRONTEND: PAYMENT VERIFICATION                     │
└─────────────────────────────────────────────────────────────────────┘

    🌐 PaymentCallback.vue
       │
       ├─► Get order_id from URL
       │
       ├─► Call API: GET /api/v1/storefront/orders/{id}/payment-status
       │
       └─► Check Response
              │
              ├─► IF payment_status === "paid" OR order_status === "completed"
              │   │
              │   └─► Show Success Message
              │       ├─ ✅ "Payment Successful!"
              │       ├─ 🎉 "ክፍያዎ በተሳካ ሁኔታ ተጠናቅቋል!"
              │       ├─ Order Number: ORD-20260310-ABC123
              │       ├─ Transaction ID: TX-20260310-XYZ789
              │       └─ Buttons: [View Orders] [Continue Shopping]
              │
              └─► ELSE
                  └─► Show Pending/Failed Message
                     │
                     ▼

┌─────────────────────────────────────────────────────────────────────┐
│                    FRONTEND: MY ORDERS PAGE                          │
└─────────────────────────────────────────────────────────────────────┘

    📋 MyOrders.vue
       │
       ├─► Poll API every 10 seconds
       │   └─ GET /api/v1/storefront/orders
       │
       ├─► Detect Status Change
       │   └─ IF order.status changed from "pending" to "completed"
       │      │
       │      └─► Show Notification
       │          ├─ 🎉 "Order Status Updated!"
       │          ├─ "Order #ORD-20260310-ABC123 has been completed!"
       │          └─ Invoice: INV-20260310-0001
       │
       └─► Display Order
           ├─ Badge: ✅ Completed (green)
           ├─ Order Number: ORD-20260310-ABC123
           ├─ Invoice: INV-20260310-0001
           ├─ Total: ETB 1,500.00
           └─ Items: [Product 1, Product 2, ...]
              │
              ▼

┌─────────────────────────────────────────────────────────────────────┐
│                          FINAL STATE                                 │
└─────────────────────────────────────────────────────────────────────┘

    📊 Database State:

    orders table:
    ├─ id: 1
    ├─ order_number: ORD-20260310-ABC123
    ├─ status: "completed" ✅
    ├─ payment_status: "paid" ✅
    └─ sale_id: 123

    payments table:
    ├─ id: 1
    ├─ order_id: 1
    ├─ transaction_id: TX-20260310-XYZ789
    ├─ status: "completed" ✅
    ├─ payment_method: "telebirr"
    └─ verified_at: 2026-03-10 10:30:00

    sales table:
    ├─ id: 123
    ├─ invoice_number: INV-20260310-0001
    ├─ status: "completed" ✅
    ├─ payment_status: "paid" ✅
    ├─ payment_method: "telebirr"
    └─ total: 1500.00

    👤 Customer sees:
    ├─ ✅ Order Completed
    ├─ 📄 Invoice: INV-20260310-0001
    └─ 🎉 Success notification
```

## Timeline

```
Time    Event
─────────────────────────────────────────────────────────────────
00:00   Customer clicks "Pay Now"
00:01   Order created (status: pending)
00:02   Redirected to Chapa
00:05   Customer completes payment
00:06   Chapa sends webhook → Backend
00:07   Backend verifies signature ✅
00:08   Backend updates order (status: completed) ✅
00:09   Backend creates sale record ✅
00:10   Customer redirected to success page
00:11   Frontend checks payment status ✅
00:12   Customer sees "Payment Successful!" 🎉
00:15   "My Orders" page polls and updates ✅
```

## Key Points

### ✅ Automatic (No Manual Steps)
- Order creation
- Payment initialization
- Webhook processing
- Order completion
- Sale record creation
- Status updates

### 🔐 Security
- HMAC-SHA256 signature verification
- Webhook secret validation
- Idempotent processing
- Transaction validation

### 📊 Status Tracking
- Order status: pending → completed
- Payment status: pending → paid
- Sale status: completed
- Payment method: recorded

### 🎯 Customer Experience
- Clear status indicators
- Real-time notifications
- Invoice numbers
- Order history

---

**Result**: Professional, automated payment flow with zero manual intervention! 🎉
