# Role & Permissions Matrix

## System Roles Overview

The system implements 6 distinct user roles with specific permissions and access levels:

### 1. Admin (`admin`)
**Full system administrator with unrestricted access**
- Complete system control and configuration
- User management and role assignment
- All business operations
- System backups and maintenance
- Financial reports and analytics

### 2. Manager (`manager`)
**Store/business manager with operational control**
- Product and inventory management
- Supplier management
- Order processing and fulfillment
- Staff performance monitoring
- Business reports and analytics
- POS system access

### 3. Cashier (`cashier`)
**Point-of-sale operator**
- POS transactions and payment processing
- Product scanning and sales
- Basic inventory viewing
- Customer interaction
- Receipt generation

### 4. Customer (`customer`)
**End-user/buyer**
- Product browsing and searching
- Online order placement
- Order tracking and history
- Account management
- Shopping cart functionality

### 5. Delivery Staff (`delivery_staff`)
**Delivery and logistics personnel**
- Delivery assignment viewing
- Order delivery status updates
- Route optimization
- Customer delivery confirmation
- Delivery performance tracking

### 6. Supplier (`supplier`)
**External supplier/vendor**
- Purchase order viewing
- Delivery status updates
- Stock confirmation
- Supplier dashboard access
- Communication with management

## Detailed Permissions Matrix

| Permission | Admin | Manager | Cashier | Customer | Delivery | Supplier |
|------------|-------|---------|---------|----------|----------|----------|
| **System Management** |
| Manage Users | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| System Backup | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| System Configuration | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| **Inventory Management** |
| Manage Products | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View Products | ✓ | ✓ | ✓ | ✓ | ✗ | ✗ |
| Manage Categories | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Stock Alerts | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| **Sales & POS** |
| Access POS | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| Process Sales | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| View Sales History | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| **Customer Management** |
| Manage Customers | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View Customer Data | ✓ | ✓ | ✗ | Own Only | ✗ | ✗ |
| **Order Management** |
| Manage Orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View All Orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View Own Orders | ✓ | ✓ | ✗ | ✓ | ✗ | ✗ |
| Update Order Status | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| **Delivery Management** |
| Manage Deliveries | ✓ | ✓ | ✗ | ✗ | ✓ | ✗ |
| View Delivery Assignments | ✓ | ✓ | ✗ | ✗ | ✓ | ✗ |
| Update Delivery Status | ✓ | ✓ | ✗ | ✗ | ✓ | ✗ |
| **Supplier Management** |
| Manage Suppliers | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View Purchase Orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✓ |
| Create Purchase Orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Update PO Status | ✓ | ✓ | ✗ | ✗ | ✗ | ✓ |
| Confirm Stock Receipt | ✓ | ✓ | ✗ | ✗ | ✗ | ✓ |
| **Reports & Analytics** |
| View Reports | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Export Reports | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| View Analytics | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Financial Reports | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| **Dashboard Access** |
| Admin Dashboard | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ |
| Manager Dashboard | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Cashier Dashboard | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| Customer Dashboard | ✗ | ✗ | ✗ | ✓ | ✗ | ✗ |
| Delivery Dashboard | ✗ | ✗ | ✗ | ✗ | ✓ | ✗ |
| Supplier Dashboard | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |

## API Endpoint Access Control

### Authentication Required
All API endpoints require authentication via Sanctum tokens except:
- Public auth endpoints (login, register, password reset)
- Public product browsing (storefront)
- Payment webhooks

### Role-Based Route Groups

#### Admin Only Routes
```
POST   /api/v1/backup/*
GET    /api/v1/backup/*
DELETE /api/v1/backup/*
POST   /api/v1/users
PUT    /api/v1/users/{id}
DELETE /api/v1/users/{id}
```

