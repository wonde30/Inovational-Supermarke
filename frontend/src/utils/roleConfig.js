/**
 * Role Configuration for Frontend Access Control
 * Defines permissions, navigation, and access rules for all 6 user roles
 */

export const ROLES = {
  ADMIN: 'admin',
  MANAGER: 'manager',
  CASHIER: 'cashier',
  CUSTOMER: 'customer',
  DELIVERY_STAFF: 'delivery_staff',
  SUPPLIER: 'supplier'
}

export const ROLE_PERMISSIONS = {
  [ROLES.ADMIN]: {
    // System Management
    canManageUsers: true,
    canManageSettings: true,
    canAccessBackup: true,
    canViewAuditLogs: true,
    
    // Business Operations
    canManageProducts: true,
    canManageCategories: true,
    canManageSuppliers: true,
    canManageOrders: true,
    canManageCustomers: true,
    
    // Sales & POS
    canAccessPOS: true,
    canManageSales: true,
    canProcessPayments: true,
    
    // Reports & Analytics
    canViewReports: true,
    canViewAnalytics: true,
    canExportData: true,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: true,
    canViewPurchaseOrders: true,
    canManageDeliveries: true,
    
    // Dashboard Access
    dashboardType: 'admin'
  },

  [ROLES.MANAGER]: {
    // System Management
    canManageUsers: false,
    canManageSettings: false,
    canAccessBackup: false,
    canViewAuditLogs: false,
    
    // Business Operations
    canManageProducts: true,
    canManageCategories: true,
    canManageSuppliers: true,
    canManageOrders: true,
    canManageCustomers: true,
    
    // Sales & POS
    canAccessPOS: true,
    canManageSales: true,
    canProcessPayments: true,
    
    // Reports & Analytics
    canViewReports: true,
    canViewAnalytics: true,
    canExportData: true,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: true,
    canViewPurchaseOrders: true,
    canManageDeliveries: true,
    
    // Dashboard Access
    dashboardType: 'manager'
  },

  [ROLES.CASHIER]: {
    // System Management
    canManageUsers: false,
    canManageSettings: false,
    canAccessBackup: false,
    canViewAuditLogs: false,
    
    // Business Operations
    canManageProducts: false,
    canManageCategories: false,
    canManageSuppliers: false,
    canManageOrders: false,
    canManageCustomers: false,
    
    // Sales & POS
    canAccessPOS: true,
    canManageSales: true,
    canProcessPayments: true,
    
    // Reports & Analytics
    canViewReports: false,
    canViewAnalytics: false,
    canExportData: false,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: false,
    canViewPurchaseOrders: false,
    canManageDeliveries: false,
    
    // Dashboard Access
    dashboardType: 'cashier'
  },

  [ROLES.CUSTOMER]: {
    // System Management
    canManageUsers: false,
    canManageSettings: false,
    canAccessBackup: false,
    canViewAuditLogs: false,
    
    // Business Operations
    canManageProducts: false,
    canManageCategories: false,
    canManageSuppliers: false,
    canManageOrders: false,
    canManageCustomers: false,
    
    // Sales & POS
    canAccessPOS: false,
    canManageSales: false,
    canProcessPayments: false,
    
    // Reports & Analytics
    canViewReports: false,
    canViewAnalytics: false,
    canExportData: false,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: false,
    canViewPurchaseOrders: false,
    canManageDeliveries: false,
    
    // Customer-specific permissions
    canPlaceOrders: true,
    canViewOwnOrders: true,
    canManageProfile: true,
    canBrowseProducts: true,
    canManageCart: true,
    
    // Dashboard Access
    dashboardType: 'customer'
  },

  [ROLES.DELIVERY_STAFF]: {
    // System Management
    canManageUsers: false,
    canManageSettings: false,
    canAccessBackup: false,
    canViewAuditLogs: false,
    
    // Business Operations
    canManageProducts: false,
    canManageCategories: false,
    canManageSuppliers: false,
    canManageOrders: false,
    canManageCustomers: false,
    
    // Sales & POS
    canAccessPOS: false,
    canManageSales: false,
    canProcessPayments: false,
    
    // Reports & Analytics
    canViewReports: false,
    canViewAnalytics: false,
    canExportData: false,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: false,
    canViewPurchaseOrders: false,
    canManageDeliveries: true,
    
    // Delivery-specific permissions
    canViewDeliveryAssignments: true,
    canUpdateDeliveryStatus: true,
    canViewDeliveryRoutes: true,
    
    // Dashboard Access
    dashboardType: 'delivery'
  },

  [ROLES.SUPPLIER]: {
    // System Management
    canManageUsers: false,
    canManageSettings: false,
    canAccessBackup: false,
    canViewAuditLogs: false,
    
    // Business Operations
    canManageProducts: false,
    canManageCategories: false,
    canManageSuppliers: false,
    canManageOrders: false,
    canManageCustomers: false,
    
    // Sales & POS
    canAccessPOS: false,
    canManageSales: false,
    canProcessPayments: false,
    
    // Reports & Analytics
    canViewReports: false,
    canViewAnalytics: false,
    canExportData: false,
    
    // Purchase Orders & Delivery
    canManagePurchaseOrders: false,
    canViewPurchaseOrders: true,
    canManageDeliveries: false,
    
    // Supplier-specific permissions
    canViewOwnPurchaseOrders: true,
    canUpdateDeliveryStatus: true,
    canConfirmStock: true,
    canViewSupplierDashboard: true,
    
    // Dashboard Access
    dashboardType: 'supplier'
  }
}

