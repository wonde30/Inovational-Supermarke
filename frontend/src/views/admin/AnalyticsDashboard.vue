<template>
  <div class="analytics-dashboard p-6">
    <!-- Page Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-dark-900">{{ t('analytics.title') }}</h1>
      <p class="text-dark-600 mt-1">{{ t('analytics.subtitle') }}</p>
    </div>

    <!-- Loading State -->
    <LoadingSpinner v-if="loading && !orderData" :text="t('analytics.loadingAnalytics')" />

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
        <div class="ml-3 flex-1">
          <h3 class="text-sm font-medium text-red-800">{{ t('analytics.errorLoadingAnalytics') }}</h3>
          <p class="text-sm text-red-700 mt-1">{{ error }}</p>
          <button
            @click="fetchAnalytics"
            class="mt-2 text-sm font-medium text-red-800 hover:text-red-900 underline"
          >
            {{ t('analytics.tryAgain') }}
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else>
      <!-- Order Status Analytics Section -->
      <div class="bg-white rounded-lg shadow-sm border border-dark-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-dark-900">{{ t('analytics.orderStatusAnalytics') }}</h2>
          <span class="text-xs text-dark-500">{{ t('analytics.autoRefreshes') }}</span>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Bar Chart -->
          <div class="chart-wrapper">
            <h3 class="text-sm font-medium text-dark-700 mb-3">{{ t('analytics.orderCountByStatus') }}</h3>
            <ChartRenderer
              v-if="chartData"
              chart-type="bar"
              :data="chartData"
              :x-axis-label="t('analytics.orderStatus')"
              :y-axis-label="t('analytics.orderCount')"
              :colors="chartColors"
            />
          </div>

          <!-- Pie Chart -->
          <div class="chart-wrapper">
            <h3 class="text-sm font-medium text-dark-700 mb-3">{{ t('analytics.orderDistribution') }}</h3>
            <ChartRenderer
              v-if="chartData"
              chart-type="pie"
              :data="chartData"
              :colors="chartColors"
            />
          </div>
        </div>
      </div>

      <!-- Sales Report Section -->
      <div class="bg-white rounded-lg shadow-sm border border-dark-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-dark-900 mb-4">{{ t('analytics.salesReportGenerator') }}</h2>

        <!-- Date Range Selector -->
        <div class="mb-4">
          <DateRangeSelector v-model="dateRange" />
        </div>

        <!-- Generate Report Button -->
        <button
          @click="generateReport"
          :disabled="reportLoading || !dateRange.startDate || !dateRange.endDate"
          class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors flex items-center gap-2 font-medium shadow-md"
        >
          <svg v-if="reportLoading" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span>{{ reportLoading ? t('analytics.generating') : t('analytics.generateReport') }}</span>
        </button>

        <!-- Report Error -->
        <div v-if="reportError" class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3">
          <p class="text-sm text-red-700">{{ reportError }}</p>
        </div>
      </div>

      <!-- Sales Report Viewer -->
      <SalesReportViewer
        :report-data="reportData"
        @export="exportReport"
        @exportPDF="exportReportPDF"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { analyticsApi } from '@/services/api'
import { useToastStore } from '@/stores/toast'
import { useTranslation } from '@/composables/useTranslation'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import ChartRenderer from '@/components/analytics/ChartRenderer.vue'
import DateRangeSelector from '@/components/analytics/DateRangeSelector.vue'
import SalesReportViewer from '@/components/analytics/SalesReportViewer.vue'

const toast = useToastStore()
const { t } = useTranslation()

// State
const loading = ref(false)
const error = ref(null)
const orderData = ref(null)
const dateRange = ref({
  startDate: '',
  endDate: ''
})
const reportData = ref(null)
const reportLoading = ref(false)
const reportError = ref(null)

let refreshInterval = null

// Computed
const chartData = computed(() => {
  if (!orderData.value) return null

  return {
    labels: [t('orders.pending'), t('orders.processing'), t('orders.completed')],
    datasets: [{
      label: t('analytics.orderCount'),
      data: [
        orderData.value.pending || 0,
        orderData.value.processing || 0,
        orderData.value.completed || 0
      ]
    }]
  }
})

const chartColors = computed(() => [
  'rgba(59, 130, 246, 0.8)',      // blue for pending
  'rgba(234, 179, 8, 0.8)',       // yellow for processing
  'rgba(34, 197, 94, 0.8)'        // green for completed
])

// Methods
const fetchAnalytics = async () => {
  try {
    loading.value = true
    error.value = null
    
    const response = await analyticsApi.getOrderStatusCounts()
    
    if (response.success) {
      orderData.value = response.data
    } else {
      throw new Error(response.message || 'Failed to fetch analytics')
    }
  } catch (err) {
    console.error('Error fetching analytics:', err)
    error.value = err.message || 'Failed to load analytics data'
    toast.error('Failed to load analytics data')
  } finally {
    loading.value = false
  }
}

