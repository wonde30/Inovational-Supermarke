# Quick Reference - Smart SuperMarket

## 🚀 Start Server
```bash
cd backend
php artisan serve
```
Server runs at: http://localhost:8000

---

## 🔑 Default Login Credentials

```
Admin:    admin@example.com / password
Manager:  manager@example.com / password
Cashier:  cashier1@example.com / password
Customer: customer@example.com / password
```

---

## 📧 Email Verification Endpoints

```bash
# Register (sends verification email)
POST /api/v1/auth/register

# Verify email
GET /api/v1/auth/verify-email/{id}/{hash}

# Resend verification
POST /api/v1/auth/resend-verification
```

---

## 🔐 Password Reset Endpoints

```bash
# Request reset link
POST /api/v1/auth/forgot-password
Body: { "email": "user@example.com" }

# Verify token
POST /api/v1/auth/verify-reset-token
Body: { "email": "...", "token": "..." }

# Reset password
POST /api/v1/auth/reset-password
Body: { 
  "email": "...", 
  "token": "...",
  "password": "NewPass@123",
  "password_confirmation": "NewPass@123"
}
```

---

## 💳 Chapa Payment Endpoints

```bash
# Initialize payment
POST /api/v1/payments/initialize
Body: { "order_id": 1 }

# Webhook (called by Chapa)
POST /api/v1/payments/webhook/chapa

# Verify payment
GET /api/v1/payments/{id}/verify
```

---

## 🛠️ Useful Commands

```bash
# Reset database
php artisan migrate:fresh --seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Verify setup
php verify-setup.php

# View routes
php artisan route:list

# Run tests
php artisan test

# Generate key
php artisan key:generate
```

---

## 📁 Important Files

### Email Verification
- `app/Notifications/CustomVerifyEmail.php`
- `app/Http/Controllers/Api/AuthController.php` (lines 116-165)

### Password Reset
- `app/Http/Controllers/Api/AuthController.php` (lines 178-320)
- `database/migrations/0001_01_01_000000_create_users_table.php`

### Chapa Gateway
- `app/Services/PaymentGateway/ChappaGateway.php`
- `app/Services/ChapaPaymentService.php`

---

## ⚙️ Configuration (.env)

```env
# Database
DB_CONNECTION=mysql
DB_DATABASE=smart_supermarket
DB_USERNAME=root
DB_PASSWORD=

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

# Chapa Payment
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=your_key
CHAPPA_WEBHOOK_SECRET=your_secret

# Frontend
FRONTEND_URL=http://localhost:3001
```

---

## 🔍 Troubleshooting

### Database Error
```bash
php artisan migrate:fresh --seed
```

### Cache Issues
```bash
php artisan optimize:clear
```

### Email Not Sending
- Check MAIL_* settings in .env
- Use Gmail App Password (not regular password)
- Enable "Less secure app access" or use OAuth2

### Payment Not Working
- Configure CHAPPA_* keys in .env
- Check webhook URL is accessible
- Verify signature secret matches

---

## 📊 Database Stats

- Users: 6
- Products: 32
- Categories: 6
- Customers: 7
- Suppliers: 6

---

## 🔒 Security Notes

- All users are email verified by default in seeder
- Password must have: uppercase, lowercase, number, special char
- Auth tokens expire in 24 hours
- Reset tokens expire in 24 hours
- Verification links expire in 60 minutes
- Rate limiting enabled on sensitive endpoints

---

## 📞 Support

Check logs: `storage/logs/laravel.log`

Enable debug: `APP_DEBUG=true` in .env

---

**Last Updated:** March 9, 2026