export const NAVIGATION_CONFIG = {
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
    main: ['shop', 'my-orders', 'profile'],
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

export const ROLE_DISPLAY_CONFIG = {
  [ROLES.ADMIN]: {
    name: 'Administrator',
    icon: '👑',
    color: 'bg-gradient-to-br from-green-500 to-yellow-500',
    indicatorColor: 'bg-green-400',
    description: 'Full system access'
  },
  
  [ROLES.MANAGER]: {
    name: 'Manager',
    icon: '👔',
    color: 'bg-gradient-to-br from-yellow-500 to-red-500',
    indicatorColor: 'bg-yellow-400',
    description: 'Business operations management'
  },
  
  [ROLES.CASHIER]: {
    name: 'Cashier',
    icon: '💵',
    color: 'bg-green-600',
    indicatorColor: 'bg-emerald-400',
    description: 'Point of sale operations'
  },
  
  [ROLES.CUSTOMER]: {
    name: 'Customer',
    icon: '🛍️',
    color: 'bg-blue-600',
    indicatorColor: 'bg-blue-400',
    description: 'Shopping and orders'
  },
  
  [ROLES.DELIVERY_STAFF]: {
    name: 'Delivery Staff',
    icon: '🚚',
    color: 'bg-purple-600',
    indicatorColor: 'bg-purple-400',
    description: 'Delivery management'
  },
  
  [ROLES.SUPPLIER]: {
    name: 'Supplier',
    icon: '📦',
    color: 'bg-orange-600',
    indicatorColor: 'bg-orange-400',
    description: 'Supply chain management'
  }
}

export const DEFAULT_REDIRECTS = {
  [ROLES.ADMIN]: '/admin/dashboard',
  [ROLES.MANAGER]: '/admin/dashboard',
  [ROLES.CASHIER]: '/admin/dashboard',
  [ROLES.CUSTOMER]: '/store',
  [ROLES.DELIVERY_STAFF]: '/admin/delivery-assignments',
  [ROLES.SUPPLIER]: '/admin/supplier-dashboard'
}

/**
 * Check if user has specific permission
 * @param {string} userRole - User's role
 * @param {string} permission - Permission to check
 * @returns {boolean}
 */
export function hasPermission(userRole, permission) {
  return ROLE_PERMISSIONS[userRole]?.[permission] || false
}

/**
 * Get navigation items for user role
 * @param {string} userRole - User's role
 * @param {string} section - Navigation section (main, reports, system, delivery)
 * @returns {Array}
 */
export function getNavigationItems(userRole, section = 'main') {
  return NAVIGATION_CONFIG[userRole]?.[section] || []
}

/**
 * Get role display configuration
 * @param {string} userRole - User's role
 * @returns {Object}
 */
export function getRoleDisplayConfig(userRole) {
  return ROLE_DISPLAY_CONFIG[userRole] || ROLE_DISPLAY_CONFIG[ROLES.CUSTOMER]
}

/**
 * Get default redirect path for role
 * @param {string} userRole - User's role
 * @returns {string}
 */
export function getDefaultRedirect(userRole) {
  return DEFAULT_REDIRECTS[userRole] || DEFAULT_REDIRECTS[ROLES.CUSTOMER]
}

/**
 * Check if user can access a specific route
 * @param {string} userRole - User's role
 * @param {string} routeName - Route name to check
 * @returns {boolean}
 */
export function canAccessRoute(userRole, routeName) {
  const config = NAVIGATION_CONFIG[userRole]
  if (!config) return false
  
  return Object.values(config).some(section => 
    Array.isArray(section) && section.includes(routeName.toLowerCase())
  )
}

export default {
  ROLES,
  ROLE_PERMISSIONS,
  NAVIGATION_CONFIG,
  ROLE_DISPLAY_CONFIG,
  DEFAULT_REDIRECTS,
  hasPermission,
  getNavigationItems,
  getRoleDisplayConfig,
  getDefaultRedirect,
  canAccessRoute
}