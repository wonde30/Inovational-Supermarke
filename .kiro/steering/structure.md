# Project Structure

## Repository Layout

```
├── backend/          # Laravel API backend
├── frontend/         # Vue.js SPA frontend
└── .kiro/           # Kiro configuration and steering rules
```

## Backend Structure (`backend/`)

### Application Layer (`app/`)

```
app/
├── Console/Commands/        # Artisan commands (QR generation, stock alerts, order completion)
├── Exceptions/             # Custom exceptions (InsufficientStockException, PaymentException)
├── Http/
│   ├── Controllers/Api/    # API controllers organized by resource
│   │   └── Storefront/    # Public storefront controllers (cart, checkout, products)
│   ├── Middleware/        # Custom middleware (role/permission checks, token expiration, logging)
│   └── Requests/          # Form request validation classes
├── Models/                # Eloquent models with relationships and business logic
├── Notifications/         # Email/SMS notifications (order status, stock alerts, payments)
│   └── Channels/         # Custom notification channels (SMS)
├── Providers/            # Service providers
├── Services/             # Business logic services (payment gateways, cart, analytics, QR codes)
│   └── PaymentGateway/   # Payment gateway implementations (Stripe, PayPal, Chapa)
└── Traits/               # Reusable traits (ApiResponse for standardized responses)
```

### Key Directories

- **`routes/api.php`**: All API routes with middleware groups and versioning (`/api/v1`)
- **`database/migrations/`**: Database schema migrations (chronologically ordered)
- **`database/seeders/`**: Database seeders for initial data
- **`config/`**: Configuration files for services and packages

## Frontend Structure (`frontend/src/`)

```
src/
├── assets/              # Static assets and global styles
│   ├── main.css        # Global styles
│   ├── theme.css       # Theme variables (light/dark mode)
│   └── design-system.css # Design system utilities
├── components/          # Reusable Vue components
│   └── analytics/      # Analytics-specific components
├── composables/         # Vue composition functions (useTranslation, useRoleAccess)
├── locales/            # i18n translation files (en.json, am.json, or.json)
├── plugins/            # Vue plugins (i18n)
├── router/             # Vue Router configuration with route guards
├── services/           # API service layer (axios instances, API methods)
├── stores/             # Pinia stores (auth, cart, i18n, theme, toast)
├── utils/              # Utility functions (role guards, translations)
├── views/              # Page components
│   ├── admin/         # Admin dashboard views
│   ├── auth/          # Authentication views (login, register, reset password)
│   ├── layouts/       # Layout components (admin, storefront)
│   └── storefront/    # Public storefront views
├── tests/             # Frontend test files and verification reports
├── App.vue            # Root component
└── main.js            # Application entry point
```

## Architecture Patterns

### Backend Conventions

1. **API Response Format**: All controllers use `ApiResponse` trait for consistent responses:
   ```php
   {
     "success": true|false,
     "message": "...",
     "data": {...}
   }
   ```

2. **Model Conventions**:
   - Use `$fillable` for mass assignment protection
   - Define relationships with type hints (`BelongsTo`, `HasMany`)
   - Use `$casts` for type casting
   - Use `$appends` for computed attributes
   - Business logic methods in models (e.g., `deductStock()`, `checkAndCreateAlerts()`)

3. **Route Organization**:
   - Versioned API routes (`/api/v1`)
   - Grouped by middleware (auth, role, permission)
   - Public routes separate from protected routes
   - Storefront routes under `/api/v1/storefront`

4. **Middleware Stack**:
   - `auth:sanctum` - Authentication
   - `check.token.expiration` - Token expiration validation
   - `role:admin,manager` - Role-based access
   - `permission:manage_inventory` - Permission-based access
   - `throttle:5,1` - Rate limiting

### Frontend Conventions

1. **State Management**:
   - Pinia stores for global state (auth, cart, theme, i18n)
   - Local state in components for UI-specific data
   - Persist auth state to localStorage

2. **API Communication**:
   - Centralized API service layer in `services/api.js`
   - Axios interceptors for auth token injection
   - Error handling in service layer

3. **Routing**:
   - Route guards for authentication and role-based access
   - Lazy-loaded route components
   - Named routes for navigation

4. **Styling**:
   - Tailwind utility classes
   - Custom design system with brand colors (fresh, smart, promo)
   - Dark mode support via `class` strategy
   - Scoped styles in components when needed

5. **Internationalization**:
   - Composable `useTranslation()` for component-level translations
   - Store-based i18n with JSON locale files
   - User-specific language preferences synced with backend

## File Naming Conventions

- **Backend**: PascalCase for classes (`ProductController.php`, `Product.php`)
- **Frontend**: 
  - PascalCase for components (`LoadingSpinner.vue`)
  - camelCase for composables, services, stores (`useTranslation.js`, `api.js`)
  - kebab-case for views in URLs

## Configuration Files

- **Backend**: `.env` (from `.env.example`)
- **Frontend**: Environment variables via Vite (`import.meta.env`)
- **Tailwind**: `tailwind.config.js` with custom theme
- **Vite**: `vite.config.js` with alias (`@` → `src/`) and proxy
