# Database Setup Guide - Smart SuperMarket

## Overview
This guide will help you set up the database for the Smart SuperMarket application with all necessary tables, migrations, and sample data.

## Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher / MariaDB 10.3 or higher
- Composer installed
- MySQL server running

## Quick Setup (Recommended)

### For Windows:
```bash
cd backend
setup-database.bat
```

### For Linux/Mac:
```bash
cd backend
chmod +x setup-database.sh
./setup-database.sh
```

## Manual Setup

### Step 1: Configure Database Connection

1. Copy `.env.example` to `.env` if you haven't already:
```bash
cp .env.example .env
```

2. Update database credentials in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_supermarket
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Step 2: Create Database

Create the database in MySQL:
```sql
CREATE DATABASE smart_supermarket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or use command line:
```bash
mysql -u root -p -e "CREATE DATABASE smart_supermarket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 3: Clear Configuration Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Run Migrations
```bash
php artisan migrate:fresh
```

This will create all necessary tables:
- users
- password_reset_tokens
- sessions
- personal_access_tokens
- categories
- products
- sales & sale_items
- customers
- suppliers
- orders & order_items
- carts & cart_items
- payments
- stock_alerts
- audit_logs
- daily_summaries
- cache & jobs tables

### Step 5: Seed Database
```bash
php artisan db:seed
```

This will populate the database with:
- 6 Users (admin, manager, 2 cashiers, storekeeper, customer)
- 6 Product categories
- 32 Sample products
- 7 Customers
- 6 Suppliers

## Default User Accounts

After seeding, you can login with these accounts:

| Role | Email | Password | Description |
|------|-------|----------|-------------|
| Admin | admin@example.com | password | Full system access |
| Manager | manager@example.com | password | Store management |
| Cashier | cashier1@example.com | password | POS operations |
| Cashier | cashier2@example.com | password | POS operations |
| Storekeeper | storekeeper@example.com | password | Inventory management |
| Customer | customer@example.com | password | Online shopping |

**⚠️ IMPORTANT:** Change these passwords in production!

## Database Features

### Email Verification
- All users must verify their email before login
- Custom email templates with branding
- Verification links expire in 60 minutes
- Resend verification available (throttled)

### Password Reset
- Secure password reset with token-based system
- Reset tokens expire in 24 hours
- Tokens are hashed in database
- Rate limited to prevent abuse

### Payment Gateway (Chapa)
- Ethiopian payment gateway integration
- Supports: Telebirr, CBE Birr, M-Pesa, Amole
- Webhook verification with HMAC-SHA256
- Automatic order completion on payment success

### Security Features
- Email verification required for login
- Password complexity requirements
- Token expiration (24 hours for auth tokens)
- Rate limiting on sensitive endpoints
- Audit logging for all critical actions
- Input sanitization middleware

## Troubleshooting

### Error: "Table already exists"
If you get this error, drop all tables and start fresh:
```bash
php artisan migrate:fresh
```

### Error: "Access denied for user"
Check your database credentials in `.env` file and ensure MySQL is running.

### Error: "SQLSTATE[HY000] [2002] Connection refused"
Make sure MySQL server is running:
```bash
# Windows
net start mysql

# Linux/Mac
sudo service mysql start
# or
sudo systemctl start mysql
```

### Error: "Unknown database"
Create the database first:
```bash
mysql -u root -p -e "CREATE DATABASE smart_supermarket;"
```

## Verify Installation

After setup, verify everything is working:

```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Count users
>>> App\Models\User::count();
# Should return: 6

# Count products
>>> App\Models\Product::count();
# Should return: 32

# Check email verification
>>> App\Models\User::whereNotNull('email_verified_at')->count();
# Should return: 6
```

## Additional Commands

### Reset Database (WARNING: Deletes all data)
```bash
php artisan migrate:fresh --seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=DatabaseSeeder
```

### Check Migration Status
```bash
php artisan migrate:status
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

## Production Deployment

For production:

1. **Never use `migrate:fresh`** - Use `migrate` instead
2. **Change all default passwords**
3. **Configure proper email settings** in `.env`
4. **Set up Chapa payment credentials**
5. **Enable SSL/TLS for database connections**
6. **Set `APP_ENV=production`**
7. **Set `APP_DEBUG=false`**
8. **Use strong `APP_KEY`** (generate with `php artisan key:generate`)

## Support

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode: `APP_DEBUG=true` in `.env`
3. Clear all caches: `php artisan optimize:clear`

---

**Last Updated:** March 9, 2026
**Laravel Version:** 11.x
**Database:** MySQL 5.7+
