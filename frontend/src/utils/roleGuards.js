/**
 * Frontend Role Guards and Validation Utilities
 * Provides client-side role validation and access control
 */

import { ROLES, ROLE_PERMISSIONS } from './roleConfig'

/**
 * Route guard for role-based access control
 * @param {Object} to - Target route
 * @param {Object} from - Current route  
 * @param {Function} next - Navigation callback
 * @param {Object} auth - Auth store instance
 */
export function roleGuard(to, from, next, auth) {
  // Allow public routes
  if (to.meta.public) {
    return next()
  }

  // Check authentication
  if (!auth.isAuthenticated) {
    return next({ name: 'Login', query: { redirect: to.fullPath } })
  }

  // Check role-based access
  if (to.meta.roles && to.meta.roles.length > 0) {
    const userRole = auth.user?.role
    if (!to.meta.roles.includes(userRole)) {
      return next({ name: 'Unauthorized' })
    }
  }

  next()
}

/**
 * Component-level role validation
 * @param {string} userRole - Current user role
 * @param {Array} allowedRoles - Array of allowed roles
 * @returns {boolean}
 */
export function validateRoleAccess(userRole, allowedRoles) {
  if (!userRole || !Array.isArray(allowedRoles)) {
    return false
  }
  return allowedRoles.includes(userRole)
}

/**
 * Feature-level permission validation
 * @param {string} userRole - Current user role
 * @param {string} feature - Feature to check
 * @returns {boolean}
 */
export function validateFeatureAccess(userRole, feature) {
  const permissions = ROLE_PERMISSIONS[userRole]
  if (!permissions) {
    return false
  }
  return permissions[feature] === true
}

/**
 * Navigation item filter based on role
 * @param {Array} menuItems - Array of menu items
 * @param {string} userRole - Current user role
 * @param {string} section - Menu section (main, reports, system, delivery)
 * @returns {Array}
 */
export function filterNavigationByRole(menuItems, userRole, section = 'main') {
  if (!Array.isArray(menuItems) || !userRole) {
    return []
  }

  const roleConfig = {
    [ROLES.ADMIN]: {
      main: ['dashboard', 'pos', 'products', 'categories', 'sales', 'orders', 'customers', 'suppliers', 'purchase-orders'],
      reports: ['reports', 'advanced-reports', 'analytics', 'stock-alerts', 'audit-logs'],
      system: ['users', 'settings'],
      delivery: ['delivery-assignments', 'delivery-status']
    },
    [ROLES.MANAGER]: {
      main: ['dashboard', 'pos', 'products', 'categories', 'sales', 'orders', 'customers', 'suppliers', 'purchase-orders'],
      reports: ['reports', 'advanced-reports', 'analytics', 'stock-alerts'],
      system: [],
      delivery: ['delivery-assignments', 'delivery-status']
    },
    [ROLES.CASHIER]: {
      main: ['dashboard', 'pos', 'sales', 'orders'],
      reports: [],
      system: [],
      delivery: []
    },
    [ROLES.CUSTOMER]: {
      main: ['shop', 'my-orders'],
      reports: [],
      system: [],
      delivery: []
    },
    [ROLES.DELIVERY_STAFF]: {
      main: ['dashboard', 'delivery-assignments', 'delivery-status'],
      reports: [],
      system: [],
      delivery: ['delivery-assignments', 'delivery-status']
    },
    [ROLES.SUPPLIER]: {
      main: ['supplier-dashboard', 'purchase-orders', 'stock-confirmation'],
      reports: [],
      system: [],
      delivery: ['delivery-status']
    }
  }

  const allowedItems = roleConfig[userRole]?.[section] || []
  return menuItems.filter(item => allowedItems.includes(item.key))
}

/**
 * Get role-specific dashboard path
 * @param {string} userRole - Current user role
 * @returns {string}
 */
export function getRoleDashboardPath(userRole) {
  const dashboardPaths = {
    [ROLES.ADMIN]: '/admin/dashboard',
    [ROLES.MANAGER]: '/admin/dashboard',
    [ROLES.CASHIER]: '/admin/dashboard',
    [ROLES.CUSTOMER]: '/store',
    [ROLES.DELIVERY_STAFF]: '/admin/delivery-assignments',
    [ROLES.SUPPLIER]: '/admin/supplier-dashboard'
  }

  return dashboardPaths[userRole] || '/admin/dashboard'
}

/**
 * Check if user can access admin panel
 * @param {string} userRole - Current user role
 * @returns {boolean}
 */
export function canAccessAdminPanel(userRole) {
  return [
    ROLES.ADMIN,
    ROLES.MANAGER,
    ROLES.CASHIER,
    ROLES.DELIVERY_STAFF,
    ROLES.SUPPLIER
  ].includes(userRole)
}

