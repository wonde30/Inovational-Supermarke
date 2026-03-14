<template>
  <div class="sales-report-viewer">
    <div v-if="!reportData" class="empty-state">
      <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-dark-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-dark-900">{{ t('analytics.noReportGenerated') }}</h3>
        <p class="mt-1 text-sm text-dark-500">{{ t('analytics.selectDateRangeToGenerate') }}</p>
      </div>
    </div>

    <div v-else class="report-content">
      <!-- Report Header -->
      <div class="bg-white rounded-lg shadow-sm border border-dark-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h2 class="text-2xl font-bold text-dark-900">{{ t('analytics.salesReport') }}</h2>
            <p class="text-sm text-dark-600 mt-1">
              {{ formatDate(reportData.start_date) }} - {{ formatDate(reportData.end_date) }}
            </p>
          </div>
          <div class="flex gap-2">
            <button
              @click="handleExportPDF"
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
              {{ t('analytics.printReport') }}
            </button>
            <button
              @click="handleExport"
              class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              {{ t('analytics.exportCSV') }}
            </button>
          </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="bg-primary-50 rounded-lg p-4">
            <p class="text-sm text-primary-700 font-medium">{{ t('analytics.totalSales') }}</p>
            <p class="text-2xl font-bold text-primary-900 mt-1">
              {{ formatCurrency(reportData.total_sales) }}
            </p>
          </div>
          <div class="bg-accent-50 rounded-lg p-4">
            <p class="text-sm text-accent-700 font-medium">{{ t('analytics.totalItemsSold') }}</p>
            <p class="text-2xl font-bold text-accent-900 mt-1">
              {{ reportData.total_items }}
            </p>
          </div>
          <div class="bg-green-50 rounded-lg p-4">
            <p class="text-sm text-green-700 font-medium">{{ t('analytics.revenue') }}</p>
            <p class="text-2xl font-bold text-green-900 mt-1">
              {{ formatCurrency(reportData.revenue) }}
            </p>
          </div>
        </div>
      </div>

      <!-- Items Table -->
      <div class="bg-white rounded-lg shadow-sm border border-dark-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-dark-200">
          <h3 class="text-lg font-semibold text-dark-900">{{ t('analytics.salesBreakdown') }}</h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-dark-200">
            <thead class="bg-dark-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-dark-700 uppercase tracking-wider">
                  {{ t('products.product') }}
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-dark-700 uppercase tracking-wider">
                  {{ t('products.quantity') }}
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-dark-700 uppercase tracking-wider">
                  {{ t('analytics.amount') }}
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-dark-200">
              <tr v-for="(item, index) in reportData.items" :key="index" class="hover:bg-dark-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-900">
                  {{ item.product_name || item.product }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-900 text-right">
                  {{ item.quantity }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-900 text-right">
                  {{ formatCurrency(item.amount) }}
                </td>
              </tr>
              <tr v-if="!reportData.items || reportData.items.length === 0">
                <td colspan="3" class="px-6 py-8 text-center text-sm text-dark-500">
                  {{ t('analytics.noItemsFound') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useTranslation } from '@/composables/useTranslation'

const { t } = useTranslation()

const props = defineProps({
  reportData: {
    type: Object,
    default: null,
    validator: (value) => {
      if (value === null) return true
      return (
        typeof value.start_date === 'string' &&
        typeof value.end_date === 'string' &&
        typeof value.total_sales === 'number' &&
        typeof value.total_items === 'number' &&
        typeof value.revenue === 'number' &&
        Array.isArray(value.items)
      )
    }
  }
})

const emit = defineEmits(['export', 'exportPDF'])

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'ETB',
    minimumFractionDigits: 2
  }).format(amount)
}

const handleExport = () => {
  emit('export')
}

const handleExportPDF = () => {
  emit('exportPDF')
}
</script>

<style scoped>
.sales-report-viewer {
  width: 100%;
}
</style>
