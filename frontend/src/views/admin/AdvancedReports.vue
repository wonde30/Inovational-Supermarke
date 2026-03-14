<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">{{ t('reports.advancedReports') }}</h2>
      <div class="flex gap-2">
        <input type="date" v-model="startDate" class="input" />
        <input type="date" v-model="endDate" class="input" />
        <button @click="loadAllReports" class="btn btn-primary">{{ t('reports.generateReport') }}</button>
      </div>
    </div>

    <LoadingSpinner v-if="loading" />

    <div v-else class="space-y-6">
      <!-- Daily Summary -->
      <div class="card">
        <h3 class="text-lg font-semibold mb-4">📊 {{ t('reports.dailySummary') }}</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-green-50 p-4 rounded">
            <div class="text-2xl font-bold text-green-600">{{ formatCurrency(dailySummary.total_sales) }}</div>
            <div class="text-sm text-green-700">{{ t('dashboard.totalSales') }}</div>
          </div>
          <div class="bg-blue-50 p-4 rounded">
            <div class="text-2xl font-bold text-blue-600">{{ dailySummary.transaction_count }}</div>
            <div class="text-sm text-blue-700">{{ t('reports.transactions') }}</div>
          </div>
          <div class="bg-purple-50 p-4 rounded">
            <div class="text-2xl font-bold text-purple-600">{{ formatCurrency(dailySummary.gross_profit) }}</div>
            <div class="text-sm text-purple-700">{{ t('reports.grossProfit') }}</div>
          </div>
          <div class="bg-orange-50 p-4 rounded">
            <div class="text-2xl font-bold text-orange-600">{{ dailySummary.products_sold }}</div>
            <div class="text-sm text-orange-700">{{ t('reports.itemsSold') }}</div>
          </div>
        </div>
      </div>

      <!-- Cashier Performance -->
      <div class="card">
        <h3 class="text-lg font-semibold mb-4">👥 {{ t('reports.cashierPerformance') }}</h3>
        <table class="w-full">
          <thead>
            <tr class="text-left text-gray-500 border-b">
              <th class="pb-2">{{ t('users.cashier') }}</th>
              <th class="pb-2">{{ t('reports.transactions') }}</th>
              <th class="pb-2">{{ t('dashboard.totalSales') }}</th>
              <th class="pb-2">{{ t('reports.avgSale') }}</th>
              <th class="pb-2">{{ t('reports.discountsGiven') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cashier in cashierPerformance" :key="cashier.user_id" class="border-b">
              <td class="py-2 font-medium">{{ cashier.name }}</td>
              <td class="py-2">{{ cashier.transaction_count }}</td>
              <td class="py-2 text-green-600 font-bold">{{ formatCurrency(cashier.total_sales) }}</td>
              <td class="py-2">{{ formatCurrency(cashier.average_sale) }}</td>
              <td class="py-2 text-orange-600">{{ formatCurrency(cashier.total_discounts) }}</td>
            </tr>
          </tbody>
        </table>
        <div v-if="!cashierPerformance.length" class="text-center py-4 text-gray-500">
          {{ t('messages.noDataFound') }}
        </div>
      </div>

      <!-- Product Profitability -->
      <div class="card">
        <h3 class="text-lg font-semibold mb-4">💰 {{ t('reports.productProfitability') }}</h3>
        <table class="w-full">
          <thead>
            <tr class="text-left text-gray-500 border-b">
              <th class="pb-2">{{ t('products.title') }}</th>
              <th class="pb-2">{{ t('reports.unitsSold') }}</th>
              <th class="pb-2">{{ t('reports.revenue') }}</th>
              <th class="pb-2">{{ t('products.cost') }}</th>
              <th class="pb-2">{{ t('reports.profit') }}</th>
              <th class="pb-2">{{ t('reports.margin') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in productProfitability" :key="product.id" class="border-b">
              <td class="py-2 font-medium">{{ product.name }}</td>
              <td class="py-2">{{ product.units_sold }}</td>
              <td class="py-2">{{ formatCurrency(product.revenue) }}</td>
              <td class="py-2 text-gray-600">{{ formatCurrency(product.cost) }}</td>
              <td class="py-2 text-green-600 font-bold">{{ formatCurrency(product.profit) }}</td>
              <td class="py-2">
                <span :class="product.profit_margin >= 20 ? 'text-green-600' : 'text-orange-600'">
                  {{ product.profit_margin }}%
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Dead Stock -->
      <div class="card">
        <h3 class="text-lg font-semibold mb-4">📦 {{ t('reports.deadStock') }}</h3>
        <div class="mb-4 bg-red-50 p-3 rounded">
          <span class="text-red-700 font-medium">{{ t('reports.totalDeadStockValue') }}: {{ formatCurrency(deadStock.total_value) }}</span>
          <span class="text-red-600 ml-4">({{ deadStock.total_items }} {{ t('sales.items') }})</span>
        </div>
        <table class="w-full">
          <thead>
            <tr class="text-left text-gray-500 border-b">
              <th class="pb-2">{{ t('products.title') }}</th>
              <th class="pb-2">{{ t('products.sku') }}</th>
              <th class="pb-2">{{ t('products.category') }}</th>
              <th class="pb-2">{{ t('pos.quantity') }}</th>
              <th class="pb-2">{{ t('products.totalValue') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in deadStock.products" :key="product.id" class="border-b bg-red-50">
              <td class="py-2 font-medium">{{ product.name }}</td>
              <td class="py-2">{{ product.sku }}</td>
              <td class="py-2">{{ product.category }}</td>
              <td class="py-2">{{ product.quantity }}</td>
              <td class="py-2 text-red-600">{{ formatCurrency(product.value) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sales Trend -->
      <div class="card">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">📈 {{ t('reports.salesTrend') }}</h3>
          <div class="flex gap-2">
            <button @click="generateSalesReport" :disabled="generatingReport" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
              <span v-if="generatingReport">⏳</span>
              <span v-else>📊</span>
              <span>{{ generatingReport ? 'Generating...' : 'Generate Report' }}</span>
            </button>
            <button @click="exportSalesData" :disabled="exporting" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
              <span v-if="exporting">⏳</span>
              <span v-else>📥</span>
              <span>{{ exporting ? 'Exporting...' : 'Export' }}</span>
            </button>
          </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
          <div class="bg-blue-50 p-3 rounded text-center">
            <div class="text-xl font-bold text-blue-600">{{ formatCurrency(salesTrend.period_total) }}</div>
            <div class="text-sm text-blue-700">{{ t('reports.periodTotal') }}</div>
          </div>
          <div class="bg-green-50 p-3 rounded text-center">
            <div class="text-xl font-bold text-green-600">{{ salesTrend.period_transactions }}</div>
            <div class="text-sm text-green-700">{{ t('reports.transactions') }}</div>
          </div>
          <div class="bg-purple-50 p-3 rounded text-center">
            <div class="text-xl font-bold text-purple-600">{{ formatCurrency(salesTrend.daily_average) }}</div>
            <div class="text-sm text-purple-700">{{ t('reports.dailyAverage') }}</div>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-left text-gray-500 border-b">
                <th class="pb-2">{{ t('common.date') }}</th>
                <th class="pb-2">{{ t('navigation.sales') }}</th>
                <th class="pb-2">{{ t('reports.transactions') }}</th>
                <th class="pb-2">{{ t('reports.sevenDayAvg') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="day in salesTrend.trend?.slice(-14)" :key="day.date" class="border-b">
                <td class="py-1">{{ day.date }}</td>
                <td class="py-1 font-medium">{{ formatCurrency(day.total) }}</td>
                <td class="py-1">{{ day.transactions }}</td>
                <td class="py-1 text-blue-600">{{ formatCurrency(day.moving_average) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { advancedApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'
import LoadingSpinner from '../../components/LoadingSpinner.vue'

const toast = useToastStore()
const { t } = useTranslation()
const loading = ref(true)
const generatingReport = ref(false)
const exporting = ref(false)
const startDate = ref(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0])
const endDate = ref(new Date().toISOString().split('T')[0])

const dailySummary = ref({})
const cashierPerformance = ref([])
const productProfitability = ref([])
const deadStock = ref({ products: [], total_items: 0, total_value: 0 })
const salesTrend = ref({ trend: [], period_total: 0, period_transactions: 0, daily_average: 0 })

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-ET', { style: 'currency', currency: 'ETB' }).format(amount || 0)
}

const loadAllReports = async () => {
  loading.value = true
  try {
    const params = { start_date: startDate.value, end_date: endDate.value }
    
    const [summaryRes, cashierRes, profitRes, deadRes, trendRes] = await Promise.all([
      advancedApi.dailySummary({ date: endDate.value }),
      advancedApi.cashierPerformance(params),
      advancedApi.productProfitability(params),
      advancedApi.deadStock(),
      advancedApi.salesTrend({ days: 30 }),
    ])

    dailySummary.value = summaryRes.data || {}
    cashierPerformance.value = cashierRes.data || []
    productProfitability.value = profitRes.data || []
    deadStock.value = deadRes.data || { products: [], total_items: 0, total_value: 0 }
    salesTrend.value = trendRes.data || { trend: [], period_total: 0, period_transactions: 0, daily_average: 0 }
  } catch (e) {
    toast.error('Failed to load reports')
    console.error(e)
  } finally {
    loading.value = false
  }
}

const generateSalesReport = async () => {
  generatingReport.value = true
  try {
    const params = {
      start_date: startDate.value,
      end_date: endDate.value,
      report_type: 'sales_trend'
    }
    
    const response = await advancedApi.exportReport(params)
    
    // Create a blob from the response
    const blob = new Blob([JSON.stringify(response, null, 2)], { type: 'application/json' })
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = `sales-report-${startDate.value}-to-${endDate.value}.json`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)
    
    toast.success('Sales report generated successfully')
  } catch (e) {
    toast.error('Failed to generate report')
    console.error(e)
  } finally {
    generatingReport.value = false
  }
}

const exportSalesData = async () => {
  exporting.value = true
  try {
    // Export sales trend data as CSV
    const csvContent = [
      ['Date', 'Sales', 'Transactions', '7-Day Average'],
      ...salesTrend.value.trend.map(day => [
        day.date,
        day.total,
        day.transactions,
        day.moving_average
      ])
    ].map(row => row.join(',')).join('\n')
    
    const blob = new Blob([csvContent], { type: 'text/csv' })
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = `sales-trend-${startDate.value}-to-${endDate.value}.csv`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)
    
    toast.success('Sales data exported successfully')
  } catch (e) {
    toast.error('Failed to export data')
    console.error(e)
  } finally {
    exporting.value = false
  }
}

onMounted(loadAllReports)
</script>
