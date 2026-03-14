<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
          {{ t('common.welcome') }} {{ userName }}!
        </h1>
        <p class="text-gray-600 mt-2">{{ currentDate }}</p>
      </div>

      <!-- Simple Stats -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-900">{{ t('dashboard.todaySales') }}</h3>
          <p class="text-2xl font-bold text-green-600 mt-2">ETB {{ formatCurrency(data.today_sales) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-900">{{ t('dashboard.totalProducts') }}</h3>
          <p class="text-2xl font-bold text-blue-600 mt-2">{{ data.total_products }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-900">{{ t('dashboard.stockAlerts') }}</h3>
          <p class="text-2xl font-bold text-red-600 mt-2">{{ alertCounts.total }}</p>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-8">
        <p>{{ t('common.loading') }}</p>
      </div>

      <!-- Debug Info -->
      <div class="bg-white p-4 rounded-lg shadow mt-8">
        <h3 class="font-semibold mb-2">Debug Info:</h3>
        <p>Current Locale: {{ locale }}</p>
        <p>User Role: {{ userRole }}</p>
        <p>Data loaded: {{ !loading }}</p>
        <p>Translation test: {{ t('navigation.dashboard') }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { useTranslation } from '@/composables/useTranslation'

const { t, locale } = useTranslation()
const authStore = useAuthStore()

const loading = ref(true)
const data = ref({ 
  today_sales: 15000, 
  total_products: 150 
})
const alertCounts = ref({ total: 5 })

const userName = computed(() => authStore.user?.name?.split(' ')[0] || 'User')
const userRole = computed(() => authStore.user?.role || 'user')
const currentDate = computed(() => {
  return new Date().toLocaleDateString('en-ET', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
})

const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { 
    minimumFractionDigits: 2, 
    maximumFractionDigits: 2 
  })
}

onMounted(async () => {
  // Simulate loading
  setTimeout(() => {
    loading.value = false
  }, 1000)
})
</script>
</template>