<template>
  <div class="min-h-screen flex">
    <!-- Mobile Menu Overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside :class="[
      'sidebar w-72 flex flex-col fixed h-full z-50 transition-transform duration-300 ease-in-out',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]">

      <!-- Logo Section -->
      <div class="sidebar-brand">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl bg-white/20 backdrop-blur-sm">
              <span class="text-3xl">🏪</span>
            </div>
            <div>
              <h1 class="text-xl font-extrabold text-white tracking-tight">{{ t('common.smart') }}</h1>
              <p class="text-xs text-green-100 font-medium">{{ t('common.supermarketSystem') }}</p>
            </div>
          </div>
          <!-- Close button for mobile -->
          <button @click="sidebarOpen = false" class="lg:hidden w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all">
            <span class="text-xl">✕</span>
          </button>
        </div>
        <!-- Smart Flag Bar -->
        <div class="flex gap-1 mt-4">
          <div class="h-1.5 flex-1 bg-green-400 rounded-l-full"></div>
          <div class="h-1.5 flex-1 bg-emerald-400"></div>
          <div class="h-1.5 flex-1 bg-teal-400 rounded-r-full"></div>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="sidebar-nav flex-1 overflow-y-auto">
        <div class="sidebar-section">
          <p class="sidebar-section-title">{{ t('navigation.mainMenu') }}</p>
          <router-link v-for="item in filteredMainMenu" :key="item.path" :to="item.path" @click="sidebarOpen = false"
            class="sidebar-link"
            :class="{ 'sidebar-link-active': $route.path === item.path }">
            <span class="text-xl">{{ item.icon }}</span>
            <span class="flex-1 font-medium">{{ item.name }}</span>
            <span v-if="item.key === 'orders' && pendingOrdersCount > 0" class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
              {{ pendingOrdersCount }}
            </span>
          </router-link>
        </div>

        <div v-if="filteredReportMenu.length > 0" class="sidebar-section">
          <p class="sidebar-section-title">{{ t('navigation.reportsAnalytics') }}</p>
          <router-link v-for="item in filteredReportMenu" :key="item.path" :to="item.path" @click="sidebarOpen = false"
            class="sidebar-link"
            :class="{ 'sidebar-link-active': $route.path === item.path }">
            <span class="text-xl">{{ item.icon }}</span>
            <span class="flex-1 font-medium">{{ item.name }}</span>
            <span v-if="item.key === 'stock-alerts' && alertCount > 0" class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
              {{ alertCount }}
            </span>
          </router-link>
        </div>

        <div v-if="filteredSystemMenu.length > 0" class="sidebar-section">
          <p class="sidebar-section-title">{{ t('navigation.system') }}</p>
          <router-link v-for="item in filteredSystemMenu" :key="item.path" :to="item.path" @click="sidebarOpen = false"
            class="sidebar-link"
            :class="{ 'sidebar-link-active': $route.path === item.path }">
            <span class="text-xl">{{ item.icon }}</span>
            <span class="flex-1 font-medium">{{ item.name }}</span>
          </router-link>
        </div>
      </nav>

      <!-- User Section -->
      <div class="relative z-10 p-4 border-t border-white/10">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/10 mb-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold" :class="getRoleAvatarColor">{{ userInitial }}</div>
          <div class="flex-1 min-w-0">
            <p class="font-bold text-white truncate">{{ userName }}</p>
            <p class="text-xs text-green-100 capitalize flex items-center gap-1">
              <span class="w-2 h-2 rounded-full animate-pulse" :class="getRoleIndicatorColor"></span>
              {{ getRoleIcon }} {{ userRole }}
            </p>
          </div>
        </div>
        <button @click.stop="handleLogout" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white bg-red-600 hover:bg-red-500 transition-all font-medium shadow-lg">
          <span>🚪</span>
          <span>{{ t('navigation.logout') }}</span>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-72 flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
      <!-- Header -->
      <header class="bg-white shadow-sm border-b border-gray-200 px-4 lg:px-8 py-4 sticky top-0 z-30">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-4">
            <!-- Hamburger Menu Button -->
            <button @click="sidebarOpen = true" class="lg:hidden w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg hover:shadow-xl transition-all" style="background: var(--color-brand-primary);">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
            <div>
              <h2 class="text-xl lg:text-2xl font-bold" style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ translatedPageTitle }}</h2>
              <p class="text-gray-500 text-xs lg:text-sm flex items-center gap-2">
                <span>📅</span>
                <span class="hidden sm:inline">{{ currentDateTime }}</span>
                <span class="sm:hidden">{{ shortDateTime }}</span>
              </p>
            </div>
          </div>
          <div class="flex items-center gap-3 lg:gap-4">
            <!-- Desktop Stats Bar - Unified Design -->
            <div class="hidden lg:flex items-center bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-1.5 shadow-inner border border-gray-200">
              <!-- Today's Sales -->
              <div class="flex items-center gap-3 px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-md">
                  <span class="text-white text-lg">💰</span>
                </div>
                <div class="text-left">
                  <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">{{ t('dashboard.todaySales') }}</p>
                  <p class="font-bold text-emerald-600 text-base leading-tight">ETB {{ todaySales }}</p>
                </div>
              </div>
              
              <!-- Pending Orders - Clickable -->
              <router-link v-if="canAccessOrders" to="/admin/orders" class="flex items-center gap-3 px-4 py-2 rounded-xl transition-all hover:bg-white hover:shadow-md ml-1.5 group" :class="pendingOrdersCount > 0 ? 'bg-orange-50' : ''">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md transition-transform group-hover:scale-110" :class="pendingOrdersCount > 0 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-gray-300 to-gray-400'">
                  <span class="text-white text-lg">📋</span>
                </div>
                <div class="text-left">
                  <p class="text-[10px] font-medium uppercase tracking-wide" :class="pendingOrdersCount > 0 ? 'text-orange-600' : 'text-gray-500'">{{ t('dashboard.pending') }}</p>
                  <div class="flex items-center gap-1.5">
                    <p class="font-bold text-base leading-tight" :class="pendingOrdersCount > 0 ? 'text-orange-600' : 'text-gray-400'">{{ pendingOrdersCount }}</p>
                    <span v-if="pendingOrdersCount > 0" class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                  </div>
                </div>
              </router-link>
              
              <!-- Alerts - Clickable -->
              <router-link v-if="canAccessAlerts" to="/admin/stock-alerts" class="flex items-center gap-3 px-4 py-2 rounded-xl transition-all hover:bg-white hover:shadow-md ml-1.5 group" :class="alertCount > 0 ? 'bg-red-50' : ''">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md transition-transform group-hover:scale-110" :class="alertCount > 0 ? 'bg-gradient-to-br from-red-400 to-red-600' : 'bg-gradient-to-br from-gray-300 to-gray-400'">
                  <span class="text-white text-lg">🚨</span>
                </div>
                <div class="text-left">
                  <p class="text-[10px] font-medium uppercase tracking-wide" :class="alertCount > 0 ? 'text-red-600' : 'text-gray-500'">{{ t('dashboard.alerts') }}</p>
                  <div class="flex items-center gap-1.5">
                    <p class="font-bold text-base leading-tight" :class="alertCount > 0 ? 'text-red-600' : 'text-gray-400'">{{ alertCount }}</p>
                    <span v-if="alertCount > 0" class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                  </div>
                </div>
              </router-link>
            </div>
            
            <!-- Mobile Stats -->
            <div class="flex lg:hidden items-center gap-2">
              <router-link v-if="canAccessOrders" to="/admin/orders" class="relative p-2.5 rounded-xl transition-all hover:scale-110 bg-white shadow-md border" :class="pendingOrdersCount > 0 ? 'border-orange-300' : 'border-gray-200'">
                <span class="text-xl">📋</span>
                <span class="absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 text-white text-xs rounded-full flex items-center justify-center font-bold" :class="pendingOrdersCount > 0 ? 'bg-orange-500 animate-bounce' : 'bg-gray-400'">{{ pendingOrdersCount }}</span>
              </router-link>
              <router-link v-if="canAccessAlerts" to="/admin/stock-alerts" class="relative p-2.5 rounded-xl transition-all hover:scale-110 bg-white shadow-md border" :class="alertCount > 0 ? 'border-red-300' : 'border-gray-200'">
                <span class="text-xl">🚨</span>
                <span class="absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 text-white text-xs rounded-full flex items-center justify-center font-bold" :class="alertCount > 0 ? 'bg-red-500 animate-bounce' : 'bg-gray-400'">{{ alertCount }}</span>
              </router-link>
            </div>
            
            <!-- Theme and Language Controls -->
            <div class="flex items-center gap-2">
              <ThemeToggle />
              <LanguageSwitcher />
            </div>
            
            <!-- Action Buttons -->
            <router-link v-if="canAccessPOS" to="/admin/pos" class="btn-primary flex items-center gap-2 px-4 lg:px-5 py-2.5 lg:py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:scale-105">
              <span class="text-lg">🛒</span>
              <span class="hidden sm:inline">{{ t('pos.newSale') }}</span>
            </router-link>
            <router-link to="/store" class="flex items-center gap-2 px-4 lg:px-5 py-2.5 lg:py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:scale-105" style="background: var(--color-brand-secondary); color: white;">
              <span class="text-lg">🏪</span>
              <span class="hidden sm:inline">{{ t('navigation.store') }}</span>
            </router-link>
          </div>
        </div>
      </header>

      <!-- New Order Notification Toast -->
      <div v-if="newOrderNotification" class="fixed top-20 right-4 lg:right-6 z-50 text-white px-4 lg:px-6 py-3 lg:py-4 rounded-2xl shadow-2xl animate-slide-in flex items-center gap-3 lg:gap-4 max-w-sm" style="background: var(--gradient-primary);">
        <span class="text-2xl lg:text-3xl">🔔</span>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-sm lg:text-base">New Order Received!</p>
          <p class="text-xs lg:text-sm opacity-90 truncate">{{ newOrderNotification }}</p>
        </div>
        <button @click="newOrderNotification = ''" class="hover:bg-white/20 rounded-full p-1">✕</button>
      </div>

      <!-- Stock Alert Notification Toast -->
      <div v-if="newStockAlertNotification" class="fixed top-36 right-4 lg:right-6 z-50 text-white px-4 lg:px-6 py-3 lg:py-4 rounded-2xl shadow-2xl animate-slide-in flex items-center gap-3 lg:gap-4 max-w-sm" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
        <span class="text-2xl lg:text-3xl">🚨</span>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-sm lg:text-base">Stock Alert!</p>
          <p class="text-xs lg:text-sm opacity-90 truncate">{{ newStockAlertNotification }}</p>
        </div>
        <button @click="newStockAlertNotification = ''" class="hover:bg-white/20 rounded-full p-1">✕</button>
      </div>

      <!-- Logout Confirmation Modal -->
      <div v-if="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);">
        <div class="bg-white rounded-3xl p-6 lg:p-8 max-w-md w-full text-center shadow-2xl transform transition-all">
          <div class="w-16 lg:w-20 h-16 lg:h-20 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6">
            <span class="text-4xl lg:text-5xl">🚪</span>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-2">{{ t('auth.logoutConfirm') }}</h3>
          <p class="text-gray-600 mb-6 lg:mb-8 text-sm lg:text-base">{{ t('auth.logoutConfirmMessage') }}</p>
          <div class="flex gap-3 lg:gap-4">
            <button @click="showLogoutModal = false" class="flex-1 py-3 lg:py-4 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-bold transition-all text-sm lg:text-base">
              {{ t('common.cancel') }}
            </button>
            <button @click="confirmLogout" class="flex-1 py-3 lg:py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl font-bold transition-all shadow-lg flex items-center justify-center gap-2 text-sm lg:text-base">
              <span>🚪</span>
              <span>{{ t('navigation.logout') }}</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <main class="flex-1 p-4 lg:p-8 overflow-auto">
        <router-view />
      </main>

      <!-- Admin Chatbot -->
      <AdminChatbot />
      
      <!-- Chatbot Demo Notification -->
      <ChatbotDemo v-if="showChatbotDemo" @close="showChatbotDemo = false" />

      <!-- Footer - Compact & Modern -->
      <footer class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-gray-400">
        <!-- Smart Flag Top Border -->
        <div class="flex">
          <div class="h-1 flex-1 bg-gradient-to-r from-green-600 to-green-500"></div>
          <div class="h-1 flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400"></div>
          <div class="h-1 flex-1 bg-gradient-to-r from-red-600 to-red-500"></div>
        </div>
        
        <!-- Main Footer Content -->
        <div class="px-4 lg:px-8 py-6">
          <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            
            <!-- Brand & University Info -->
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
              <!-- Logo -->
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: var(--gradient-primary);">
                  <span class="text-2xl">🏪</span>
                </div>
                <div>
                  <h3 class="text-white font-bold text-base">{{ t('footer.smartSupermarket') }}</h3>
                  <p class="text-xs text-gray-500">{{ t('footer.inventoryBillingSystem') }}</p>
                </div>
              </div>
              
              <!-- Divider -->
              <div class="hidden sm:block w-px h-10 bg-gray-700"></div>
              
              <!-- University Badge -->
              <div class="flex items-center gap-3 px-4 py-2 rounded-xl bg-white/5 border border-white/10">
                <span class="text-xl">🎓</span>
                <div class="text-center sm:text-left">
                  <p class="text-white text-sm font-semibold">{{ t('footer.smartSupermarketKiot') }}</p>
                  <p class="text-xs text-yellow-500">{{ t('footer.itDepartment') }}</p>
                </div>
              </div>
            </div>
            
            <!-- Quick Stats & Status -->
            <div class="flex items-center gap-3">
              <!-- System Status -->
              <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-emerald-400 text-xs font-medium">{{ t('footer.systemOnline') }}</span>
              </div>
              
              <!-- Version -->
              <div class="px-3 py-2 rounded-lg bg-white/5 border border-white/10">
                <span class="text-xs text-gray-400">{{ t('footer.version') }} 1.0.0</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10 px-4 lg:px-8 py-3 bg-black/30">
          <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs">
            <p class="text-gray-500">{{ t('footer.copyrightText', { year: currentYear }) }}</p>
            <p class="flex items-center gap-1.5 text-gray-500">
              {{ t('footer.madeBy') }} <span class="text-red-500">❤</span> {{ t('footer.madeWithLove') }} <span class="text-green-400 font-medium">{{ t('footer.itWonde') }}</span>
            </p>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { useTranslation } from '../../composables/useTranslation'