#### Admin + Manager Routes
```
POST   /api/v1/products
PUT    /api/v1/products/{id}
DELETE /api/v1/products/{id}
POST   /api/v1/categories
PUT    /api/v1/categories/{id}
DELETE /api/v1/categories/{id}
GET    /api/v1/suppliers
POST   /api/v1/suppliers
PUT    /api/v1/suppliers/{id}
DELETE /api/v1/suppliers/{id}
GET    /api/v1/reports/*
GET    /api/v1/analytics/*
GET    /api/v1/advanced/*
```

#### Admin + Manager + Cashier Routes
```
GET    /api/v1/dashboard
POST   /api/v1/sales
GET    /api/v1/sales
PUT    /api/v1/sales/{id}
```

#### Customer Only Routes
```
GET    /api/v1/customer/orders
GET    /api/v1/customer/orders/{id}
POST   /api/v1/storefront/cart
PUT    /api/v1/storefront/cart
POST   /api/v1/storefront/checkout
```

#### Delivery Staff Routes
```
GET    /api/v1/delivery/assignments
PATCH  /api/v1/delivery/orders/{id}/status
```

#### Supplier Only Routes
```
GET    /api/v1/supplier/dashboard
GET    /api/v1/purchase-orders (own only)
PATCH  /api/v1/purchase-orders/{id}/delivery-status
PATCH  /api/v1/purchase-orders/{id}/confirm-stock
```

## Implementation Details

### Middleware Usage

#### Role Middleware
```php
Route::middleware(['role:admin,manager'])->group(function () {
    // Routes accessible by admin OR manager
});
```

#### Permission Middleware
```php
Route::middleware(['permission:manage_inventory'])->group(function () {
    // Routes requiring inventory management permission
});
```

### User Model Methods

```php
// Role checking methods
$user->isAdmin()
$user->isManager()
$user->isCashier()
$user->isCustomer()
$user->isDeliveryStaff()
$user->isSupplier()

// Permission checking methods
$user->canManageInventory()
$user->canViewReports()
$user->canAccessPOS()
$user->canManageSuppliers()
$user->canManageOrders()
$user->canManageDeliveries()
$user->canViewPurchaseOrders()
$user->canManageUsers()
$user->canAccessCustomerData()
```

## Security Considerations

### Data Isolation
- **Customers**: Can only access their own orders and data
- **Suppliers**: Can only access their own purchase orders
- **Delivery Staff**: Can only access assigned deliveries
- **Cashiers**: Cannot access financial reports or user management
- **Managers**: Cannot access system administration functions
- **Admins**: Full access to all system functions

### API Security
- All routes protected by Sanctum authentication
- Role-based middleware prevents unauthorized access
- Permission-based middleware provides granular control
- Input validation on all endpoints
- Rate limiting on sensitive endpoints

### Audit Trail
- User actions are logged for accountability
- Role changes are tracked
- Critical operations require admin approval
- Failed authentication attempts are monitored

## Role Assignment Guidelines

### Admin Role
- Assign to business owners only
- Limit to 1-2 users maximum
- Require strong authentication (2FA recommended)
- Regular access review

### Manager Role
- Assign to trusted supervisory staff
- Department heads and store managers
- Requires business justification
- Regular performance review

### Cashier Role
- Front-line staff handling transactions
- Limited to operational needs only
- Regular training on POS procedures
- Monitor for unusual transaction patterns

### Customer Role
- Default role for customer registrations
- Self-service account management
- Automatic assignment via registration
- Email verification required

### Delivery Staff Role
- Assign to logistics personnel only
- GPS tracking integration recommended
- Performance metrics monitoring
- Regular route optimization

### Supplier Role
- External vendor accounts only
- Limited to purchase order functions
- Contract-based access periods
- Regular supplier performance review

## Migration and Maintenance

### Role Updates
- Use database migrations for role changes
- Maintain backward compatibility
- Test thoroughly before deployment
- Document all role modifications

### Permission Changes
- Update middleware configurations
- Test all affected endpoints
- Update API documentation
- Notify affected users

### Regular Audits
- Monthly role assignment review
- Quarterly permission audit
- Annual security assessment
- User access certification