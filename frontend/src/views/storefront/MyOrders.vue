<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm py-2">
      <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
          <span>📞 +251 911 123 456</span>
          <span class="hidden md:inline">📧 info@smartsupermarket.com</span>
        </div>
        <div class="flex items-center gap-4">
          <span>🚚 {{ t('storefront.freeDeliveryDesc') }}</span>
        </div>
      </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <router-link to="/store" class="flex items-center gap-3">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
              <span class="text-3xl">🏪</span>
            </div>
            <div>
              <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Smart SuperMarket</h1>
              <p class="text-xs text-gray-500">{{ t('storefront.yourCity') }}</p>
            </div>
          </router-link>
          
          <!-- User Dropdown Menu -->
          <div v-if="user" class="relative">
            <button @click="showUserMenu = !showUserMenu" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-100 transition-all">
              <div class="text-right hidden sm:block">
                <p class="text-xs text-gray-500">{{ t('auth.welcomeBack') }}</p>
                <p class="font-semibold text-gray-800">{{ user.name }}</p>
              </div>
              <div class="w-11 h-11 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg cursor-pointer hover:scale-105 transition-transform">
                {{ user.name.charAt(0).toUpperCase() }}
              </div>
              <span class="text-gray-400 text-xs">▼</span>
            </button>
            
            <!-- Dropdown Menu -->
            <div v-if="showUserMenu" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 overflow-hidden">
              <!-- User Info Header -->
              <div class="px-4 py-3 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                <p class="font-bold text-gray-800">{{ user.name }}</p>
                <p class="text-sm text-green-600">🛍️ {{ t('storefront.customerAccount') }}</p>
              </div>
              
              <!-- Menu Items -->
              <router-link to="/store" @click="showUserMenu = false" 
                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group">
                <span class="text-xl group-hover:scale-110 transition-transform">🏪</span>
                <div>
                  <p class="font-medium">{{ t('storefront.continueShopping') }}</p>
                  <p class="text-xs text-gray-400">{{ t('storefront.browseProducts') }}</p>
                </div>
              </router-link>
              
              <router-link to="/store/my-orders" @click="showUserMenu = false" 
                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-all duration-200 group">
                <span class="text-xl group-hover:scale-110 transition-transform">📋</span>
                <div>
                  <p class="font-medium">{{ t('storefront.myOrders') }}</p>
                  <p class="text-xs text-gray-400">{{ t('storefront.trackYourOrder') }}</p>
                </div>
              </router-link>
              
              <div class="border-t border-gray-100 my-1"></div>
              
              <button @click="handleLogout" 
                class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-all duration-200 group">
                <span class="text-xl group-hover:scale-110 transition-transform">🚪</span>
                <div class="text-left">
                  <p class="font-medium">{{ t('auth.logout') }}</p>
                  <p class="text-xs text-red-400">{{ t('auth.signOutOfAccount') }}</p>
                </div>
              </button>
            </div>
          </div>
          
          <!-- Login Button for non-logged users -->
          <div v-else class="flex items-center gap-2">
            <router-link to="/login" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:via-yellow-400 hover:to-red-500 text-white rounded-xl font-semibold transition-all shadow-lg">
              {{ t('auth.login') }}
            </router-link>
          </div>
        </div>
      </div>
      <!-- Smart Flag Bar -->
      <div class="flex">
        <div class="h-1 flex-1 bg-green-500"></div>
        <div class="h-1 flex-1 bg-yellow-500"></div>
        <div class="h-1 flex-1 bg-red-500"></div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-6">
      <!-- Status Change Notification -->
      <div v-if="statusNotification" class="fixed top-20 right-6 z-50 max-w-md animate-slide-in">
        <div class="rounded-2xl shadow-2xl p-6" :class="{
          'bg-gradient-to-r from-green-500 to-emerald-500 text-white': statusNotification.type === 'success',
          'bg-gradient-to-r from-yellow-500 to-amber-500 text-white': statusNotification.type === 'info',
          'bg-gradient-to-r from-red-500 to-rose-500 text-white': statusNotification.type === 'error'
        }">
          <div class="flex items-start gap-4">
            <span class="text-3xl">{{ statusNotification.type === 'success' ? '🎉' : statusNotification.type === 'info' ? '📦' : '❌' }}</span>
            <div class="flex-1">
              <p class="font-bold text-lg">{{ t('orders.orderStatusUpdated') }}</p>
              <p class="opacity-90">{{ statusNotification.message }}</p>
              <p v-if="statusNotification.invoice" class="mt-2 text-sm opacity-80">
                {{ t('orders.invoice') }}: {{ statusNotification.invoice }}
              </p>
            </div>
            <button @click="statusNotification = null" class="hover:bg-white/20 rounded-full p-1">✕</button>
          </div>
        </div>
      </div>

      <!-- Enhanced Page Header -->
      <div class="relative mb-8 group">
        <!-- 3D Background Layer -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-[1.02] shadow-2xl"></div>
        
        <!-- Main Content Layer -->
        <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-8 text-white shadow-2xl overflow-hidden border border-white/20">
          <!-- Animated Background -->
          <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
          </div>
          
          <div class="relative flex items-center justify-center gap-4">
            <div class="relative">
              <div class="absolute inset-0 bg-white rounded-2xl blur-xl opacity-50 animate-pulse"></div>
              <div class="relative w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl">
                <span class="text-4xl">📋</span>
              </div>
            </div>
            <div class="text-center">
              <h1 class="text-3xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent">
                {{ t('storefront.myOrders') }}
              </h1>
              <p class="text-green-100 text-sm font-medium">{{ t('storefront.viewAndTrackOrders') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-12">
        <div class="w-12 h-12 border-4 border-yellow-200 border-t-yellow-600 rounded-full animate-spin mx-auto"></div>
        <p class="text-gray-500 mt-4">{{ t('common.loading') }}...</p>
      </div>

      <!-- Enhanced Empty State -->
      <div v-else-if="orders.length === 0" class="relative group">
        <!-- 3D Shadow -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <!-- Main Card -->
        <div class="relative text-center py-20 bg-white rounded-3xl shadow-2xl border-2 border-gray-100 overflow-hidden">
          <!-- Animated Background Pattern -->
          <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(34, 197, 94, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(34, 197, 94, 0.3) 1px, transparent 1px); background-size: 50px 50px;"></div>
          </div>
          
          <div class="relative">
            <div class="relative inline-block mb-6">
              <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
              <div class="relative w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto shadow-xl">
                <span class="text-7xl">📦</span>
              </div>
            </div>
            <h2 class="text-3xl font-black text-gray-900 mb-3">{{ t('orders.noOrdersYet') }}</h2>
            <p class="text-gray-500 text-lg mb-8 max-w-md mx-auto">{{ t('orders.startShoppingJourney') }}</p>
            <router-link to="/store" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1 group/btn">
              <span class="text-2xl group-hover/btn:scale-110 transition-transform">🛍️</span>
              <span>{{ t('storefront.shopNow') }}</span>
              <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Orders List with 3D Effects -->
      <div v-else class="space-y-6">
        <div v-for="order in orders" :key="order.id" class="group relative transform transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100 group-hover:border-green-300 transition-all">
            <!-- Order Header with Gradient -->
            <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b-2 border-gray-100 flex justify-between items-center">
              <div class="flex items-center gap-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                  <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">{{ getStatusIcon(order.status) }}</span>
                  </div>
                </div>
                <div>
                  <p class="font-black text-gray-900 text-lg">{{ t('orders.orderNumber') }} #{{ order.order_number }}</p>
                  <p class="text-gray-500 text-sm flex items-center gap-2">
                    <span>📅</span>
                    <span>{{ formatDate(order.created_at) }}</span>
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-xl text-sm font-bold shadow-md transform group-hover:scale-105 transition-transform" :class="getStatusClass(order.status)">
                  {{ t('orders.' + order.status) }}
                </span>
                <button 
                  v-if="order.status === 'pending'" 
                  @click="cancelOrder(order.id)"
                  :disabled="cancelling === order.id"
                  class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-400 hover:to-red-500 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
                >
                  {{ cancelling === order.id ? t('common.loading') + '...' : t('common.cancel') }}
                </button>
              </div>
            </div>

            <!-- Order Items with Enhanced Design -->
            <div class="px-6 py-4 bg-gradient-to-br from-white to-gray-50">
              <div v-for="item in order.order_items" :key="item.id" class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0 hover:bg-green-50 rounded-lg px-3 -mx-3 transition-all group/item">
                <div class="flex items-center gap-4">
                  <div class="relative">
                    <div class="absolute inset-0 bg-green-500 rounded-xl blur-sm opacity-0 group-hover/item:opacity-30 transition-opacity"></div>
                    <div class="relative w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md group-hover/item:scale-110 transition-transform">
                      <span class="text-2xl">📦</span>
                    </div>
                  </div>
                  <div>
                    <p class="font-bold text-gray-900">{{ item.product?.name || t('products.title') }}</p>
                    <p class="text-sm text-gray-500 flex items-center gap-2 mt-1">
                      <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">{{ t('pos.qty') }}: {{ item.quantity }}</span>
                      <span class="text-gray-400">×</span>
                      <span class="font-medium text-gray-700">ETB {{ formatCurrency(item.unit_price) }}</span>
                    </p>
                  </div>
                </div>
                <p class="font-black text-gray-900 text-lg">ETB {{ formatCurrency(item.total) }}</p>
              </div>
            </div>

            <!-- Order Footer with Gradient -->
            <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-teal-50 px-6 py-4 border-t-2 border-gray-100 flex justify-between items-center">
              <div class="flex items-center gap-4 text-sm">
                <span v-if="order.tax > 0" class="flex items-center gap-2 text-gray-600">
                  <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                  <span>{{ t('storefront.vat') }}: <span class="font-semibold text-gray-800">ETB {{ formatCurrency(order.tax) }}</span></span>
                </span>
                <span v-if="order.sale" class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg shadow-sm border border-green-200">
                  <span class="text-lg">📄</span>
                  <span class="font-bold text-green-600">{{ order.sale.invoice_number }}</span>
                </span>
              </div>
              <div class="text-right">
                <p class="text-sm text-gray-500 font-semibold mb-1">{{ t('storefront.total') }}</p>
                <p class="text-2xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                  ETB {{ formatCurrency(order.total) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Back to Store Button -->
      <div class="text-center mt-10">
        <router-link to="/store" class="inline-flex items-center gap-3 px-6 py-3 bg-white hover:bg-green-50 text-green-600 hover:text-green-700 font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 border-2 border-green-200 hover:border-green-300 group">
          <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
          </svg>
          <span>{{ t('storefront.continueShopping') }}</span>
          <span class="text-xl group-hover:scale-110 transition-transform">🛍️</span>
        </router-link>
      </div>
    </main>

    <!-- Logout Confirmation Modal -->
    <div v-if="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);" @click.self="showLogoutModal = false">
      <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl">
        <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mx-auto mb-6">
          <span class="text-5xl">🚪</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ t('auth.logoutConfirmation') }}</h3>
        <p class="text-gray-500 mb-2">{{ t('auth.logoutConfirmMessage') }}</p>
        <p class="text-gray-600 mb-8">{{ t('auth.logoutConfirmMessage') }}</p>
        <div class="flex gap-4">
          <button @click="showLogoutModal = false" class="flex-1 py-4 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-bold transition-all">
            {{ t('common.cancel') }}
          </button>
          <button @click="confirmLogout" class="flex-1 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl font-bold transition-all shadow-lg flex items-center justify-center gap-2">
            <span>🚪</span>
            <span>{{ t('auth.logout') }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslation } from '@/composables/useTranslation'