import { useI18nStore } from '../../stores/i18n'
import { dashboardApi, advancedApi, ordersApi } from '../../services/api'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'
import AdminChatbot from '../../components/AdminChatbot.vue'
import ChatbotDemo from '../../components/ChatbotDemo.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const i18nStore = useI18nStore()
const { t } = useTranslation()
const currentDateTime = ref('')
const shortDateTime = ref('')
const todaySales = ref('0.00')
const alertCount = ref(0)
const pendingOrdersCount = ref(0)
const newOrderNotification = ref('')
const newStockAlertNotification = ref('')
const showLogoutModal = ref(false)
const sidebarOpen = ref(false)
const showChatbotDemo = ref(true)
let lastPendingCount = 0
let lastAlertCount = 0

// Close sidebar on route change (mobile)
watch(() => route.path, () => {
  sidebarOpen.value = false
})

const roleMenuAccess = {
  admin: { 
    main: ['dashboard', 'pos', 'products', 'categories', 'sales', 'orders', 'customers', 'suppliers', 'purchase-orders'], 
    reports: ['reports', 'advanced-reports', 'analytics', 'stock-alerts', 'audit-logs'], 
    system: ['users', 'settings'],
    delivery: ['delivery-assignments', 'delivery-status']
  },
  manager: { 
    main: ['dashboard', 'pos', 'products', 'categories', 'sales', 'orders', 'customers', 'suppliers', 'purchase-orders'], 
    reports: ['reports', 'advanced-reports', 'analytics', 'stock-alerts'], 
    system: [],
    delivery: ['delivery-assignments', 'delivery-status']
  },
  cashier: { 
    main: ['dashboard', 'pos', 'sales', 'orders'], 
    reports: [], 
    system: [],
    delivery: []
  },
  customer: { 
    main: ['shop', 'my-orders'], 
    reports: [], 
    system: [],
    delivery: []
  },
  delivery_staff: { 
    main: ['dashboard', 'delivery-assignments', 'delivery-status'], 
    reports: [], 
    system: [],
    delivery: ['delivery-assignments', 'delivery-status']
  },
  supplier: { 
    main: ['supplier-dashboard', 'purchase-orders', 'stock-confirmation'], 
    reports: [], 
    system: [],
    delivery: ['delivery-status']
  }
}

