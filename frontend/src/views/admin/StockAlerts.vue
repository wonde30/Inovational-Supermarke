<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-green-200/30 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-100/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 p-6 animate-fade-in">
      <!-- Header Section -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
          <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <span class="text-2xl">🚨</span>
            {{ t('navigation.stockAlerts') }}
          </h2>
          <p class="text-gray-600 mt-1">{{ t('dashboard.stockAlerts') }}</p>
        </div>
        <div class="flex items-center gap-3">
          <button @click="exportAlerts" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!hasAnyAlerts">
            <span>📥</span>
            {{ t('common.export') }}
          </button>
          <button @click="fetchAlerts" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="loading">
            <span :class="{ 'animate-spin': loading }">🔄</span>
            {{ t('common.refresh') }}
          </button>
          <button @click="generateAlerts" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="generating">
            <span :class="{ 'animate-spin': generating }">📊</span>
            Scan All Products
          </button>
        </div>
      </div>

    <!-- Alert Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
      <!-- Out of Stock Card -->
      <div class="stat-card stat-card-red cursor-pointer hover:scale-105 transition-all duration-300"
           :class="{ 'ring-4 ring-red-400 shadow-2xl': activeFilter === 'out_of_stock' }"
           @click="setFilter('out_of_stock')">
        <div class="flex items-center justify-between">
          <div>
            <div class="stat-value text-red-600">{{ counts.out_of_stock }}</div>
            <div class="stat-label text-red-700">Out of Stock / ያለቀ</div>
          </div>
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
            <span class="text-3xl">🚨</span>
          </div>
        </div>
        <div v-if="counts.out_of_stock > 0" class="mt-4 pt-4 border-t border-red-200">
          <span class="badge badge-danger animate-pulse">⚠️ Immediate action required</span>
        </div>
      </div>

      <!-- Low Stock Card -->
      <div class="stat-card stat-card-orange cursor-pointer hover:scale-105 transition-all duration-300"
           :class="{ 'ring-4 ring-orange-400 shadow-2xl': activeFilter === 'low_stock' }"
           @click="setFilter('low_stock')">
        <div class="flex items-center justify-between">
          <div>
            <div class="stat-value text-orange-600">{{ counts.low_stock }}</div>
            <div class="stat-label text-orange-700">Low Stock / ዝቅተኛ</div>
          </div>
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg">
            <span class="text-3xl">📉</span>
          </div>
        </div>
        <div v-if="counts.low_stock > 0" class="mt-4 pt-4 border-t border-orange-200">
          <span class="badge badge-warning">📦 Reorder soon</span>
        </div>
      </div>

      <!-- Expiring Soon Card -->
      <div class="stat-card stat-card-orange cursor-pointer hover:scale-105 transition-all duration-300"
           :class="{ 'ring-4 ring-yellow-400 shadow-2xl': activeFilter === 'expiring_soon' }"
           @click="setFilter('expiring_soon')">
        <div class="flex items-center justify-between">
          <div>
            <div class="stat-value text-yellow-600">{{ counts.expiring_soon }}</div>
            <div class="stat-label text-yellow-700">Expiring Soon / ሊያልቅ</div>
          </div>
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shadow-lg">
            <span class="text-3xl">📅</span>
          </div>
        </div>
        <div v-if="counts.expiring_soon > 0" class="mt-4 pt-4 border-t border-yellow-200">
          <span class="badge badge-warning">⏰ Check expiry dates</span>
        </div>
      </div>

      <!-- Expired Card -->
      <div class="stat-card stat-card-red cursor-pointer hover:scale-105 transition-all duration-300"
           :class="{ 'ring-4 ring-red-400 shadow-2xl': activeFilter === 'expired' }"
           @click="setFilter('expired')">
        <div class="flex items-center justify-between">
          <div>
            <div class="stat-value text-red-600">{{ counts.expired }}</div>
            <div class="stat-label text-red-700">Expired / ያለፈበት</div>
          </div>
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
            <span class="text-3xl">❌</span>
          </div>
        </div>
        <div v-if="counts.expired > 0" class="mt-4 pt-4 border-t border-red-200">
          <span class="badge badge-danger">🗑️ Remove from inventory</span>
        </div>
      </div>
    </div>

    <!-- Filter Indicator -->
    <div v-if="activeFilter" class="card mb-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="text-gray-600 font-medium">Filtering by:</span>
        <span class="px-4 py-2 rounded-xl text-sm font-bold" :class="filterBadgeClass">
          {{ filterLabel }}
        </span>
        <span class="text-gray-500 text-sm">({{ filteredCount }} items)</span>
      </div>
      <button @click="clearFilter" class="btn btn-ghost text-red-500 hover:bg-red-50">
        ✕ Clear Filter
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="card text-center py-16">
      <div class="loading-spinner loading-spinner-lg mx-auto mb-4"></div>
      <p class="text-gray-500 font-medium">Loading stock alerts...</p>
    </div>
    
    <div v-else>
      <!-- No Alerts Message -->
      <div v-if="!hasAnyAlerts" class="card text-center py-16">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center mx-auto mb-6 shadow-lg">
          <span class="text-6xl">✅</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">No active alerts. All stock levels are healthy!</h3>
        <p class="text-gray-500 text-lg mb-2">ምንም ማስጠንቀቂያ የለም። ሁሉም እቃዎች በጥሩ ሁኔታ ላይ ናቸው!</p>
        <div class="Smart-border w-32 mx-auto my-6"></div>
        <div class="flex items-center justify-center gap-4">
          <router-link to="/admin/products" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
            📦 View Products
          </router-link>
          <button @click="generateAlerts" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 via-emerald-500 to-green-600 hover:from-green-600 hover:via-emerald-600 hover:to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
            🔄 Scan Again
          </button>
        </div>
      </div>

      <!-- Out of Stock Section -->
      <div v-if="showSection('out_of_stock') && grouped.out_of_stock.length" class="table-container mb-6 animate-slide-up">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100 flex items-center justify-between">
          <h3 class="text-lg font-bold text-red-700 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center text-white shadow-lg">🚨</span>
            Out of Stock Items ({{ grouped.out_of_stock.length }})
          </h3>
          <div class="flex items-center gap-2">
            <button @click="resolveAllByType('out_of_stock')" class="btn btn-sm btn-ghost text-red-600 hover:bg-red-100">
              ✓ Resolve All
            </button>
          </div>
        </div>
        <table class="table-modern">
          <thead>
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th>Category</th>
              <th>Stock</th>
              <th>Reorder Level</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="alert in grouped.out_of_stock" :key="alert.id">
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center shadow">
                    <span class="text-2xl">📦</span>
                  </div>
                  <div>
                    <p class="font-bold text-gray-800">{{ alert.product?.name }}</p>
                    <p class="text-xs text-gray-500">{{ alert.product?.description?.substring(0, 35) }}...</p>
                  </div>
                </div>
              </td>
              <td><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ alert.product?.sku || 'N/A' }}</span></td>
              <td><span class="badge badge-gray">{{ alert.product?.category?.name }}</span></td>
              <td>
                <span class="px-4 py-2 rounded-xl bg-red-500 text-white font-bold shadow-lg">
                  {{ alert.product?.quantity || 0 }}
                </span>
              </td>
              <td class="text-gray-600 font-medium">{{ alert.product?.reorder_level }}</td>
              <td>
                <span class="badge badge-danger flex items-center gap-1 w-fit">
                  <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                  Out of Stock
                </span>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <button @click="openRestockModal(alert.product)" class="btn btn-sm btn-primary">
                    📝 Restock
                  </button>
                  <button @click="editProduct(alert.product?.id)" class="btn btn-sm btn-secondary">
                    ✏️ Edit
                  </button>
                  <button @click="resolveAlert(alert.id)" class="btn btn-sm btn-success">
                    ✓
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Low Stock Section -->
      <div v-if="showSection('low_stock') && grouped.low_stock.length" class="table-container mb-6 animate-slide-up">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100 flex items-center justify-between">
          <h3 class="text-lg font-bold text-orange-700 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg">📉</span>
            Low Stock Items ({{ grouped.low_stock.length }})
          </h3>
          <div class="flex items-center gap-2">
            <button @click="resolveAllByType('low_stock')" class="btn btn-sm btn-ghost text-orange-600 hover:bg-orange-100">
              ✓ Resolve All
            </button>
          </div>
        </div>
        <table class="table-modern">
          <thead>
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th>Category</th>
              <th>Current Stock</th>
              <th>Reorder Level</th>
              <th>Stock Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="alert in grouped.low_stock" :key="alert.id">
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center shadow">
                    <span class="text-2xl">📦</span>
                  </div>
                  <div>
                    <p class="font-bold text-gray-800">{{ alert.product?.name }}</p>
                    <p class="text-xs text-gray-500">{{ alert.product?.description?.substring(0, 35) }}...</p>
                  </div>
                </div>
              </td>
              <td><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ alert.product?.sku || 'N/A' }}</span></td>
              <td><span class="badge badge-gray">{{ alert.product?.category?.name }}</span></td>
              <td>
                <span class="px-4 py-2 rounded-xl bg-orange-500 text-white font-bold shadow-lg">
                  {{ alert.product?.quantity }}
                </span>
              </td>
              <td class="text-gray-600 font-medium">{{ alert.product?.reorder_level }}</td>
              <td>
                <div class="w-32">
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-orange-600 font-medium">Low</span>
                    <span class="text-gray-500">{{ getStockPercentage(alert.product?.quantity, alert.product?.reorder_level) }}%</span>
                  </div>
                  <div class="progress">
                    <div class="progress-bar-warning" :style="{ width: getStockPercentage(alert.product?.quantity, alert.product?.reorder_level) + '%' }"></div>
                  </div>
                </div>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <button @click="openRestockModal(alert.product)" class="btn btn-sm btn-primary">
                    📝 Restock
                  </button>
                  <button @click="editProduct(alert.product?.id)" class="btn btn-sm btn-secondary">
                    ✏️ Edit
                  </button>
                  <button @click="resolveAlert(alert.id)" class="btn btn-sm btn-success">
                    ✓
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Expiring Soon Section -->
      <div v-if="showSection('expiring_soon') && grouped.expiring_soon.length" class="table-container mb-6 animate-slide-up">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-amber-100 flex items-center justify-between">
          <h3 class="text-lg font-bold text-yellow-700 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-yellow-500 flex items-center justify-center text-white shadow-lg">📅</span>
            Expiring Soon - FIFO Alert ({{ grouped.expiring_soon.length }})
          </h3>
          <div class="flex items-center gap-2">
            <button @click="resolveAllByType('expiring_soon')" class="btn btn-sm btn-ghost text-yellow-600 hover:bg-yellow-100">
              ✓ Resolve All
            </button>
          </div>
        </div>
        <table class="table-modern">
          <thead>
            <tr>
              <th>Product</th>
              <th>Batch #</th>
              <th>Expiry Date</th>
              <th>Days Left</th>
              <th>Quantity</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="alert in grouped.expiring_soon" :key="alert.id">
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-100 to-amber-200 flex items-center justify-center shadow">
                    <span class="text-2xl">📦</span>
                  </div>
                  <div>
                    <p class="font-bold text-gray-800">{{ alert.product?.name }}</p>
                    <p class="text-xs text-gray-500">{{ alert.product?.category?.name }}</p>
                  </div>
                </div>
              </td>
              <td><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ alert.product?.batch_number || 'N/A' }}</span></td>
              <td class="text-yellow-700 font-bold">{{ formatDate(alert.product?.expiry_date) }}</td>
              <td>
                <span class="px-4 py-2 rounded-xl bg-yellow-500 text-white font-bold shadow-lg animate-pulse">
                  {{ getDaysUntilExpiry(alert.product?.expiry_date) }} days
                </span>
              </td>
              <td class="font-bold text-gray-700">{{ alert.product?.quantity }}</td>
              <td>
                <span class="badge badge-warning flex items-center gap-1 w-fit">
                  <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                  Expiring Soon
                </span>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <button @click="applyDiscount(alert.product)" class="btn btn-sm btn-warning">
                    🏷️ Discount
                  </button>
                  <button @click="editProduct(alert.product?.id)" class="btn btn-sm btn-secondary">
                    ✏️ Edit
                  </button>
                  <button @click="resolveAlert(alert.id)" class="btn btn-sm btn-success">
                    ✓
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Expired Section -->
      <div v-if="showSection('expired') && grouped.expired.length" class="table-container mb-6 animate-slide-up">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100 flex items-center justify-between">
          <h3 class="text-lg font-bold text-red-700 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center text-white shadow-lg">❌</span>
            Expired Items - Remove from Sale ({{ grouped.expired.length }})
          </h3>
          <div class="flex items-center gap-2">
            <button @click="resolveAllByType('expired')" class="btn btn-sm btn-ghost text-red-600 hover:bg-red-100">
              ✓ Resolve All
            </button>
          </div>
        </div>
        <table class="table-modern">
          <thead>
            <tr>
              <th>Product</th>
              <th>Batch #</th>
              <th>Expired On</th>
              <th>Days Expired</th>
              <th>Quantity</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="alert in grouped.expired" :key="alert.id">
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center shadow">
                    <span class="text-2xl">📦</span>
                  </div>
                  <div>
                    <p class="font-bold text-gray-800">{{ alert.product?.name }}</p>
                    <p class="text-xs text-gray-500">{{ alert.product?.category?.name }}</p>
                  </div>
                </div>
              </td>
              <td><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ alert.product?.batch_number || 'N/A' }}</span></td>
              <td class="text-red-700 font-bold">{{ formatDate(alert.product?.expiry_date) }}</td>
              <td>
                <span class="px-4 py-2 rounded-xl bg-red-500 text-white font-bold shadow-lg">
                  {{ getDaysExpired(alert.product?.expiry_date) }} days ago
                </span>
              </td>
              <td class="font-bold text-gray-700">{{ alert.product?.quantity }}</td>
              <td>
                <span class="badge badge-danger flex items-center gap-1 w-fit">
                  ⛔ Expired
                </span>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <button @click="disposeProduct(alert)" class="btn btn-sm btn-danger">
                    🗑️ Dispose
                  </button>
                  <button @click="editProduct(alert.product?.id)" class="btn btn-sm btn-secondary">
                    ✏️ Edit
                  </button>
                  <button @click="resolveAlert(alert.id)" class="btn btn-sm btn-success">
                    ✓
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Restock Modal -->
    <div v-if="showRestockModal" class="modal-overlay" @click.self="closeRestockModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">📦</span>
            Restock Product
          </h3>
        </div>
        <div class="modal-body">
          <div v-if="restockProduct" class="mb-6">
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
              <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                <span class="text-3xl">📦</span>
              </div>
              <div>
                <p class="font-bold text-gray-800 text-lg">{{ restockProduct.name }}</p>
                <p class="text-sm text-gray-500">SKU: {{ restockProduct.sku || 'N/A' }}</p>
                <p class="text-sm text-gray-500">Current Stock: <span class="font-bold text-red-600">{{ restockProduct.quantity || 0 }}</span></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="form-label form-label-required">Quantity to Add</label>
              <input 
                v-model.number="restockQuantity" 
                type="number" 
                min="1" 
                class="input"
                :placeholder="t('common.enterQuantity')"
              />
              <p class="form-hint">New total will be: <span class="font-bold text-green-600">{{ (restockProduct.quantity || 0) + restockQuantity }}</span> units</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeRestockModal" class="btn btn-secondary">
            Cancel
          </button>
          <button @click="submitRestock" class="btn btn-primary" :disabled="restockLoading || restockQuantity <= 0">
            <span v-if="restockLoading" class="animate-spin">⏳</span>
            <span v-else>✓</span>
            {{ restockLoading ? 'Restocking...' : 'Confirm Restock' }}
          </button>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { advancedApi, productsApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'

const router = useRouter()
const toast = useToastStore()
const { t } = useTranslation()
const loading = ref(true)
const generating = ref(false)
const alerts = ref([])
const grouped = ref({ out_of_stock: [], low_stock: [], expiring_soon: [], expired: [] })
const counts = ref({ out_of_stock: 0, low_stock: 0, expiring_soon: 0, expired: 0, total: 0 })
const activeFilter = ref(null)

// Restock Modal
const showRestockModal = ref(false)
const restockProduct = ref(null)
const restockQuantity = ref(0)
const restockLoading = ref(false)

// Computed properties
const hasAnyAlerts = computed(() => counts.value.total > 0)

const filteredCount = computed(() => {
  if (!activeFilter.value) return counts.value.total
  return grouped.value[activeFilter.value]?.length || 0
})

const filterLabel = computed(() => {
  const labels = {
    out_of_stock: '🚨 Out of Stock',
    low_stock: '📉 Low Stock',
    expiring_soon: '📅 Expiring Soon',
    expired: '❌ Expired'
  }
  return labels[activeFilter.value] || ''
})

const filterBadgeClass = computed(() => {
  const classes = {
    out_of_stock: 'bg-red-100 text-red-700 border-2 border-red-300',
    low_stock: 'bg-orange-100 text-orange-700 border-2 border-orange-300',
    expiring_soon: 'bg-yellow-100 text-yellow-700 border-2 border-yellow-300',
    expired: 'bg-red-100 text-red-700 border-2 border-red-300'
  }
  return classes[activeFilter.value] || ''
})

// Methods
const setFilter = (type) => {
  activeFilter.value = activeFilter.value === type ? null : type
}

const clearFilter = () => {
  activeFilter.value = null
}

const showSection = (type) => {
  return !activeFilter.value || activeFilter.value === type
}

const fetchAlerts = async () => {
  loading.value = true
  try {
    const response = await advancedApi.stockAlerts()
    alerts.value = response.data.alerts || []
    grouped.value = response.data.grouped || { out_of_stock: [], low_stock: [], expiring_soon: [], expired: [] }
    counts.value = response.data.counts || { out_of_stock: 0, low_stock: 0, expiring_soon: 0, expired: 0, total: 0 }
  } catch (e) {
    toast.error('Failed to load stock alerts')
    console.error(e)
  } finally {
    loading.value = false
  }
}

const generateAlerts = async () => {
  generating.value = true
  try {
    await fetchAlerts()
    toast.success('Stock scan completed successfully!')
  } catch (e) {
    toast.error('Failed to scan products')
  } finally {
    generating.value = false
  }
}

const resolveAlert = async (id) => {
  try {
    await advancedApi.resolveAlert(id)
    toast.success('Alert resolved successfully')
    fetchAlerts()
  } catch (e) {
    toast.error('Failed to resolve alert')
  }
}

const resolveAllByType = async (type) => {
  const alertsToResolve = grouped.value[type] || []
  if (!alertsToResolve.length) return
  
  try {
    for (const alert of alertsToResolve) {
      await advancedApi.resolveAlert(alert.id)
    }
    toast.success(`All ${type.replace(/_/g, ' ')} alerts resolved!`)
    fetchAlerts()
  } catch (e) {
    toast.error('Failed to resolve alerts')
  }
}

// Restock functionality
const openRestockModal = (product) => {
  restockProduct.value = product
  restockQuantity.value = product.reorder_level || 10
  showRestockModal.value = true
}

const closeRestockModal = () => {
  showRestockModal.value = false
  restockProduct.value = null
  restockQuantity.value = 0
}

const submitRestock = async () => {
  if (!restockProduct.value || restockQuantity.value <= 0) return
  
  restockLoading.value = true
  try {
    const newQuantity = (restockProduct.value.quantity || 0) + restockQuantity.value
    await productsApi.update(restockProduct.value.id, { quantity: newQuantity })
    toast.success(`Successfully restocked ${restockProduct.value.name} with ${restockQuantity.value} units!`)
    closeRestockModal()
    fetchAlerts()
  } catch (e) {
    toast.error('Failed to restock product')
  } finally {
    restockLoading.value = false
  }
}

// Navigate to product edit
const editProduct = (productId) => {
  router.push(`/admin/products?edit=${productId}`)
}

// Apply discount
const applyDiscount = async (product) => {
  toast.info(`Opening discount settings for ${product.name}...`)
  router.push(`/admin/products?edit=${product.id}&discount=true`)
}

// Dispose expired product
const disposeProduct = async (alert) => {
  if (!confirm(`Are you sure you want to dispose ${alert.product?.name}? This will set quantity to 0.`)) return
  
  try {
    await productsApi.update(alert.product.id, { quantity: 0, status: 'disposed' })
    await advancedApi.resolveAlert(alert.id)
    toast.success(`${alert.product.name} has been disposed`)
    fetchAlerts()
  } catch (e) {
    toast.error('Failed to dispose product')
  }
}

// Export alerts
const exportAlerts = () => {
  const data = {
    exported_at: new Date().toISOString(),
    summary: counts.value,
    alerts: grouped.value
  }
  const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `stock-alerts-${new Date().toISOString().split('T')[0]}.json`
  a.click()
  URL.revokeObjectURL(url)
  toast.success('Alerts exported successfully!')
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-ET', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const getDaysUntilExpiry = (date) => {
  if (!date) return 0
  const expiry = new Date(date)
  const today = new Date()
  const diff = Math.ceil((expiry - today) / (1000 * 60 * 60 * 24))
  return Math.max(0, diff)
}

const getDaysExpired = (date) => {
  if (!date) return 0
  const expiry = new Date(date)
  const today = new Date()
  const diff = Math.ceil((today - expiry) / (1000 * 60 * 60 * 24))
  return Math.max(0, diff)
}

const getStockPercentage = (current, reorder) => {
  if (!reorder || reorder === 0) return 0
  return Math.min(100, Math.round((current / reorder) * 100))
}

onMounted(fetchAlerts)
</script>