import { storefrontApi } from '../../services/api'

const { t } = useTranslation()
const router = useRouter()
const orders = ref([])
const loading = ref(true)
const cancelling = ref(null)
const showUserMenu = ref(false)
const statusNotification = ref(null)
const showLogoutModal = ref(false)
let pollTimer = null
let previousStatuses = {}

const user = computed(() => {
  const userData = localStorage.getItem('user')
  return userData ? JSON.parse(userData) : null
})

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })

const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-ET', { 
    day: '2-digit', 
    month: 'short', 
    year: 'numeric', 
    hour: '2-digit', 
    minute: '2-digit' 
  })
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-lg',
    processing: 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg',
    completed: 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg',
    cancelled: 'bg-gradient-to-r from-red-500 to-rose-600 text-white shadow-lg'
  }
  return classes[status] || 'bg-gray-100 text-gray-700'
}

const getStatusIcon = (status) => {
  const icons = {
    pending: '⏳',
    processing: '🔄',
    completed: '✅',
    cancelled: '❌'
  }
  return icons[status] || '📋'
}

const getStatusLabel = (status) => {
  const labels = {
    pending: 'Pending',
    processing: 'Processing',
    completed: 'Completed',
    cancelled: 'Cancelled'
  }
  return labels[status] || status
}