const allMainMenuItems = computed(() => {
  try {
    // Access the current locale to make this reactive
    const currentLocale = i18nStore.currentLocale
    
    return [
      { name: t('navigation.dashboard') || 'Dashboard', path: '/admin/dashboard', icon: '📊', key: 'dashboard' },
      { name: t('navigation.pos') || 'POS', path: '/admin/pos', icon: '🛒', key: 'pos' },
      { name: t('navigation.products') || 'Products', path: '/admin/products', icon: '📦', key: 'products' },
      { name: t('navigation.categories') || 'Categories', path: '/admin/categories', icon: '📁', key: 'categories' },
      { name: t('navigation.sales') || 'Sales', path: '/admin/sales', icon: '💰', key: 'sales' },
      { name: t('navigation.orders') || 'Orders', path: '/admin/orders', icon: '📋', key: 'orders' },
      { name: t('navigation.customers') || 'Customers', path: '/admin/customers', icon: '👥', key: 'customers' },
      { name: t('navigation.suppliers') || 'Suppliers', path: '/admin/suppliers', icon: '🚚', key: 'suppliers' },
      { name: t('navigation.purchaseOrders') || 'Purchase Orders', path: '/admin/purchase-orders', icon: '📄', key: 'purchase-orders' },
      { name: t('navigation.deliveryAssignments') || 'Delivery Assignments', path: '/admin/delivery-assignments', icon: '🚛', key: 'delivery-assignments' },
      { name: t('navigation.deliveryStatus') || 'Delivery Status', path: '/admin/delivery-status', icon: '📍', key: 'delivery-status' },
      { name: t('navigation.supplierDashboard') || 'Supplier Dashboard', path: '/admin/supplier-dashboard', icon: '📊', key: 'supplier-dashboard' },
      { name: t('navigation.stockConfirmation') || 'Stock Confirmation', path: '/admin/stock-confirmation', icon: '✅', key: 'stock-confirmation' },
      { name: t('navigation.shop') || 'Shop', path: '/admin/shop', icon: '🛍️', key: 'shop' },
      { name: t('navigation.myOrders') || 'My Orders', path: '/admin/my-orders', icon: '📋', key: 'my-orders' },
    ]
  } catch (error) {
    console.error('Error in allMainMenuItems:', error)
    return [
      { name: 'Dashboard', path: '/admin/dashboard', icon: '📊', key: 'dashboard' },
      { name: 'POS', path: '/admin/pos', icon: '🛒', key: 'pos' },
      { name: 'Products', path: '/admin/products', icon: '📦', key: 'products' },
      { name: 'Categories', path: '/admin/categories', icon: '📁', key: 'categories' },
      { name: 'Sales', path: '/admin/sales', icon: '💰', key: 'sales' },
      { name: 'Orders', path: '/admin/orders', icon: '📋', key: 'orders' },
      { name: 'Customers', path: '/admin/customers', icon: '👥', key: 'customers' },
      { name: 'Suppliers', path: '/admin/suppliers', icon: '🚚', key: 'suppliers' },
      { name: 'Purchase Orders', path: '/admin/purchase-orders', icon: '📄', key: 'purchase-orders' },
      { name: 'Delivery Assignments', path: '/admin/delivery-assignments', icon: '🚛', key: 'delivery-assignments' },
      { name: 'Delivery Status', path: '/admin/delivery-status', icon: '📍', key: 'delivery-status' },
      { name: 'Supplier Dashboard', path: '/admin/supplier-dashboard', icon: '📊', key: 'supplier-dashboard' },
      { name: 'Stock Confirmation', path: '/admin/stock-confirmation', icon: '✅', key: 'stock-confirmation' },
      { name: 'Shop', path: '/admin/shop', icon: '🛍️', key: 'shop' },
      { name: 'My Orders', path: '/admin/my-orders', icon: '📋', key: 'my-orders' },
    ]
  }
})

