# Supplier Functionality Enhancement Guide

## Overview

This document outlines the enhanced supplier functionality implemented in the Laravel backend system, including role-based permissions, purchase order management, and supplier portal features.

## User Roles

The system supports six distinct user roles:

1. **Admin** - Full system control and configuration
2. **Manager** - Product/inventory management, reports, orders (includes former storekeeper responsibilities)
3. **Cashier** - POS transactions, scanning, payments
4. **Customer** - Browse products, place orders, track orders
5. **Delivery Staff** - Delivery assignments and status updates
6. **Supplier** - View purchase orders, update delivery status, confirm stock

**Note:** The legacy `storekeeper` role has been migrated to `manager` role for better role consolidation.

## Role-Based Permissions

### Middleware Implementation

Two new middleware classes have been implemented:

- `CheckRole` - Validates user roles
- `CheckPermission` - Validates specific permissions

### Permission Matrix

| Permission | Admin | Manager | Cashier | Customer | Delivery | Supplier |
|------------|-------|---------|---------|----------|----------|----------|
| manage_inventory | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| view_reports | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| access_pos | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ |
| manage_suppliers | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| manage_orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| manage_deliveries | ✓ | ✓ | ✗ | ✗ | ✓ | ✗ |
| view_purchase_orders | ✓ | ✓ | ✗ | ✗ | ✗ | ✓ |

## Enhanced Supplier Model

### New Fields

- `user_id` - Links supplier to user account
- `is_active` - Supplier status
- `tax_number` - Tax identification
- `payment_terms` - Payment conditions
- `notes` - Additional information

### Relationships

- `user()` - Associated user account
- `purchaseOrders()` - Purchase orders for this supplier
- `products()` - Products supplied by this supplier

## Purchase Order System

### Models

#### PurchaseOrder
- Manages purchase orders with suppliers
- Tracks status from pending to delivered
- Handles delivery dates and amounts

#### PurchaseOrderItem
- Individual items within purchase orders
- Tracks quantities ordered vs received
- Manages pricing and notes

### Purchase Order Statuses

1. **Pending** - Initial state, awaiting supplier confirmation
2. **Confirmed** - Supplier has confirmed the order
3. **Shipped** - Order has been shipped by supplier
4. **Delivered** - Order has been received and stock updated
5. **Cancelled** - Order has been cancelled

## API Endpoints

### Supplier Management (Admin/Manager)

```
GET    /api/v1/suppliers                    # List suppliers
POST   /api/v1/suppliers                    # Create supplier
GET    /api/v1/suppliers/{id}               # View supplier
PUT    /api/v1/suppliers/{id}               # Update supplier
DELETE /api/v1/suppliers/{id}               # Delete supplier
POST   /api/v1/suppliers/{id}/create-user-account  # Create user account
```

### Supplier Portal (Supplier Role)

```
GET    /api/v1/supplier/dashboard           # Supplier dashboard
```

### Purchase Orders (Admin/Manager)

```
GET    /api/v1/purchase-orders              # List purchase orders
POST   /api/v1/purchase-orders              # Create purchase order
GET    /api/v1/purchase-orders/{id}         # View purchase order
PUT    /api/v1/purchase-orders/{id}         # Update purchase order
DELETE /api/v1/purchase-orders/{id}         # Delete purchase order
```

### Purchase Orders (Supplier Role)

```
GET    /api/v1/purchase-orders              # List own purchase orders
GET    /api/v1/purchase-orders/{id}         # View own purchase order
PUT    /api/v1/purchase-orders/{id}         # Update own purchase order
PATCH  /api/v1/purchase-orders/{id}/delivery-status  # Update delivery status
PATCH  /api/v1/purchase-orders/{id}/confirm-stock    # Confirm stock receipt
```

## Supplier Workflow

### 1. Supplier Registration
1. Admin/Manager creates supplier record
2. Optionally creates user account for supplier login
3. Supplier receives login credentials

### 2. Purchase Order Process
1. Admin/Manager creates purchase order for supplier
2. Supplier receives notification (if implemented)
3. Supplier logs in and views pending orders
4. Supplier confirms order (status: confirmed)
5. Supplier updates shipping status (status: shipped)
6. Supplier confirms delivery and stock quantities (status: delivered)
7. System automatically updates product stock levels

