# IBMS - Inventory and Billing Management System

A comprehensive smart supermarket management platform with integrated e-commerce storefront capabilities.

## Features

- **Inventory Management** - Product catalog, stock tracking, automated reorder alerts, expiry monitoring
- **Point of Sale (POS)** - Real-time sales processing with multi-payment gateway support
- **Order Management** - Customer orders, delivery tracking, status workflows
- **Purchase Orders** - Supplier management and procurement lifecycle
- **E-commerce Storefront** - Public-facing shop with cart, checkout, and QR code scanning
- **Analytics & Reports** - Sales reports, profit analysis, performance metrics, audit logs
- **Multi-language Support** - English, Amharic, Oromo with user preferences
- **Role-Based Access Control** - Admin, Manager, Cashier, Customer, Delivery Staff, Supplier

## Tech Stack

### Backend
- Laravel 11 (PHP 8.2+)
- MySQL Database
- Laravel Sanctum (API Authentication)
- Payment Gateways: Stripe, PayPal, Chapa

### Frontend
- Vue 3 (Composition API)
- Vite 5
- Pinia (State Management)
- Tailwind CSS 3
- Chart.js

## Getting Started

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+

### Backend Setup

```bash
cd backend

# Install dependencies
composer install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure database in .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

### Frontend Setup

```bash
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build
```

## API Documentation

API Base URL: `http://localhost:8000/api/v1`

Authentication: Bearer token via Laravel Sanctum

See `.kiro/steering/` for detailed architecture and conventions.

## Payment Gateway Configuration

Configure payment gateways in `.env`:

```env
# Stripe
STRIPE_SECRET_KEY=your_stripe_secret
STRIPE_PUBLIC_KEY=your_stripe_public

# PayPal
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_secret

# Chapa (Ethiopian Payment Gateway)
CHAPPA_MODE=test
CHAPPA_SECRET_KEY=your_chapa_secret
CHAPPA_PUBLIC_KEY=your_chapa_public
```

## Database Backup

```bash
# Windows
.\backup-database.bat

# PowerShell
.\backup-database.ps1
```

## License

MIT License

## Support

For issues and questions, please open an issue in the repository.