const allReportMenuItems = computed(() => {
  try {
    // Access the current locale to make this reactive
    const currentLocale = i18nStore.currentLocale
    
    return [
      { name: t('navigation.reports') || 'Reports', path: '/admin/reports', icon: '📈', key: 'reports' },
      { name: t('navigation.advancedReports') || 'Advanced Reports', path: '/admin/advanced-reports', icon: '📉', key: 'advanced-reports' },
      { name: t('navigation.analytics') || 'Analytics', path: '/admin/analytics', icon: '📊', key: 'analytics' },
      { name: t('navigation.stockAlerts') || 'Stock Alerts', path: '/admin/stock-alerts', icon: '🚨', key: 'stock-alerts' },
      { name: t('navigation.auditLogs') || 'Audit Logs', path: '/admin/audit-logs', icon: '🔒', key: 'audit-logs' },
    ]
  } catch (error) {
    console.error('Error in allReportMenuItems:', error)
    return [
      { name: 'Reports', path: '/admin/reports', icon: '📈', key: 'reports' },
      { name: 'Advanced Reports', path: '/admin/advanced-reports', icon: '📉', key: 'advanced-reports' },
      { name: 'Analytics', path: '/admin/analytics', icon: '📊', key: 'analytics' },
      { name: 'Stock Alerts', path: '/admin/stock-alerts', icon: '🚨', key: 'stock-alerts' },
      { name: 'Audit Logs', path: '/admin/audit-logs', icon: '🔒', key: 'audit-logs' },
    ]
  }
})