### 3. Stock Management
- Suppliers can confirm received quantities
- System updates product stock automatically
- Partial deliveries are supported
- Stock alerts are resolved when items are received

## Database Migrations

The following migrations have been created:

1. `enhance_suppliers_table` - Adds new supplier fields
2. `create_purchase_orders_table` - Purchase order management
3. `create_purchase_order_items_table` - Purchase order line items
4. `add_supplier_id_to_products_table` - Links products to suppliers

## Security Features

### Role-Based Access Control
- Middleware enforces role restrictions
- Suppliers can only access their own data
- Admin/Manager have full access

### Data Validation
- Comprehensive input validation
- Business rule enforcement
- Stock quantity validation

### Audit Trail
- Purchase order status changes are tracked
- User actions are logged
- Stock movements are recorded

## Usage Examples

### Creating a Supplier with User Account

```php
POST /api/v1/suppliers
{
    "name": "ABC Supplies Ltd",
    "email": "contact@abcsupplies.com",
    "phone": "+1234567890",
    "address": "123 Supply Street",
    "contact_person": "John Doe",
    "tax_number": "TAX123456",
    "payment_terms": "Net 30 days",
    "create_user_account": true,
    "user_password": "securepassword123"
}
```

### Creating a Purchase Order

```php
POST /api/v1/purchase-orders
{
    "supplier_id": 1,
    "expected_delivery_date": "2026-03-20",
    "notes": "Urgent order for spring inventory",
    "items": [
        {
            "product_id": 1,
            "quantity_ordered": 100,
            "unit_price": 25.50
        },
        {
            "product_id": 2,
            "quantity_ordered": 50,
            "unit_price": 15.75
        }
    ]
}
```

### Supplier Confirming Stock Receipt

```php
PATCH /api/v1/purchase-orders/1/confirm-stock
{
    "items": [
        {
            "id": 1,
            "quantity_received": 95,
            "notes": "5 items damaged in transit"
        },
        {
            "id": 2,
            "quantity_received": 50
        }
    ]
}
```

## Next Steps

1. **Notifications** - Implement email/SMS notifications for purchase order updates
2. **Reporting** - Add supplier performance reports
3. **Integration** - Connect with external supplier systems
4. **Mobile App** - Create mobile interface for suppliers
5. **Advanced Features** - Add supplier ratings, contract management, and automated reordering

## Testing

Run the following commands to test the implementation:

```bash
# Run migrations (including storekeeper to manager migration)
php artisan migrate

# Check for any remaining storekeeper users (dry run)
php artisan users:migrate-storekeeper --dry-run

# Migrate storekeeper users to manager (if any exist)
php artisan users:migrate-storekeeper

# Test API endpoints
php artisan test --filter SupplierTest
php artisan test --filter PurchaseOrderTest

# Check middleware functionality
php artisan test --filter RoleMiddlewareTest
```

## Migration from Legacy Roles

### Storekeeper to Manager Migration

The legacy `storekeeper` role has been consolidated into the `manager` role for better role management:

```bash
# Check if you have storekeeper users
php artisan users:migrate-storekeeper --dry-run

# Migrate storekeeper users to manager role
php artisan users:migrate-storekeeper

# Force migration without confirmation
php artisan users:migrate-storekeeper --force
```

**Migration Details:**
- All users with `storekeeper` role are automatically updated to `manager` role
- Manager role includes all storekeeper permissions (inventory management)
- No functionality is lost in the migration
- The migration is reversible if needed

## Troubleshooting

### Common Issues

1. **Permission Denied** - Check user role and middleware configuration
2. **Supplier Not Found** - Ensure supplier has associated user account
3. **Stock Not Updated** - Verify purchase order status is 'delivered'
4. **Validation Errors** - Check required fields and data types

### Debug Commands

```bash
# Check user roles
php artisan tinker
>>> User::with('supplier')->where('role', 'supplier')->get()

# Verify purchase order status
>>> PurchaseOrder::with('items.product')->find(1)

# Check middleware registration
>>> Route::getMiddleware()
```