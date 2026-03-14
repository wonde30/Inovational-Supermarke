import axios from 'axios'

const api = axios.create({
  baseURL: '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Request interceptor - add auth token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// Response interceptor - handle errors
api.interceptors.response.use(
  (response) => {
    // Return full response for blob downloads
    if (response.config.responseType === 'blob') {
      return response
    }
    return response.data
  },
  (error) => {
    if (error.response?.status === 401) {
      const currentPath = window.location.pathname
      // Only clear auth and redirect if not on a public page
      // Public pages: /store, /, /login, /register
      const isPublicPage = currentPath.startsWith('/store') || 
                           currentPath === '/' || 
                           currentPath === '/login' || 
                           currentPath === '/register'
      
      if (!isPublicPage) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        window.location.href = '/login'
      }
      // For public pages, just reject the error without clearing auth
      // This allows the page to continue working even if a background auth check fails
    }
    return Promise.reject(error.response?.data || error)
  }
)

export default api

// Auth API
export const authApi = {
  login: (credentials) => api.post('/auth/login', credentials),
  register: (data) => api.post('/auth/register', data),
  logout: () => api.post('/auth/logout'),
  me: () => api.get('/auth/me'),
  resendVerification: (data) => api.post('/auth/resend-verification', data),
  forgotPassword: (data) => api.post('/auth/forgot-password', data),
  resetPassword: (data) => api.post('/auth/reset-password', data),
  verifyResetToken: (data) => api.post('/auth/verify-reset-token', data),
  updateLanguage: (data) => api.patch('/auth/language', data),
  getLanguages: () => api.get('/auth/languages'),
  updateProfile: (data) => api.put('/auth/profile', data),
  updatePassword: (data) => api.put('/auth/password', data),
}

// Products API
export const productsApi = {
  getAll: (params) => api.get('/products', { params }),
  get: (id) => api.get(`/products/${id}`),
  create: (data) => api.post('/products', data),
  update: (id, data) => api.put(`/products/${id}`, data),
  delete: (id) => api.delete(`/products/${id}`),
}

// Categories API
export const categoriesApi = {
  getAll: () => api.get('/categories'),
  get: (id) => api.get(`/categories/${id}`),
  create: (data) => api.post('/categories', data),
  update: (id, data) => api.put(`/categories/${id}`, data),
  delete: (id) => api.delete(`/categories/${id}`),
}

// Sales API
export const salesApi = {
  getAll: (params) => api.get('/sales', { params }),
  get: (id) => api.get(`/sales/${id}`),
  create: (data) => api.post('/sales', data),
  calculateTotals: (data) => api.post('/sales/calculate-totals', data),
  validateStock: (data) => api.post('/sales/validate-stock', data),
}

// Customers API
export const customersApi = {
  getAll: (params) => api.get('/customers', { params }),
  get: (id) => api.get(`/customers/${id}`),
  create: (data) => api.post('/customers', data),
  update: (id, data) => api.put(`/customers/${id}`, data),
  delete: (id) => api.delete(`/customers/${id}`),
}

// Suppliers API
export const suppliersApi = {
  getAll: (params) => api.get('/suppliers', { params }),
  get: (id) => api.get(`/suppliers/${id}`),
  create: (data) => api.post('/suppliers', data),
  update: (id, data) => api.put(`/suppliers/${id}`, data),
  delete: (id) => api.delete(`/suppliers/${id}`),
}

// Dashboard API
export const dashboardApi = {
  get: () => api.get('/dashboard'),
}

// Reports API
export const reportsApi = {
  sales: (params) => api.get('/reports/sales', { params }),
  profit: (params) => api.get('/reports/profit', { params }),
  topProducts: (params) => api.get('/reports/top-products', { params }),
}

// Backup API (Admin only)
export const backupApi = {
  create: () => api.post('/backup/create'),
  list: () => api.get('/backup/list'),
  restore: (filename) => api.post('/backup/restore', { filename }),
  download: (filename) => api.get(`/backup/download/${filename}`, { responseType: 'blob' }),
  delete: (filename) => api.delete(`/backup/${filename}`),
}

// Storefront API
export const storefrontApi = {
  getProducts: (params) => api.get('/storefront/products', { params }),
  getProduct: (id) => api.get(`/storefront/products/${id}`),
  getCategories: () => api.get('/storefront/categories'),
  calculateCart: (data) => api.post('/storefront/cart/calculate', data),
  validateStock: (data) => api.post('/storefront/cart/validate-stock', data),
  createOrder: (data) => api.post('/storefront/orders', data),
  getOrders: (params) => api.get('/storefront/orders', { params }),
  getOrder: (id) => api.get(`/storefront/orders/${id}`),
  cancelOrder: (id) => api.post(`/storefront/orders/${id}/cancel`),
  // Chapa Payment Integration
  checkout: (data) => api.post('/storefront/checkout', data),
  payForOrder: (orderId, paymentMethod = 'chapa') => api.post(`/storefront/orders/${orderId}/pay`, { payment_method: paymentMethod }),
  checkPaymentStatus: (orderId) => api.get(`/storefront/orders/${orderId}/payment-status`),
}

// Users API (Admin only)
export const usersApi = {
  getAll: (params) => api.get('/users', { params }),
  get: (id) => api.get(`/users/${id}`),
  create: (data) => api.post('/users', data),
  update: (id, data) => api.put(`/users/${id}`, data),
  delete: (id) => api.delete(`/users/${id}`),
}

// Orders API (Admin/Manager) - Customer orders management
export const ordersApi = {
  getAll: (params) => api.get('/orders', { params }),
  get: (id) => api.get(`/orders/${id}`),
  updateStatus: (id, status, paymentMethod = null) => api.patch(`/orders/${id}/status`, { 
    status, 
    payment_method: paymentMethod 
  }),
  statistics: () => api.get('/orders/statistics'),
}

// Advanced Reports API (Admin/Manager)
export const advancedApi = {
  stockAlerts: () => api.get('/advanced/stock-alerts'),
  stockAlertStatistics: () => api.get('/advanced/stock-alerts/statistics'),
  resolveAlert: (id) => api.post(`/advanced/stock-alerts/${id}/resolve`),
  auditLogs: (params) => api.get('/advanced/audit-logs', { params }),
  dailySummary: (params) => api.get('/advanced/daily-summary', { params }),
  cashierPerformance: (params) => api.get('/advanced/cashier-performance', { params }),
  productProfitability: (params) => api.get('/advanced/product-profitability', { params }),
  deadStock: () => api.get('/advanced/dead-stock'),
  expiringProducts: () => api.get('/advanced/expiring-products'),
  salesTrend: (params) => api.get('/advanced/sales-trend', { params }),
  exportReport: (params) => api.get('/advanced/export', { params }),
}

// Analytics API (Admin/Manager) - admin-dashboard-analytics feature
export const analyticsApi = {
  getOrderStatusCounts: () => api.get('/analytics/orders/status'),
  generateSalesReport: (params) => api.post('/analytics/sales/report', params),
  exportSalesReport: (params) => api.post('/analytics/sales/export', params, { responseType: 'blob' }),
}

// Payments API - admin-dashboard-analytics feature
export const paymentsApi = {
  initializePayment: (orderId) => api.post('/payments/initialize', { order_id: orderId }),
  verifyPayment: (transactionId) => api.get(`/payments/${transactionId}/verify`),
  manualVerify: (orderId) => api.post('/payments/manual-verify', { order_id: orderId }),
}