const allSystemMenuItems = computed(() => {
  try {
    // Access the current locale to make this reactive
    const currentLocale = i18nStore.currentLocale
    
    return [
      { name: t('navigation.users') || 'Users', path: '/admin/users', icon: '👤', key: 'users' },
      { name: t('navigation.settings') || 'Settings', path: '/admin/settings', icon: '⚙️', key: 'settings' },
    ]
  } catch (error) {
    console.error('Error in allSystemMenuItems:', error)
    return [
      { name: 'Users', path: '/admin/users', icon: '👤', key: 'users' },
      { name: 'Settings', path: '/admin/settings', icon: '⚙️', key: 'settings' },
    ]
  }
})

const userRole = computed(() => authStore.user?.role || 'cashier')
const userName = computed(() => authStore.user?.name || 'User')
const userInitial = computed(() => userName.value.charAt(0).toUpperCase())
const currentYear = computed(() => new Date().getFullYear())

const canAccessPOS = computed(() => ['admin', 'manager', 'cashier'].includes(userRole.value))
const canAccessOrders = computed(() => ['admin', 'manager'].includes(userRole.value))
const canAccessAlerts = computed(() => ['admin', 'manager'].includes(userRole.value))

const getRoleIcon = computed(() => {
  const icons = { 
    admin: '👑', 
    manager: '👔', 
    cashier: '💵', 
    customer: '🛍️',
    delivery_staff: '🚚',
    supplier: '📦'
  }
  return icons[userRole.value] || '👤'
})