const fetchOrders = async (showNotification = false) => {
  try {
    const response = await storefrontApi.getOrders()
    const newOrders = response.data || []
    
    // Check for status changes and show notification
    if (showNotification && Object.keys(previousStatuses).length > 0) {
      for (const order of newOrders) {
        const prevStatus = previousStatuses[order.id]
        if (prevStatus && prevStatus !== order.status) {
          // Status changed!
          if (order.status === 'completed') {
            statusNotification.value = {
              type: 'success',
              message: `Order #${order.order_number} has been completed! 🎉`,
              invoice: order.sale?.invoice_number
            }
          } else if (order.status === 'processing') {
            statusNotification.value = {
              type: 'info',
              message: `Order #${order.order_number} is now being processed! 🔄`
            }
          } else if (order.status === 'cancelled') {
            statusNotification.value = {
              type: 'error',
              message: `Order #${order.order_number} has been cancelled.`
            }
          }
          // Auto-hide after 8 seconds
          setTimeout(() => { statusNotification.value = null }, 8000)
        }
      }
    }
    
    // Store current statuses for next comparison
    previousStatuses = {}
    for (const order of newOrders) {
      previousStatuses[order.id] = order.status
    }
    
    orders.value = newOrders
  } catch (e) {
    console.error('Failed to fetch orders:', e)
    orders.value = []
  } finally {
    loading.value = false
  }
}

