<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">{{ t('storefront.myOrders') }}</h1>

    <div v-if="loading" class="flex justify-center py-12">
      <LoadingSpinner />
    </div>

    <div v-else-if="orders.length === 0">
      <EmptyState :message="t('storefront.noOrdersYet')">
        <router-link to="/store/products" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
          {{ t('storefront.startShopping') }}
        </router-link>
      </EmptyState>
    </div>

    <div v-else class="space-y-4">
      <div v-for="order in orders" :key="order.id" class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
          <div>
            <span class="font-semibold">{{ t('storefront.orderNumber') }} #{{ order.order_number || order.id }}</span>
            <span class="text-gray-500 ml-4">{{ formatDate(order.created_at) }}</span>
          </div>
          <span :class="statusClass(order.status)" class="px-3 py-1 rounded-full text-sm font-medium">
            {{ t('storefront.' + (order.status || 'pending')) }}
          </span>
        </div>
        <div class="p-4">
          <div v-for="item in order.order_items || order.orderItems || []" :key="item.id" class="flex justify-between py-2 border-b last:border-0">
            <div class="flex gap-3">
              <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">🛍️</div>
              <div>
                <p class="font-medium">{{ item.product?.name || t('products.title') }}</p>
                <p class="text-sm text-gray-500">{{ t('storefront.qty') }}: {{ item.quantity }} × ${{ Number(item.price).toFixed(2) }}</p>
              </div>
            </div>
            <span class="font-medium">${{ (item.quantity * item.price).toFixed(2) }}</span>
          </div>
          <div class="flex justify-between mt-4 pt-4 border-t font-bold">
            <span>{{ t('storefront.total') }}</span>
            <span>${{ Number(order.total || 0).toFixed(2) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { storefrontApi } from '@/services/api'
import { useToastStore } from '@/stores/toast'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import EmptyState from '@/components/EmptyState.vue'

const toast = useToastStore()
const loading = ref(true)
const orders = ref([])

const fetchOrders = async () => {
  try {
    loading.value = true
    const res = await storefrontApi.getOrders()
    orders.value = res.data || []
  } catch (error) {
    toast.error(t('storefront.failedToLoadOrders'))
  } finally {
    loading.value = false
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric'
  })
}

const statusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800'
  }
  return classes[status?.toLowerCase()] || 'bg-gray-100 text-gray-800'
}

onMounted(fetchOrders)
</script>
