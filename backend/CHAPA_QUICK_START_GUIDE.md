# 🚀 Chapa Payment - Quick Start Guide

Get up and running with Chapa payments in 5 minutes!

---

## ⚡ Quick Setup (3 Steps)

### Step 1: Get Chapa API Keys (2 minutes)

1. Go to https://dashboard.chapa.co/
2. Sign up or login
3. Navigate to **Settings → API Keys**
4. Copy your **Secret Key** (starts with `CHASECK_TEST-`)

### Step 2: Configure Environment (1 minute)

Open `backend/.env` and verify these lines exist:

```env
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=CHASECK_TEST-your_actual_key_here
CHAPPA_PUBLIC_KEY=CHAPUBK_TEST-your_public_key_here
CHAPPA_WEBHOOK_SECRET=chapa_webhook_secret_2026

APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3001
```

Replace `your_actual_key_here` with your real key from Step 1.

### Step 3: Test Integration (2 minutes)

```bash
cd backend
php artisan config:clear
php test-chapa-complete.php
```

You should see:
```
✅ Configuration: PASS
✅ API Connectivity: PASS
✅ Payment Gateway: PASS
✅ Service Layer: PASS
✅ Webhook Security: PASS
```

**Done!** 🎉 Your Chapa integration is ready!

---

## 🎯 Frontend Integration (Copy & Paste)

### React/Next.js Example

```javascript
// 1. Checkout Function
const checkoutWithChapa = async (cartItems, shippingAddress, phone) => {
  try {
    const response = await fetch('http://localhost:8000/api/v1/storefront/checkout', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${userToken}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        items: cartItems, // [{ product_id: 1, quantity: 2 }, ...]
        payment_method: 'chapa',
        shipping_address: shippingAddress,
        phone: phone, // Format: +251911234567 or 0911234567
      }),
    });

    const data = await response.json();

    if (data.success && data.data.payment?.checkout_url) {
      // Save order ID for later
      localStorage.setItem('pending_order_id', data.data.order.id);
      
      // Redirect to Chapa
      window.location.href = data.data.payment.checkout_url;
    } else {
      alert(data.message || 'Checkout failed');
    }
  } catch (error) {
    console.error('Checkout error:', error);
    alert('An error occurred. Please try again.');
  }
};

// 2. Payment Callback Handler
// Create a page at /payment/callback
import { useEffect, useState } from 'react';
import { useRouter } from 'next/router';

export default function PaymentCallback() {
  const router = useRouter();
  const [status, setStatus] = useState('checking');

  useEffect(() => {
    const checkPayment = async () => {
      const orderId = localStorage.getItem('pending_order_id');
      
      if (!orderId) {
        setStatus('error');
        return;
      }

      try {
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
          setStatus('success');
          localStorage.removeItem('pending_order_id');
          
          // Redirect to order confirmation
          setTimeout(() => {
            router.push(`/orders/${orderId}`);
          }, 2000);
        } else {
          setStatus('failed');
        }
      } catch (error) {
        setStatus('error');
      }
    };

    checkPayment();
  }, []);

  return (
    <div>
      {status === 'checking' && <p>Verifying payment...</p>}
      {status === 'success' && <p>✅ Payment successful!</p>}
      {status === 'failed' && <p>❌ Payment failed. Please try again.</p>}
      {status === 'error' && <p>⚠️ An error occurred.</p>}
    </div>
  );
}

// 3. Usage in Checkout Component
<button onClick={() => checkoutWithChapa(
  cartItems,
  '123 Main St, Addis Ababa',
  '+251911234567'
)}>
  Pay with Chapa
</button>
```

### Vue.js Example

```javascript
// In your checkout component
methods: {
  async checkoutWithChapa() {
    try {
      const response = await fetch('http://localhost:8000/api/v1/storefront/checkout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${this.userToken}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          items: this.cartItems,
          payment_method: 'chapa',
          shipping_address: this.shippingAddress,
          phone: this.phone,
        }),
      });

      const data = await response.json();

      if (data.success && data.data.payment?.checkout_url) {
        localStorage.setItem('pending_order_id', data.data.order.id);
        window.location.href = data.data.payment.checkout_url;
      } else {
        this.$toast.error(data.message);
      }
    } catch (error) {
      this.$toast.error('Checkout failed');
    }
  }
}
```

---

## 📱 Phone Number Format

Chapa requires Ethiopian phone numbers in international format.

**Accepted Formats:**
```
+251911234567  ✅ (Recommended)
0911234567     ✅ (Auto-converted to +251911234567)
251911234567   ✅ (Auto-converted to +251911234567)
```

**Not Accepted:**
```
911234567      ❌ (Missing country code)
+251 91 123 4567  ❌ (Spaces not allowed)
```

