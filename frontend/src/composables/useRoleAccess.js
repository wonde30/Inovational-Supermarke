/**
 * Role-based Access Control Composable
 * Provides reactive role checking and permission management
 */

import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'
import { 
  ROLES, 
  hasPermission, 
  getNavigationItems, 
  getRoleDisplayConfig, 
  getDefaultRedirect,
  canAccessRoute 
} from '../utils/roleConfig'

export function useRoleAccess() {
  const auth = useAuthStore()

  // Current user role
  const userRole = computed(() => auth.user?.role || null)
  
  // Role checking computed properties
  const isAdmin = computed(() => userRole.value === ROLES.ADMIN)
  const isManager = computed(() => userRole.value === ROLES.MANAGER)
  const isCashier = computed(() => userRole.value === ROLES.CASHIER)
  const isCustomer = computed(() => userRole.value === ROLES.CUSTOMER)
  const isDeliveryStaff = computed(() => userRole.value === ROLES.DELIVERY_STAFF)
  const isSupplier = computed(() => userRole.value === ROLES.SUPPLIER)

  // Permission checking functions
  const canManageUsers = computed(() => hasPermission(userRole.value, 'canManageUsers'))
  const canManageSettings = computed(() => hasPermission(userRole.value, 'canManageSettings'))
  const canManageProducts = computed(() => hasPermission(userRole.value, 'canManageProducts'))
  const canManageCategories = computed(() => hasPermission(userRole.value, 'canManageCategories'))
  const canManageSuppliers = computed(() => hasPermission(userRole.value, 'canManageSuppliers'))
  const canManageOrders = computed(() => hasPermission(userRole.value, 'canManageOrders'))
  const canManageCustomers = computed(() => hasPermission(userRole.value, 'canManageCustomers'))
  const canAccessPOS = computed(() => hasPermission(userRole.value, 'canAccessPOS'))
  const canManageSales = computed(() => hasPermission(userRole.value, 'canManageSales'))
  const canViewReports = computed(() => hasPermission(userRole.value, 'canViewReports'))
  const canViewAnalytics = computed(() => hasPermission(userRole.value, 'canViewAnalytics'))
  const canManagePurchaseOrders = computed(() => hasPermission(userRole.value, 'canManagePurchaseOrders'))
  const canViewPurchaseOrders = computed(() => hasPermission(userRole.value, 'canViewPurchaseOrders'))
  const canManageDeliveries = computed(() => hasPermission(userRole.value, 'canManageDeliveries'))
  const canViewDeliveryAssignments = computed(() => hasPermission(userRole.value, 'canViewDeliveryAssignments'))
  const canUpdateDeliveryStatus = computed(() => hasPermission(userRole.value, 'canUpdateDeliveryStatus'))
  const canConfirmStock = computed(() => hasPermission(userRole.value, 'canConfirmStock'))
  const canViewSupplierDashboard = computed(() => hasPermission(userRole.value, 'canViewSupplierDashboard'))

  // Navigation items
  const mainNavItems = computed(() => getNavigationItems(userRole.value, 'main'))
  const reportNavItems = computed(() => getNavigationItems(userRole.value, 'reports'))
  const systemNavItems = computed(() => getNavigationItems(userRole.value, 'system'))
  const deliveryNavItems = computed(() => getNavigationItems(userRole.value, 'delivery'))

  // Role display configuration
  const roleDisplayConfig = computed(() => getRoleDisplayConfig(userRole.value))
  const roleName = computed(() => roleDisplayConfig.value.name)
  const roleIcon = computed(() => roleDisplayConfig.value.icon)
  const roleColor = computed(() => roleDisplayConfig.value.color)
  const roleIndicatorColor = computed(() => roleDisplayConfig.value.indicatorColor)

  // Default redirect path
  const defaultRedirect = computed(() => getDefaultRedirect(userRole.value))

  // Helper functions
  const checkPermission = (permission) => {
    return hasPermission(userRole.value, permission)
  }

  const checkRouteAccess = (routeName) => {
    return canAccessRoute(userRole.value, routeName)
  }

  const isStaffRole = computed(() => {
    return [ROLES.ADMIN, ROLES.MANAGER, ROLES.CASHIER].includes(userRole.value)
  })

  const isInternalRole = computed(() => {
    return [ROLES.ADMIN, ROLES.MANAGER, ROLES.CASHIER, ROLES.DELIVERY_STAFF].includes(userRole.value)
  })

  const isExternalRole = computed(() => {
    return [ROLES.CUSTOMER, ROLES.SUPPLIER].includes(userRole.value)
  })

  // Role-specific dashboard paths
  const getDashboardPath = () => {
    switch (userRole.value) {
      case ROLES.SUPPLIER:
        return '/admin/supplier-dashboard'
      case ROLES.DELIVERY_STAFF:
        return '/admin/delivery-assignments'
      case ROLES.CUSTOMER:
        return '/store'
      default:
        return '/admin/dashboard'
    }
  }

  return {
    // Role state
    userRole,
    
    // Role checks
    isAdmin,
    isManager,
    isCashier,
    isCustomer,
    isDeliveryStaff,
    isSupplier,
    
    // Permission checks
    canManageUsers,
    canManageSettings,
    canManageProducts,
    canManageCategories,
    canManageSuppliers,
    canManageOrders,
    canManageCustomers,
    canAccessPOS,
    canManageSales,
    canViewReports,
    canViewAnalytics,
    canManagePurchaseOrders,
    canViewPurchaseOrders,
    canManageDeliveries,
    canViewDeliveryAssignments,
    canUpdateDeliveryStatus,
    canConfirmStock,
    canViewSupplierDashboard,
    
    // Navigation
    mainNavItems,
    reportNavItems,
    systemNavItems,
    deliveryNavItems,
    
    // Display config
    roleDisplayConfig,
    roleName,
    roleIcon,
    roleColor,
    roleIndicatorColor,
    
    // Utilities
    defaultRedirect,
    checkPermission,
    checkRouteAccess,
    isStaffRole,
    isInternalRole,
    isExternalRole,
    getDashboardPath
  }
}