/**
 * Check if user is internal staff
 * @param {string} userRole - Current user role
 * @returns {boolean}
 */
export function isInternalStaff(userRole) {
  return [
    ROLES.ADMIN,
    ROLES.MANAGER,
    ROLES.CASHIER,
    ROLES.DELIVERY_STAFF
  ].includes(userRole)
}

/**
 * Check if user is external user
 * @param {string} userRole - Current user role
 * @returns {boolean}
 */
export function isExternalUser(userRole) {
  return [
    ROLES.CUSTOMER,
    ROLES.SUPPLIER
  ].includes(userRole)
}

/**
 * Get role-specific welcome message
 * @param {string} userRole - Current user role
 * @param {string} userName - User's name
 * @returns {string}
 */
export function getRoleWelcomeMessage(userRole, userName) {
  const messages = {
    [ROLES.ADMIN]: `Welcome back, ${userName}! You have full system access.`,
    [ROLES.MANAGER]: `Welcome, ${userName}! Manage your business operations.`,
    [ROLES.CASHIER]: `Hello, ${userName}! Ready to process sales?`,
    [ROLES.CUSTOMER]: `Welcome, ${userName}! Enjoy shopping with us.`,
    [ROLES.DELIVERY_STAFF]: `Hi, ${userName}! Check your delivery assignments.`,
    [ROLES.SUPPLIER]: `Welcome, ${userName}! Manage your supply orders.`
  }

  return messages[userRole] || `Welcome, ${userName}!`
}

/**
 * Get role-specific color scheme
 * @param {string} userRole - Current user role
 * @returns {Object}
 */
export function getRoleColorScheme(userRole) {
  const colorSchemes = {
    [ROLES.ADMIN]: {
      primary: 'green',
      secondary: 'yellow',
      accent: 'emerald'
    },
    [ROLES.MANAGER]: {
      primary: 'yellow',
      secondary: 'orange',
      accent: 'amber'
    },
    [ROLES.CASHIER]: {
      primary: 'green',
      secondary: 'emerald',
      accent: 'teal'
    },
    [ROLES.CUSTOMER]: {
      primary: 'blue',
      secondary: 'indigo',
      accent: 'sky'
    },
    [ROLES.DELIVERY_STAFF]: {
      primary: 'purple',
      secondary: 'violet',
      accent: 'fuchsia'
    },
    [ROLES.SUPPLIER]: {
      primary: 'orange',
      secondary: 'red',
      accent: 'rose'
    }
  }

  return colorSchemes[userRole] || colorSchemes[ROLES.CUSTOMER]
}

/**
 * Validate component access based on role
 * @param {string} userRole - Current user role
 * @param {string} componentName - Component name to validate
 * @returns {boolean}
 */
export function validateComponentAccess(userRole, componentName) {
  const componentAccess = {
    // Admin components
    UserManagement: [ROLES.ADMIN],
    SystemSettings: [ROLES.ADMIN],
    AuditLogs: [ROLES.ADMIN],
    
    // Manager components
    ProductManagement: [ROLES.ADMIN, ROLES.MANAGER],
    SupplierManagement: [ROLES.ADMIN, ROLES.MANAGER],
    ReportsAnalytics: [ROLES.ADMIN, ROLES.MANAGER],
    
    // Cashier components
    POSSystem: [ROLES.ADMIN, ROLES.MANAGER, ROLES.CASHIER],
    SalesManagement: [ROLES.ADMIN, ROLES.MANAGER, ROLES.CASHIER],
    
    // Delivery components
    DeliveryManagement: [ROLES.ADMIN, ROLES.MANAGER, ROLES.DELIVERY_STAFF],
    
    // Supplier components
    PurchaseOrderView: [ROLES.ADMIN, ROLES.MANAGER, ROLES.SUPPLIER],
    StockConfirmation: [ROLES.SUPPLIER],
    
    // Customer components
    ProductBrowsing: [ROLES.CUSTOMER, ROLES.ADMIN, ROLES.MANAGER, ROLES.CASHIER],
    OrderManagement: [ROLES.CUSTOMER, ROLES.ADMIN, ROLES.MANAGER]
  }

  const allowedRoles = componentAccess[componentName]
  return allowedRoles ? allowedRoles.includes(userRole) : false
}

export default {
  roleGuard,
  validateRoleAccess,
  validateFeatureAccess,
  filterNavigationByRole,
  getRoleDashboardPath,
  canAccessAdminPanel,
  isInternalStaff,
  isExternalUser,
  getRoleWelcomeMessage,
  getRoleColorScheme,
  validateComponentAccess
}