const cancelOrder = async (orderId) => {
  if (!confirm('Are you sure you want to cancel this order?')) return
  
  cancelling.value = orderId
  try {
    await storefrontApi.cancelOrder(orderId)
    await fetchOrders()
  } catch (e) {
    alert(e.message || 'Failed to cancel order')
  } finally {
    cancelling.value = null
  }
}

const handleLogout = () => {
  showLogoutModal.value = true
  showUserMenu.value = false
}

const confirmLogout = () => {
  localStorage.clear()
  showLogoutModal.value = false
  router.push('/login')
}

// Close user menu when clicking outside
const closeUserMenu = (e) => {
  if (!e.target.closest('.relative')) {
    showUserMenu.value = false
  }
}

onMounted(() => {
  if (!user.value) {
    router.push('/login')
    return
  }
  fetchOrders()
  // Poll for order status updates every 10 seconds
  pollTimer = setInterval(() => fetchOrders(true), 10000)
  // Add click outside listener
  document.addEventListener('click', closeUserMenu)
})

onUnmounted(() => {
  if (pollTimer) clearInterval(pollTimer)
  document.removeEventListener('click', closeUserMenu)
})
</script>



<style scoped>
/* Advanced Animations */
@keyframes float {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  33% {
    transform: translateY(-20px) translateX(10px);
  }
  66% {
    transform: translateY(-10px) translateX(-10px);
  }
}

@keyframes float-delayed {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  33% {
    transform: translateY(20px) translateX(-10px);
  }
  66% {
    transform: translateY(10px) translateX(10px);
  }
}

@keyframes slide-in {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 8s ease-in-out infinite;
}

.animate-slide-in {
  animation: slide-in 0.5s ease-out;
}

/* Smooth Transitions */
* {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom Scrollbar */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #22c55e, #10b981);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #16a34a, #059669);
}
</style>
