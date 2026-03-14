import { defineStore } from 'pinia'
import { authApi } from '../services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    loading: false,
    error: null
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    userRole: (state) => state.user?.role || null,
    isAdmin: (state) => state.user?.role === 'admin',
    isManager: (state) => state.user?.role === 'manager',
    isCashier: (state) => state.user?.role === 'cashier',
    isCustomer: (state) => state.user?.role === 'customer',
    isDeliveryStaff: (state) => state.user?.role === 'delivery_staff',
    isSupplier: (state) => state.user?.role === 'supplier',
    
    // Check if user can access specific features
    canManageProducts: (state) => ['admin', 'manager'].includes(state.user?.role),
    canManageSales: (state) => ['admin', 'manager', 'cashier'].includes(state.user?.role),
    canViewReports: (state) => ['admin', 'manager'].includes(state.user?.role),
    canManageUsers: (state) => state.user?.role === 'admin',
    canManageSettings: (state) => state.user?.role === 'admin',
    canManageSuppliers: (state) => ['admin', 'manager'].includes(state.user?.role),
    canManageOrders: (state) => ['admin', 'manager'].includes(state.user?.role),
    canManageDeliveries: (state) => ['admin', 'manager', 'delivery_staff'].includes(state.user?.role),
    canViewPurchaseOrders: (state) => ['admin', 'manager', 'supplier'].includes(state.user?.role),
    canAccessPOS: (state) => ['admin', 'manager', 'cashier'].includes(state.user?.role),
    canAccessCustomerData: (state) => ['admin', 'manager', 'customer'].includes(state.user?.role),
  },

  actions: {
    async login(credentials) {
      this.loading = true
      this.error = null
      try {
        const response = await authApi.login(credentials)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        localStorage.setItem('user', JSON.stringify(this.user))
        
        // Sync language preference if user has one
        if (this.user.language) {
          const { useI18nStore } = await import('./i18n')
          const i18nStore = useI18nStore()
          await i18nStore.setLocale(this.user.language)
        }
        
        return response
      } catch (error) {
        this.error = error.message || 'Login failed'
        throw error
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        await authApi.logout()
      } catch (error) {
        // Ignore logout errors
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
        localStorage.removeItem('user')
      }
    },

    async fetchUser() {
      if (!this.token) return
      try {
        const response = await authApi.me()
        this.user = response.data
        localStorage.setItem('user', JSON.stringify(this.user))
        
        // Sync language preference if user has one
        if (this.user.language) {
          const { useI18nStore } = await import('./i18n')
          const i18nStore = useI18nStore()
          await i18nStore.setLocale(this.user.language)
        }
      } catch (error) {
        this.logout()
      }
    },

    async updateLanguagePreference(language) {
      try {
        const response = await authApi.updateLanguage({ language })
        this.user.language = language
        localStorage.setItem('user', JSON.stringify(this.user))
        return response
      } catch (error) {
        throw error
      }
    },

    // Check if user has access to a specific route
    hasAccess(routeName) {
      const roleAccess = {
        admin: ['dashboard', 'products', 'categories', 'pos', 'sales', 'reports', 'advanced-reports', 'stock-alerts', 'audit-logs', 'customers', 'suppliers', 'users', 'settings', 'purchase-orders'],
        manager: ['dashboard', 'products', 'categories', 'pos', 'sales', 'reports', 'advanced-reports', 'stock-alerts', 'customers', 'suppliers', 'purchase-orders'],
        cashier: ['dashboard', 'pos', 'sales', 'orders'],
        customer: ['shop', 'my-orders', 'profile', 'cart', 'checkout'],
        delivery_staff: ['dashboard', 'delivery-assignments', 'delivery-status'],
        supplier: ['supplier-dashboard', 'purchase-orders', 'delivery-status', 'stock-confirmation']
      }
      const userRole = this.user?.role
      return roleAccess[userRole]?.includes(routeName.toLowerCase()) || false
    },

    // Set token (for social login)
    setToken(token) {
      this.token = token
      localStorage.setItem('token', token)
    },

    // Set user (for social login)
    setUser(user) {
      this.user = user
      localStorage.setItem('user', JSON.stringify(user))
      
      // Sync language preference if user has one
      if (user.language) {
        import('./i18n').then(({ useI18nStore }) => {
          const i18nStore = useI18nStore()
          i18nStore.setLocale(user.language)
        })
      }
    }
  }
})