The system automatically formats phone numbers, but it's best to use the `+251` format.

---

## 🧪 Testing

### Test with Postman

1. Import `CHAPA_POSTMAN_COLLECTION_V2.json`
2. Run "Login" to get token
3. Run "Complete Checkout with Chapa"
4. Copy `checkout_url` from response
5. Open URL in browser
6. Complete test payment

### Test with cURL

```bash
# 1. Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Save the token from response

# 2. Checkout
curl -X POST http://localhost:8000/api/v1/storefront/checkout \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [{"product_id": 1, "quantity": 2}],
    "payment_method": "chapa",
    "shipping_address": "123 Main St",
    "phone": "+251911234567"
  }'

# 3. Open the checkout_url from response in browser
```

---

## 🔧 Webhook Setup (For Production)

### Local Development (Use ngrok)

```bash
# 1. Install ngrok
# Download from https://ngrok.com/

# 2. Start ngrok
ngrok http 8000

# 3. Copy the HTTPS URL (e.g., https://abc123.ngrok.io)

# 4. Configure in Chapa dashboard:
# Webhook URL: https://abc123.ngrok.io/api/v1/payments/webhook/chapa
```

### Production

1. Deploy your app with HTTPS
2. Configure webhook in Chapa dashboard:
   ```
   https://yourdomain.com/api/v1/payments/webhook/chapa
   ```
3. Copy webhook secret from Chapa
4. Add to `.env`:
   ```env
   CHAPPA_WEBHOOK_SECRET=your_webhook_secret
   ```

---

## 🎨 UI Components (Optional)

### Payment Button Component

```jsx
// PaymentButton.jsx
import { useState } from 'react';

export default function PaymentButton({ cartItems, shippingAddress, phone }) {
  const [loading, setLoading] = useState(false);

  const handlePayment = async () => {
    setLoading(true);
    
    try {
      const response = await fetch('http://localhost:8000/api/v1/storefront/checkout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
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
        localStorage.setItem('pending_order_id', data.data.order.id);
        window.location.href = data.data.payment.checkout_url;
      } else {
        alert(data.message);
        setLoading(false);
      }
    } catch (error) {
      alert('Payment failed. Please try again.');
      setLoading(false);
    }
  };

  return (
    <button 
      onClick={handlePayment}
      disabled={loading}
      className="bg-green-600 text-white px-6 py-3 rounded-lg"
    >
      {loading ? 'Processing...' : 'Pay with Chapa'}
    </button>
  );
}
```

---

## ❓ Common Issues

### "Payment initialization failed"

**Check:**
1. API key is correct in `.env`
2. Config cache cleared: `php artisan config:clear`
3. Phone number format is correct
4. Products have sufficient stock

### "Checkout URL not returned"

**Check:**
1. Laravel logs: `tail -f backend/storage/logs/laravel.log`
2. Chapa API status
3. Internet connection

### "Webhook not working"

**For local development:**
- Use ngrok to expose localhost
- Configure webhook URL in Chapa dashboard

**For production:**
- Ensure HTTPS is enabled
- Webhook URL is publicly accessible
- Webhook secret is correct

---

## 📚 Documentation

- **Setup Guide:** `CHAPA_SETUP_COMPLETE.md`
- **API Reference:** `CHAPA_API_REFERENCE.md`
- **Integration Guide:** `CHAPA_INTEGRATION_GUIDE.md`
- **Troubleshooting:** `CHAPA_TROUBLESHOOTING.md`
- **Implementation Details:** `CHAPA_IMPLEMENTATION_COMPLETE.md`

---

## 🆘 Need Help?

1. **Check logs:** `backend/storage/logs/laravel.log`
2. **Run test:** `php test-chapa-complete.php`
3. **Read troubleshooting guide:** `CHAPA_TROUBLESHOOTING.md`
4. **Contact Chapa support:** support@chapa.co

---

## ✅ Checklist

Before going live:

- [ ] API keys configured in `.env`
- [ ] Test script passes all checks
- [ ] Frontend integration complete
- [ ] Payment callback page created
- [ ] Webhook URL configured (production only)
- [ ] Tested with real payment methods
- [ ] Error handling implemented
- [ ] Customer support trained

---

**That's it!** You're ready to accept payments with Chapa! 🎉

For detailed information, check the other documentation files.

**Quick Links:**
- Chapa Dashboard: https://dashboard.chapa.co/
- Chapa Docs: https://developer.chapa.co/docs
- Test Script: `php test-chapa-complete.php`
- Postman Collection: `CHAPA_POSTMAN_COLLECTION_V2.json`

---

**Last Updated:** March 10, 2026
**Version:** 1.0.0