const getRoleAvatarColor = computed(() => {
  const colors = { 
    admin: 'bg-gradient-to-br from-green-500 to-yellow-500', 
    manager: 'bg-gradient-to-br from-yellow-500 to-red-500', 
    cashier: 'bg-green-600', 
    customer: 'bg-blue-600',
    delivery_staff: 'bg-purple-600',
    supplier: 'bg-orange-600'
  }
  return colors[userRole.value] || 'bg-gray-600'
})

const getRoleIndicatorColor = computed(() => {
  const colors = { 
    admin: 'bg-green-400', 
    manager: 'bg-yellow-400', 
    cashier: 'bg-emerald-400', 
    customer: 'bg-blue-400',
    delivery_staff: 'bg-purple-400',
    supplier: 'bg-orange-400'
  }
  return colors[userRole.value] || 'bg-gray-400'
})

const translatedPageTitle = computed(() => {
  const routeName = route.name
  const titleMap = {
    'Dashboard': t('navigation.dashboard'),
    'SimpleDashboard': t('navigation.dashboard'),
    'TestDashboard': t('navigation.dashboard'),
    'POS': t('navigation.pos'),
    'Products': t('navigation.products'),
    'Categories': t('navigation.categories'),
    'Sales': t('navigation.sales'),
    'Orders': t('navigation.orders'),
    'Customers': t('navigation.customers'),
    'Suppliers': t('navigation.suppliers'),
    'Reports': t('navigation.reports'),
    'AdvancedReports': t('navigation.advancedReports'),
    'Analytics': t('navigation.analytics'),
    'StockAlerts': t('navigation.stockAlerts'),
    'AuditLogs': t('navigation.auditLogs'),
    'Users': t('navigation.users'),
    'Settings': t('navigation.settings'),
    'Shop': t('navigation.store'),
    'MyOrders': t('navigation.myOrders')
  }
  return titleMap[routeName] || routeName
})

const filteredMainMenu = computed(() => {
  try {
    const access = roleMenuAccess[userRole.value]?.main || []
    const menuItems = allMainMenuItems.value || []
    return Array.isArray(menuItems) ? menuItems.filter(item => access.includes(item.key)) : []
  } catch (error) {
    console.error('Error in filteredMainMenu:', error)
    return []
  }
})