const generateReport = async () => {
  if (!dateRange.value.startDate || !dateRange.value.endDate) {
    toast.warning(t('analytics.pleaseSelectBothDates'))
    return
  }

  try {
    reportLoading.value = true
    reportError.value = null
    
    const response = await analyticsApi.generateSalesReport({
      start_date: dateRange.value.startDate,
      end_date: dateRange.value.endDate
    })
    
    if (response.success) {
      reportData.value = response.data
      toast.success('Report generated successfully')
    } else {
      throw new Error(response.message || 'Failed to generate report')
    }
  } catch (err) {
    console.error('Error generating report:', err)
    reportError.value = err.message || 'Failed to generate sales report'
    toast.error('Failed to generate sales report')
  } finally {
    reportLoading.value = false
  }
}

const exportReportPDF = async () => {
  if (!reportData.value) {
    toast.warning(t('analytics.noReportToExport'))
    return
  }

  try {
    // Create a printable HTML version and convert to PDF using browser's print functionality
    const printWindow = window.open('', '_blank')
    const reportHtml = generateReportHTML()
    
    printWindow.document.write(reportHtml)
    printWindow.document.close()
    
    // Wait for content to load then trigger print
    printWindow.onload = () => {
      printWindow.print()
      printWindow.close()
    }
    
    toast.success(t('analytics.reportExportedSuccessfully'))
  } catch (err) {
    console.error('Error exporting PDF:', err)
    toast.error(t('analytics.failedToExportReport'))
  }
}

const generateReportHTML = () => {
  const items = reportData.value.items || []
  const itemsHtml = items.map(item => `
    <tr>
      <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">${item.product_name || item.product || ''}</td>
      <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: right;">${item.quantity}</td>
      <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: right;">ETB ${formatCurrency(item.amount)}</td>
    </tr>
  `).join('')

  return `
    <!DOCTYPE html>
    <html>
    <head>
      <title>${t('analytics.salesReport')}</title>
      <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .date-range { font-size: 14px; color: #666; }
        .summary { display: flex; justify-content: space-around; margin: 30px 0; }
        .summary-card { text-align: center; padding: 20px; background: #f9fafb; border-radius: 8px; }
        .summary-title { font-size: 12px; color: #666; margin-bottom: 5px; }
        .summary-value { font-size: 20px; font-weight: bold; }
        .table-section { margin-top: 30px; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; padding: 12px 8px; text-align: left; font-weight: bold; }
        td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        @media print {
          body { margin: 0; }
          .no-print { display: none; }
        }
      </style>
    </head>
    <body>
      <div class="header">
        <div class="title">${t('analytics.salesReport')}</div>
        <div class="date-range">${formatDate(reportData.value.start_date)} - ${formatDate(reportData.value.end_date)}</div>
      </div>
      
      <div class="summary">
        <div class="summary-card">
          <div class="summary-title">${t('analytics.totalSales')}</div>
          <div class="summary-value">ETB ${formatCurrency(reportData.value.total_sales)}</div>
        </div>
        <div class="summary-card">
          <div class="summary-title">${t('analytics.totalItemsSold')}</div>
          <div class="summary-value">${reportData.value.total_items}</div>
        </div>
        <div class="summary-card">
          <div class="summary-title">${t('analytics.revenue')}</div>
          <div class="summary-value">ETB ${formatCurrency(reportData.value.revenue)}</div>
        </div>
      </div>
      
      <div class="table-section">
        <div class="section-title">${t('analytics.salesBreakdown')}</div>
        <table>
          <thead>
            <tr>
              <th>${t('products.product')}</th>
              <th class="text-right">${t('products.quantity')}</th>
              <th class="text-right">${t('analytics.amount')}</th>
            </tr>
          </thead>
          <tbody>
            ${itemsHtml || `<tr><td colspan="3" style="text-align: center; padding: 20px;">${t('analytics.noItemsFound')}</td></tr>`}
          </tbody>
        </table>
      </div>
    </body>
    </html>
  `
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { 
    minimumFractionDigits: 2, 
    maximumFractionDigits: 2 
  })
}

const exportReport = async () => {
  if (!reportData.value) {
    toast.warning('No report to export')
    return
  }

  try {
    const response = await analyticsApi.exportSalesReport({
      start_date: dateRange.value.startDate,
      end_date: dateRange.value.endDate
    })
    
    // Create blob from response
    const blob = new Blob([response.data], { type: 'text/csv' })
    
    // Create download link
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = `sales-report-${dateRange.value.startDate}-to-${dateRange.value.endDate}.csv`
    
    // Trigger download
    document.body.appendChild(link)
    link.click()
    
    // Cleanup
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)
    
    toast.success('Report exported successfully')
  } catch (err) {
    console.error('Error exporting report:', err)
    toast.error('Failed to export report')
  }
}

// Lifecycle
onMounted(() => {
  // Initial fetch
  fetchAnalytics()
  
  // Set up auto-refresh every 5 seconds
  refreshInterval = setInterval(() => {
    fetchAnalytics()
  }, 5000)
})

onUnmounted(() => {
  // Clear interval on component unmount
  if (refreshInterval) {
    clearInterval(refreshInterval)
  }
})
</script>

<style scoped>
.analytics-dashboard {
  max-width: 1400px;
  margin: 0 auto;
}

.chart-wrapper {
  min-height: 300px;
}

@media (max-width: 768px) {
  .chart-wrapper {
    min-height: 250px;
  }
}
</style>
