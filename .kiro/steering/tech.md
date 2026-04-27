# Technology Stack

## Backend

**Framework**: Laravel 11 (PHP 8.2+)

**Key Dependencies**:
- `laravel/sanctum` - API authentication with token management
- `laravel/socialite` - OAuth social authentication (Google)
- `stripe/stripe-php` - Stripe payment integration
- `laravel/tinker` - Interactive REPL for debugging

**Development Tools**:
- `laravel/pint` - PHP code style fixer
- `phpunit/phpunit` - Testing framework
- `laravel/sail` - Docker development environment

**Database**: MySQL (configured via Docker)

## Frontend

**Framework**: Vue 3 with Composition API

**Build Tool**: Vite 5

**State Management**: Pinia

**Routing**: Vue Router 4

**Styling**: Tailwind CSS 3 with custom design system

**Key Dependencies**:
- `axios` - HTTP client for API communication
- `chart.js` - Data visualization
- `html5-qrcode` - QR code scanning functionality

## Common Commands

### Backend

```bash
# Install dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database operations
php artisan migrate
php artisan db:seed

# Run development server
php artisan serve

# Code style
./vendor/bin/pint

# Run tests
php artisan test
# or
./vendor/bin/phpunit

# Generate QR codes for products
php artisan qr:generate

# Generate stock alerts
php artisan stock:generate-alerts

# Complete orders (scheduled task)
php artisan orders:complete

# Database backup
php artisan backup:create
# or use PowerShell script
.\backup-database.ps1
```

### Frontend

```bash
# Install dependencies
npm install

# Development server (with host binding)
npm run dev

# Production build
npm run build

# Preview production build
npm run preview
```

## API Configuration

- **Base URL**: `http://localhost:8000/api/v1`
- **Authentication**: Bearer token via Laravel Sanctum
- **Token Expiration**: Configurable via `SANCTUM_TOKEN_EXPIRATION` (default: 1440 minutes)
- **Rate Limiting**: Configurable per endpoint (e.g., login: 5/min, register: 3/min)

## Development Proxy

Frontend dev server proxies `/api` requests to `http://127.0.0.1:8000` (configured in `vite.config.js`)

## Environment Variables

Key backend variables (see `.env.example`):
- Database credentials
- Payment gateway keys (Stripe, PayPal, Chapa)
- Mail configuration
- SMS provider settings
- CORS origins
- Sanctum token settings