const filteredReportMenu = computed(() => {
  try {
    const access = roleMenuAccess[userRole.value]?.reports || []
    const menuItems = allReportMenuItems.value || []
    return Array.isArray(menuItems) ? menuItems.filter(item => access.includes(item.key)) : []
  } catch (error) {
    console.error('Error in filteredReportMenu:', error)
    return []
  }
})

const filteredSystemMenu = computed(() => {
  try {
    const access = roleMenuAccess[userRole.value]?.system || []
    const menuItems = allSystemMenuItems.value || []
    return Array.isArray(menuItems) ? menuItems.filter(item => access.includes(item.key)) : []
  } catch (error) {
    console.error('Error in filteredSystemMenu:', error)
    return []
  }
})

const updateDateTime = () => {
  const now = new Date()
  currentDateTime.value = now.toLocaleString('en-ET', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
  shortDateTime.value = now.toLocaleString('en-ET', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' })
}

const fetchQuickStats = async () => {
  try {
    const [dashRes, alertRes] = await Promise.all([
      dashboardApi.get().catch(() => ({ data: { today_sales: 0 } })),
      advancedApi.stockAlertStatistics().catch(() => ({ data: { counts: { total: 0 } } }))
    ])
    todaySales.value = Number(dashRes.data?.today_sales || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })
    
    // Handle stock alert notifications
    const newAlertCount = alertRes.data?.counts?.total || 0
    if (newAlertCount > lastAlertCount && lastAlertCount > 0) {
      const diff = newAlertCount - lastAlertCount
      const alertTypes = alertRes.data?.counts || {}
      const recentAlerts = alertRes.data?.recent_alerts || []
      
      let alertMessage = `${diff} new alert${diff > 1 ? 's' : ''}`
      
      // Add specific alert type info from recent alerts
      if (recentAlerts.length > 0) {
        const mostRecentAlert = recentAlerts[0]
        if (mostRecentAlert.type === 'out_of_stock') {
          alertMessage += ` - ${mostRecentAlert.product_name} is out of stock!`
        } else if (mostRecentAlert.type === 'low_stock') {
          alertMessage += ` - ${mostRecentAlert.product_name} is low on stock (${mostRecentAlert.current_stock} left)`
        } else if (mostRecentAlert.type === 'expired') {
          alertMessage += ` - ${mostRecentAlert.product_name} has expired`
        } else if (mostRecentAlert.type === 'expiring_soon') {
          alertMessage += ` - ${mostRecentAlert.product_name} is expiring soon`
        }
      } else {
        // Fallback to counts
        if (alertTypes.out_of_stock > 0) {
          alertMessage += ` - ${alertTypes.out_of_stock} out of stock`
        } else if (alertTypes.low_stock > 0) {
          alertMessage += ` - ${alertTypes.low_stock} low stock`
        } else if (alertTypes.expired > 0) {
          alertMessage += ` - ${alertTypes.expired} expired`
        } else if (alertTypes.expiring_soon > 0) {
          alertMessage += ` - ${alertTypes.expiring_soon} expiring soon`
        }
      }
      
      newStockAlertNotification.value = alertMessage
      setTimeout(() => { newStockAlertNotification.value = '' }, 8000)
    }
    lastAlertCount = newAlertCount
    alertCount.value = newAlertCount
  } catch (e) {}
}

const fetchPendingOrders = async () => {
  if (!canAccessOrders.value) return
  try {
    const response = await ordersApi.statistics()
    const newCount = response.data?.pending_orders || 0
    if (newCount > lastPendingCount && lastPendingCount > 0) {
      const diff = newCount - lastPendingCount
      newOrderNotification.value = `${diff} new order${diff > 1 ? 's' : ''} waiting!`
      setTimeout(() => { newOrderNotification.value = '' }, 5000)
    }
    lastPendingCount = newCount
    pendingOrdersCount.value = newCount
  } catch (e) {}
}

let timer, orderTimer, alertTimer
onMounted(() => {
  updateDateTime()
  fetchQuickStats()
  fetchPendingOrders()
  timer = setInterval(updateDateTime, 60000)
  orderTimer = setInterval(fetchPendingOrders, 15000)
  alertTimer = setInterval(fetchQuickStats, 30000) // Check alerts every 30 seconds
})
onUnmounted(() => {
  clearInterval(timer)
  clearInterval(orderTimer)
  clearInterval(alertTimer)
})

const handleLogout = () => {
  showLogoutModal.value = true
  sidebarOpen.value = false
}

const confirmLogout = () => {
  localStorage.clear()
  window.location.replace('/login')
}
</script>

