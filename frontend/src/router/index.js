import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/',
    redirect: '/store',
    meta: { public: true }
  },
  // Language Demo Route (for testing)
  {
    path: '/language-demo',
    name: 'LanguageDemo',
    component: () => import('../views/LanguageDemo.vue'),
    meta: { public: true }
  },
  // Test Page Route
  {
    path: '/test',
    name: 'TestPage',
    component: () => import('../views/TestPage.vue'),
    meta: { public: true }
  },
  // Public Storefront Routes
  {
    path: '/store',
    name: 'Store',
    component: () => import('../views/storefront/Home.vue'),
    meta: { public: true }
  },
  {
    path: '/store/products',
    name: 'StoreProducts',
    component: () => import('../views/storefront/Products.vue'),
    meta: { public: true }
  },
  {
    path: '/store/products/:id',
    name: 'ProductDetail',
    component: () => import('../views/storefront/ProductDetail.vue'),
    meta: { public: true }
  },
  {
    path: '/store/orders',
    name: 'StoreOrders',
    component: () => import('../views/storefront/Orders.vue'),
    meta: { public: true }
  },
  {
    path: '/store/checkout',
    name: 'Checkout',
    component: () => import('../views/storefront/Checkout.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/store/my-orders',
    name: 'StoreMyOrders',
    component: () => import('../views/storefront/MyOrders.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/store/scan',
    name: 'QRScan',
    component: () => import('../views/storefront/QRScan.vue'),
    meta: { public: true }
  },
  {
    path: '/store/cart',
    name: 'Cart',
    component: () => import('../views/storefront/Cart.vue'),
    meta: { public: true }
  },
  {
    path: '/store/profile',
    name: 'Profile',
    component: () => import('../views/storefront/Profile.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/payment/callback',
    name: 'PaymentCallback',
    component: () => import('../views/PaymentCallback.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/auth/Login.vue'),
    meta: { guest: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/auth/Register.vue'),
    meta: { guest: true }
  },
  {
    path: '/auth/social/callback',
    name: 'SocialCallback',
    component: () => import('../views/auth/SocialCallback.vue'),
    meta: { public: true }
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('../views/auth/ForgotPassword.vue'),
    meta: { guest: true }
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('../views/auth/ResetPassword.vue'),
    meta: { guest: true }
  },
  {
    path: '/admin',
    component: () => import('../views/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/admin/dashboard' },
      { path: 'dashboard', name: 'Dashboard', component: () => import('../views/admin/EnhancedDashboard.vue'), meta: { roles: ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'] } },
      { path: 'simple-dashboard', name: 'SimpleDashboard', component: () => import('../views/admin/SimpleDashboard.vue'), meta: { roles: ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'] } },
      { path: 'test-dashboard', name: 'TestDashboard', component: () => import('../views/admin/TestDashboard.vue'), meta: { roles: ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier'] } },
      { path: 'products', name: 'Products', component: () => import('../views/admin/Products.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'categories', name: 'Categories', component: () => import('../views/admin/Categories.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'pos', name: 'POS', component: () => import('../views/admin/POS.vue'), meta: { roles: ['admin', 'manager', 'cashier'] } },
      { path: 'sales', name: 'Sales', component: () => import('../views/admin/Sales.vue'), meta: { roles: ['admin', 'manager', 'cashier'] } },
      { path: 'reports', name: 'Reports', component: () => import('../views/admin/Reports.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'advanced-reports', name: 'AdvancedReports', component: () => import('../views/admin/AdvancedReports.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'analytics', name: 'Analytics', component: () => import('../views/admin/AnalyticsDashboard.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'stock-alerts', name: 'StockAlerts', component: () => import('../views/admin/StockAlerts.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'audit-logs', name: 'AuditLogs', component: () => import('../views/admin/AuditLogs.vue'), meta: { roles: ['admin'] } },
      { path: 'customers', name: 'Customers', component: () => import('../views/admin/Customers.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'orders', name: 'Orders', component: () => import('../views/admin/Orders.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'suppliers', name: 'Suppliers', component: () => import('../views/admin/Suppliers.vue'), meta: { roles: ['admin', 'manager'] } },
      { path: 'users', name: 'Users', component: () => import('../views/admin/Users.vue'), meta: { roles: ['admin'] } },
      { path: 'settings', name: 'Settings', component: () => import('../views/admin/Settings.vue'), meta: { roles: ['admin'] } },
      
      // Purchase Order Management (Admin/Manager/Supplier)
      { path: 'purchase-orders', name: 'PurchaseOrders', component: () => import('../views/admin/PurchaseOrders.vue'), meta: { roles: ['admin', 'manager', 'supplier'] } },
      
      // Delivery Management (Admin/Manager/Delivery Staff)
      { path: 'delivery-assignments', name: 'DeliveryAssignments', component: () => import('../views/admin/DeliveryAssignments.vue'), meta: { roles: ['admin', 'manager', 'delivery_staff'] } },
      { path: 'delivery-status', name: 'DeliveryStatus', component: () => import('../views/admin/DeliveryStatus.vue'), meta: { roles: ['admin', 'manager', 'delivery_staff'] } },
      
      // Supplier-specific routes
      { path: 'supplier-dashboard', name: 'SupplierDashboard', component: () => import('../views/admin/SupplierDashboard.vue'), meta: { roles: ['supplier'] } },
      { path: 'stock-confirmation', name: 'StockConfirmation', component: () => import('../views/admin/StockConfirmation.vue'), meta: { roles: ['supplier'] } },
      
      // Customer-specific routes
      { path: 'shop', name: 'Shop', component: () => import('../views/admin/Shop.vue'), meta: { roles: ['customer'] } },
      { path: 'my-orders', name: 'MyOrders', component: () => import('../views/admin/MyOrders.vue'), meta: { roles: ['customer'] } },
    ]
  },
  {
    path: '/unauthorized',
    name: 'Unauthorized',
    component: () => import('../views/Unauthorized.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../views/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guard for authentication and role-based access
router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  
  // Allow public routes without authentication (store pages)
  if (to.meta.public) {
    return next()
  }
  
  // Allow guest routes (login, register) for non-authenticated users
  if (to.meta.guest) {
    if (auth.isAuthenticated) {
      const userRole = auth.user?.role
      // Redirect based on role
      switch (userRole) {
        case 'customer':
          return next('/store')
        case 'supplier':
          return next('/admin/supplier-dashboard')
        case 'delivery_staff':
          return next('/admin/delivery-assignments')
        default:
          return next('/admin/dashboard')
      }
    }
    return next()
  }
  
  // Check if route requires authentication
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next({ name: 'Login', query: { redirect: to.fullPath } })
  }
  
  // Check role-based access
  if (to.meta.roles && auth.isAuthenticated) {
    const userRole = auth.user?.role
    if (!to.meta.roles.includes(userRole)) {
      return next({ name: 'Unauthorized' })
    }
  }
  
  next()
})

export default router
