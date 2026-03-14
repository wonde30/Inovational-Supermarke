<template>
  <div class="space-y-6">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">📋 My Orders / የእኔ ትዕዛዞች</h1>
      <p class="text-gray-500">View your order history</p>
    </div>

    <div v-if="loading" class="text-center py-12">
      <div class="loading-spinner w-12 h-12 mx-auto"></div>
    </div>

    <div v-else-if="orders.length === 0" class="text-center py-12">
      <p class="text-6xl mb-4">📦</p>
      <p class="text-gray-500 mb-4">No orders yet</p>
      <router-link to="/admin/shop" class="btn btn-primary">🛍️ Start Shopping</router-link>
    </div>

    <div v-else class="space-y-4">
      <div v-for="order in orders" :key="order.id" class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <p class="font-bold text-lg">Order #{{ order.order_number || order.invoice_number }}</p>
            <p class="text-gray-500 text-sm">{{ formatDate(order.created_at) }}</p>
            <p v-if="order.sale" class="text-green-600 text-sm mt-1">
              Invoice: {{ order.sale.invoice_number }}
            </p>
          </div>
          <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-sm font-medium" :class="getStatusClass(order.status)">
              {{ getStatusLabel(order.status) }}
            </span>
            <button 
              v-if="order.status === 'pending'" 
              @click="cancelOrder(order.id)"
              :disabled="cancelling === order.id"
              class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700 hover:bg-red-200 transition-colors"
            >
              {{ cancelling === order.id ? 'Cancelling...' : 'Cancel' }}
            </button>
          </div>
        </div>
        <div class="border-t pt-4">
          <div v-for="item in (order.order_items || order.items)" :key="item.id" class="flex justify-between py-2">
            <span>{{ item.product?.name || 'Product' }} x {{ item.quantity }}</span>
            <span class="font-medium">ETB {{ formatCurrency(item.unit_price * item.quantity) }}</span>
          </div>
        </div>
        <div class="border-t pt-4 mt-4 flex justify-between items-center">
          <div>
            <span class="font-bold">Total</span>
            <span v-if="order.tax > 0" class="text-xs text-gray-500 ml-2">(incl. VAT {{ formatCurrency(order.tax) }})</span>
          </div>
          <span class="text-xl font-bold text-indigo-600">ETB {{ formatCurrency(order.total) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { storefrontApi } from '../../services/api'

const orders = ref([])
const loading = ref(true)
const cancelling = ref(null)

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })
const formatDate = (date) => date ? new Date(date).toLocaleDateString('en-ET', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-700',
    processing: 'bg-blue-100 text-blue-700',
    completed: 'bg-green-100 text-green-700',
    cancelled: 'bg-red-100 text-red-700'
  }
  return classes[status] || 'bg-gray-100 text-gray-700'
}

const getStatusLabel = (status) => {
  const labels = {
    pending: 'Pending / በመጠባበቅ ላይ',
    processing: 'Processing / በሂደት ላይ',
    completed: 'Completed / ተጠናቋል',
    cancelled: 'Cancelled / ተሰርዟል'
  }
  return labels[status] || status
}

const fetchOrders = async () => {
  try {
    const response = await storefrontApi.getOrders()
    orders.value = response.data || []
  } catch (e) {
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
    // Refresh orders
    await fetchOrders()
  } catch (e) {
    alert(e.message || 'Failed to cancel order')
  } finally {
    cancelling.value = null
  }
}

onMounted(fetchOrders)
</script>
