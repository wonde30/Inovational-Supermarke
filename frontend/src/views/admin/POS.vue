<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary POS Header -->
    <div class="relative z-10 mb-6">
      <div class="relative group">
        <!-- 3D Background Layer -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-105 shadow-2xl"></div>
        
        <!-- Main Content Layer -->
        <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-6 text-white shadow-2xl overflow-hidden border border-white/20 mx-4 mt-4">
          <!-- Animated Mesh Background -->
          <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
          </div>
          
          <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-4">
              <!-- 3D POS Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">💰</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart POS System / የሽያጭ ስርዓት
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📅</span>
                  <span>{{ currentDate }}</span>
                  <span class="mx-2">•</span>
                  <span>💵</span>
                  <span>Advanced Cash Management</span>
                </p>
              </div>
            </div>
            
            <!-- Live Stats -->
            <div class="flex items-center gap-4">
              <div class="text-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                <p class="text-2xl font-black">{{ cart.items.length }}</p>
                <p class="text-xs text-green-100 font-bold">Items</p>
              </div>
              <div class="text-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                <p class="text-2xl font-black">ETB {{ formatCurrency(cart.total) }}</p>
                <p class="text-xs text-green-100 font-bold">Total</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4">
      <div class="pos-layout">
        <!-- Left: Revolutionary Products Section -->
        <div class="pos-products-section">
          <!-- Enhanced Search & Filter Bar -->
          <div class="group relative transform transition-all duration-500 hover:scale-105 mb-6">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl p-4 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
              <div class="flex gap-4">
                <div class="flex-1 relative group/search">
                  <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-blue-600 transition-colors">
                    <span class="text-2xl">🔍</span>
                  </div>
                  <input 
                    v-model="search" 
                    type="text" 
                    class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                    :placeholder="t('pos.scanBarcode') + ' or search products...'" 
                  />
                </div>
                <div class="relative group/category">
                  <select 
                    v-model="categoryFilter" 
                    class="appearance-none pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg" style="min-width: 200px;"
                  >
                    <option value="">{{ t('storefront.allCategories') }}</option>
                    <option v-for="cat in categoryOptions" :key="cat.value" :value="cat.value">{{ cat.label }}</option>
                  </select>
                  <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/category:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Revolutionary Products Grid -->
          <div class="pos-products-grid">
            <div 
              v-for="product in filteredProducts" 
              :key="product.id" 
              @click="addToCart(product)"
              class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
              :class="{ 'opacity-60 cursor-not-allowed': product.quantity <= 0 }"
            >
              <!-- 3D Shadow Layer -->
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
              
              <!-- Main Product Card -->
              <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all flex flex-col" style="min-height: 280px;">
                <!-- Enhanced Product Image -->
                <div class="relative h-40 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
                  <img :src="getImageUrl(product.image)" :alt="product.name" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500" />
                  
                  <!-- Enhanced Status Badges -->
                  <div class="absolute top-3 right-3 space-y-1">
                    <span v-if="product.quantity <= 5 && product.quantity > 0" class="block px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                      ⚠️ Low Stock
                    </span>
                    <span v-if="product.quantity <= 0" class="block px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg">
                      ❌ Out of Stock
                    </span>
                    <span v-else class="block px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold rounded-full shadow-lg">
                      ✅ Available
                    </span>
                  </div>
                  
                  <!-- Hover Overlay -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-transform">
                      <span class="text-2xl">🛒</span>
                    </div>
                  </div>
                </div>

                <!-- Enhanced Product Details -->
                <div class="p-4 bg-gradient-to-br from-white to-gray-50 flex-1 flex flex-col">
                  <!-- Product Name -->
                  <h3 class="font-black text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-green-600 transition-colors" style="min-height: 3.5rem;">
                    {{ product.name }}
                  </h3>
                  
                  <!-- Price Section -->
                  <div class="flex items-baseline justify-between mb-3">
                    <span class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                      ETB {{ formatCurrency(product.price) }}
                    </span>
                    <div class="text-right">
                      <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <span class="text-xl">⭐</span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Stock Info -->
                  <div class="mt-auto pt-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                      <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full animate-pulse" :class="product.quantity > 5 ? 'bg-green-500' : product.quantity > 0 ? 'bg-yellow-500' : 'bg-red-500'"></span>
                        <span class="text-sm font-bold text-gray-600">
                          {{ product.quantity > 0 ? `${product.quantity} in stock` : 'Out of stock' }}
                        </span>
                      </div>
                      <div v-if="product.quantity > 0" class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                        Quick Add
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Empty State -->
            <div v-if="filteredProducts.length === 0" class="col-span-full py-20 text-center">
              <div class="relative inline-block mb-6">
                <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
                  <span class="text-6xl">🔍</span>
                </div>
              </div>
              <p class="text-2xl font-black text-gray-700 mb-2">{{ t('messages.noDataFound') }}</p>
              <p class="text-gray-500 font-medium">Try adjusting your search or category filter</p>
            </div>
          </div>
        </div>

      <!-- Right: Modern Cart Panel -->
      <div class="bg-white rounded-2xl border-2 border-gray-200 shadow-xl flex flex-col overflow-hidden">
        <!-- Cart Header -->
        <div class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 flex justify-between items-center">
          <h3 class="flex items-center gap-2 text-base font-bold text-white">
            🛒 {{ t('pos.cart') }}
            <span v-if="cart.items.length" class="bg-white text-green-600 text-xs px-2 py-0.5 rounded-full font-bold">{{ cart.items.length }}</span>
          </h3>
          <button v-if="cart.items.length" @click="clearCartWithConfirmation" class="text-white hover:text-red-200 text-sm font-semibold transition-colors">{{ t('pos.clearCart') }}</button>
        </div>

        <!-- Cart Items List -->
        <div class="flex-1 overflow-y-auto p-2 bg-gray-50">
          <div v-if="cart.items.length === 0" class="text-center py-8 text-gray-400">
            <p class="text-4xl mb-2">🛒</p>
            <p class="font-semibold">{{ t('pos.emptyCart') }}</p>
            <p class="text-xs mt-1">{{ t('pos.addToCart') }}</p>
          </div>

          <div v-for="(item, index) in cart.items" :key="item.id" class="bg-white rounded-lg p-2 mb-2 border border-gray-200 hover:border-green-300 transition-all">
            <div class="flex items-center gap-2">
              <span class="w-5 h-5 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-xs font-bold">{{ index + 1 }}</span>
              <div class="w-10 h-10 bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                <img :src="getImageUrl(item.image)" :alt="item.name" class="w-full h-full object-contain" />
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-bold text-xs text-gray-800 truncate">{{ item.name }}</p>
                <p class="text-xs text-gray-500">ETB {{ formatCurrency(item.price) }} each</p>
              </div>
              <button @click="removeItemWithAnimation(item.id)" class="w-6 h-6 rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white font-bold transition-all flex items-center justify-center text-sm">×</button>
            </div>
            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
              <div class="flex items-center gap-1.5">
                <button @click="updateQuantityWithAnimation(item.id, item.quantity - 1)" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-green-600 hover:text-white font-bold transition-all flex items-center justify-center text-sm">−</button>
                <span class="w-8 text-center font-bold text-gray-800 text-sm">{{ item.quantity }}</span>
                <button @click="updateQuantityWithAnimation(item.id, item.quantity + 1)" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-green-600 hover:text-white font-bold transition-all flex items-center justify-center text-sm">+</button>
              </div>
              <p class="font-bold text-base text-green-600">{{ formatCurrency(item.price * item.quantity) }}</p>
            </div>
          </div>
        </div>

        <!-- Modern Cart Summary & Checkout -->
        <div class="p-3 bg-white border-t-2 border-gray-200">
          <!-- Totals -->
          <div class="space-y-1.5 mb-3">
            <div class="flex justify-between text-xs text-gray-600">
              <span>{{ t('pos.subtotal') }} ({{ cart.items.length }} {{ t('sales.items') }})</span>
              <span class="font-semibold">ETB {{ formatCurrency(cart.subtotal) }}</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
              <span>{{ t('pos.tax') }} (15%)</span>
              <span class="font-semibold">ETB {{ formatCurrency(cart.tax) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg p-2.5 shadow-lg">
              <span>{{ t('pos.total').toUpperCase() }}</span>
              <span>ETB {{ formatCurrency(cart.total) }}</span>
            </div>
          </div>

          <!-- Payment Options -->
          <div class="mb-2.5">
            <label class="form-label text-xs uppercase tracking-wide">{{ t('pos.paymentMethod') }}</label>
            <div class="grid grid-cols-4 gap-1.5">
              <label v-for="opt in paymentOptions" :key="opt.value" class="flex flex-col items-center p-1.5 border-2 rounded-lg cursor-pointer transition-all" :class="paymentMethod === opt.value ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300 bg-white'">
                <input type="radio" v-model="paymentMethod" :value="opt.value" class="hidden" />
                <span class="text-xl mb-0.5">{{ opt.icon }}</span>
                <span class="text-xs font-medium text-gray-700">{{ opt.label }}</span>
              </label>
            </div>
          </div>

          <!-- Advanced Cash Management (Show only for cash payments) -->
          <div v-if="paymentMethod === 'cash'" class="space-y-3 p-3 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border-2 border-yellow-200 mb-3">
            <div class="flex items-center gap-2 mb-2">
              <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                <span class="text-white text-sm">💵</span>
              </div>
              <h4 class="text-sm font-black text-gray-900">Cash Management / ገንዘብ አያያዝ</h4>
            </div>
            
            <!-- Cash Received Input -->
            <div class="space-y-2">
              <label class="block text-xs font-bold text-gray-700">Cash Received / የተቀበለ ገንዘብ</label>
              <div class="relative">
                <input 
                  v-model="cashReceived" 
                  @input="calculateChange"
                  type="number" 
                  step="0.01"
                  min="0"
                  class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all outline-none text-sm font-bold text-center bg-white" 
                  placeholder="0.00"
                />
                <div class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-bold">ETB</div>
              </div>
              
              <!-- Quick Cash Buttons -->
              <div class="grid grid-cols-4 gap-1">
                <button v-for="amount in quickCashAmounts" :key="amount" @click="setQuickCash(amount)" class="px-2 py-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white rounded text-xs font-bold transition-all shadow-sm hover:scale-105">
                  {{ amount }}
                </button>
              </div>
            </div>
            
            <!-- Change Calculation -->
            <div v-if="cashReceived && parseFloat(cashReceived) > 0" class="space-y-2">
              <div class="flex justify-between items-center p-2 rounded-lg" :class="changeAmount >= 0 ? 'bg-gradient-to-r from-green-100 to-emerald-100 border border-green-200' : 'bg-gradient-to-r from-red-100 to-red-200 border border-red-200'">
                <span class="text-xs font-bold flex items-center gap-1" :class="changeAmount >= 0 ? 'text-green-700' : 'text-red-700'">
                  <span>{{ changeAmount >= 0 ? '💰' : '⚠️' }}</span>
                  <span>{{ changeAmount >= 0 ? 'Change' : 'Insufficient' }}</span>
                </span>
                <span class="text-sm font-black" :class="changeAmount >= 0 ? 'text-green-700' : 'text-red-700'">
                  ETB {{ formatCurrency(Math.abs(changeAmount)) }}
                </span>
              </div>
              
              <!-- Change Breakdown (if change > 0) -->
              <div v-if="changeAmount > 0" class="p-2 bg-white rounded-lg border border-gray-200 text-xs">
                <h5 class="font-bold text-gray-700 mb-1 flex items-center gap-1">
                  <span>🏦</span>
                  <span>Change Breakdown</span>
                </h5>
                <div class="grid grid-cols-2 gap-1">
                  <div v-for="(count, denomination) in changeBreakdown" :key="denomination" v-if="count > 0" class="flex justify-between items-center p-1 bg-gray-50 rounded text-xs">
                    <span class="text-gray-600">ETB {{ denomination }}</span>
                    <span class="font-bold text-gray-900">{{ count }}x</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Customer Name -->
          <input v-model="customerName" type="text" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none text-sm mb-3" :placeholder="t('customers.customerName') + ' (' + t('common.optional') + ')'" />

          <!-- Complete Sale Button -->
          <button 
            @click="completeSaleWithAnimation" 
            :disabled="cart.items.length === 0 || processing || (paymentMethod === 'cash' && changeAmount < 0)"
            class="w-full py-4 rounded-xl border-none bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-lg font-bold cursor-pointer flex items-center justify-center gap-3 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed hover:-translate-y-0.5"
          >
            <span v-if="processing" class="loading-spinner w-5 h-5"></span>
            <span v-else class="text-2xl">✅</span>
            <span>{{ processing ? 'Processing Sale...' : 'Complete Sale / ሽያጭ ጨርስ' }}</span>
          </button>
        </div>
      </div>
    </div>
    </div>

    <!-- Receipt Modal -->
    <Modal v-model="showReceipt" :title="t('pos.printReceipt')">
      <div id="receipt" class="receipt">
        <div class="receipt-header">
          <h2 class="text-xl font-bold">🏪 IBMS Store</h2>
          <p class="text-gray-500">Your City</p>
          <p class="text-gray-500">Tel: +251-XXX-XXXXXX</p>
          <div class="Smart-border mt-3 rounded-full"></div>
        </div>
        <div class="py-3 space-y-1 text-sm">
          <div class="flex justify-between"><span class="text-gray-500">{{ t('orders.orderNumber') }}:</span><span class="font-bold">{{ lastSale?.invoice_number }}</span></div>
          <div class="flex justify-between"><span class="text-gray-500">{{ t('common.date') }}:</span><span>{{ formatDateTime(lastSale?.created_at) }}</span></div>
          <div class="flex justify-between"><span class="text-gray-500">{{ t('users.cashier') }}:</span><span>{{ lastSale?.user?.name || 'Admin' }}</span></div>
        </div>
        <table class="w-full my-3 text-sm">
          <thead><tr class="border-b-2 border-dashed"><th class="text-left py-2">{{ t('sales.items') }}</th><th class="text-center py-2">{{ t('pos.quantity') }}</th><th class="text-right py-2">{{ t('pos.total') }}</th></tr></thead>
          <tbody>
            <tr v-for="item in lastSale?.items" :key="item.id" class="border-b border-dashed">
              <td class="py-2">{{ item.product?.name || item.name }}</td>
              <td class="text-center py-2">{{ item.quantity }}</td>
              <td class="text-right py-2 font-semibold">{{ formatCurrency(item.quantity * item.price) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="space-y-1 py-3 border-t-2 border-dashed text-sm">
          <div class="flex justify-between"><span>{{ t('pos.subtotal') }}:</span><span>ETB {{ formatCurrency(lastSale?.subtotal) }}</span></div>
          <div class="flex justify-between"><span>{{ t('pos.tax') }} (15%):</span><span>ETB {{ formatCurrency(lastSale?.tax) }}</span></div>
          <div class="flex justify-between text-lg font-bold pt-2 border-t border-dashed"><span>{{ t('pos.total') }}:</span><span>ETB {{ formatCurrency(lastSale?.total) }}</span></div>
        </div>
        <div class="text-center pt-4 border-t-2 border-dashed text-sm text-gray-500">
          <p class="font-semibold">{{ t('storefront.thankYou') }} 🙏</p>
        </div>
      </div>
      <template #footer>
        <button @click="printReceipt" class="btn btn-primary"><span>🖨️</span> {{ t('common.print') }}</button>
        <button @click="showReceipt = false" class="btn btn-secondary">{{ t('common.close') }}</button>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { productsApi, categoriesApi, salesApi } from '../../services/api'
import { useCartStore } from '../../stores/cart'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '@/composables/useTranslation'
import Modal from '../../components/Modal.vue'

const { t } = useTranslation()
const cart = useCartStore()
const toast = useToastStore()

const products = ref([])
const search = ref('')
const categoryFilter = ref('')
const currentDate = ref(new Date().toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' }))
const categoryOptions = ref([])
const paymentMethod = ref('cash')
const customerName = ref('')
const processing = ref(false)
const showReceipt = ref(false)
const lastSale = ref(null)

const paymentOptions = computed(() => [
  { value: 'cash', label: t('pos.cash'), icon: '💵' }, 
  { value: 'mobile_banking', label: t('pos.mobileMoney'), icon: '📱' },
  { value: 'bank_transfer', label: t('pos.card'), icon: '💳' },
  { value: 'credit', label: 'Credit', icon: '📝' }
])

const filteredProducts = computed(() => {
  return products.value.filter(p => {
    const matchSearch = p.name.toLowerCase().includes(search.value.toLowerCase())
    const matchCategory = !categoryFilter.value || p.category_id == categoryFilter.value
    return matchSearch && matchCategory
  })
})

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const getImageUrl = (image) => {
  if (!image) return '/images/products/default.jpg'
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `/storage/${image}`
}
const formatDateTime = (date) => date ? new Date(date).toLocaleString('en-ET', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''

const addToCart = (product) => {
  if (product.quantity > 0) {
    cart.addItem(product)
    toast.success(t('messages.itemAddedToCart'))
  } else {
    toast.error(t('products.outOfStock'))
  }
}

const printReceipt = () => {
  const content = document.getElementById('receipt').innerHTML
  const win = window.open('', '_blank')
  win.document.write(`<html><head><title>${t('pos.printReceipt')}</title><style>body{font-family:monospace;font-size:12px;width:80mm;margin:0 auto;padding:10px}table{width:100%;border-collapse:collapse}th,td{padding:4px 2px}.text-center{text-align:center}.text-right{text-align:right}.font-bold{font-weight:bold}</style></head><body>${content}</body></html>`)
  win.document.close()
  win.print()
}

// Advanced Cash Management
const cashReceived = ref('')
const changeAmount = computed(() => {
  const cash = parseFloat(cashReceived.value) || 0
  return cash - cart.total
})

const quickCashAmounts = computed(() => {
  const total = cart.total
  const amounts = []
  
  // Add exact amount
  amounts.push(Math.ceil(total))
  
  // Add common denominations above total
  const denominations = [50, 100, 200, 500, 1000]
  denominations.forEach(amount => {
    if (amount > total) amounts.push(amount)
  })
  
  return amounts.slice(0, 4) // Show max 4 quick amounts
})

const changeBreakdown = computed(() => {
  if (changeAmount.value <= 0) return {}
  
  const denominations = [100, 50, 10, 5, 1, 0.5, 0.25, 0.1, 0.05, 0.01]
  let remaining = Math.round(changeAmount.value * 100) / 100
  const breakdown = {}
  
  denominations.forEach(denom => {
    if (remaining >= denom) {
      const count = Math.floor(remaining / denom)
      if (count > 0) {
        breakdown[denom] = count
        remaining = Math.round((remaining - (count * denom)) * 100) / 100
      }
    }
  })
  
  return breakdown
})

const calculateChange = () => {
  // Reactive computed property handles this automatically
}

const setQuickCash = (amount) => {
  if (typeof amount === 'number' && amount > 0) {
    cashReceived.value = amount.toString()
    toast.success(`💵 Cash set to ETB ${amount}`)
  }
}

// Enhanced Cart Functions with Animations
const clearCartWithConfirmation = () => {
  if (cart.items.length === 0) {
    toast.info('Cart is already empty')
    return
  }
  
  if (confirm('Are you sure you want to clear the cart?')) {
    cart.clear()
    cashReceived.value = ''
    toast.success('🗑️ Cart cleared successfully')
  }
}

const removeItemWithAnimation = (itemId) => {
  const item = cart.items.find(i => i.id === itemId)
  if (item) {
    cart.removeItem(itemId)
    toast.info(`🗑️ ${item.name} removed from cart`)
  }
}

const updateQuantityWithAnimation = (itemId, newQuantity) => {
  if (newQuantity < 1) {
    removeItemWithAnimation(itemId)
  } else {
    const item = cart.items.find(i => i.id === itemId)
    if (item && newQuantity <= item.maxQuantity) {
      cart.updateQuantity(itemId, newQuantity)
      toast.success(`📊 ${item.name} quantity updated`)
    } else if (item) {
      toast.warning(`⚠️ Only ${item.maxQuantity} items available`)
    }
  }
}

const completeSaleWithAnimation = async () => {
  if (cart.items.length === 0) {
    toast.warning('⚠️ Cart is empty')
    return
  }
  
  if (paymentMethod.value === 'cash' && changeAmount.value < 0) {
    toast.error('💰 Insufficient cash received')
    return
  }
  
  try {
    processing.value = true
    
    // Add cash handling data for cash payments
    const saleData = {
      items: cart.getItemsForApi(),
      payment_method: paymentMethod.value,
      customer_name: customerName.value || 'Walk-in Customer',
      discount: cart.discount,
      tax_rate: 15
    }
    
    // Add cash-specific data
    if (paymentMethod.value === 'cash') {
      saleData.cash_received = parseFloat(cashReceived.value) || 0
      saleData.change_amount = changeAmount.value
      saleData.change_breakdown = changeBreakdown.value
    }
    
    const response = await salesApi.create(saleData)
    lastSale.value = response.data
    showReceipt.value = true
    
    // Success animation and cleanup
    toast.success('🎉 Sale completed successfully!')
    cart.clear()
    customerName.value = ''
    cashReceived.value = ''
    
    // Refresh products to update stock
    fetchProducts()
    
  } catch (e) {
    toast.error(e.message || '❌ Payment failed. Please try again.')
  } finally {
    processing.value = false
  }
}

const fetchProducts = async () => { try { products.value = (await productsApi.getAll({ per_page: 100 })).data } catch (e) {} }
const fetchCategories = async () => { try { categoryOptions.value = (await categoriesApi.getAll()).data.map(c => ({ value: c.id, label: c.name })) } catch (e) {} }

onMounted(() => { fetchProducts(); fetchCategories() })
</script>

<style scoped>
/* Revolutionary POS Styles */
.pos-layout {
  display: grid;
  grid-template-columns: 1fr 420px;
  gap: 1rem;
  height: calc(100vh - 16px);
  max-height: calc(100vh - 16px);
}

.pos-products-section {
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.pos-products-grid {
  flex: 1;
  overflow-y: auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
  gap: 0.875rem;
  padding: 0.5rem;
}

/* Revolutionary Cart Section */
.pos-cart-section {
  background: white;
  border-radius: 1.5rem;
  border: 2px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  position: relative;
}

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
    transform: translateY(-15px) translateX(-8px);
  }
  66% {
    transform: translateY(-8px) translateX(12px);
  }
}

@keyframes bounce-slow {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

@keyframes gradient-xy {
  0%, 100% {
    background-position: 0% 0%;
  }
  25% {
    background-position: 100% 0%;
  }
  50% {
    background-position: 100% 100%;
  }
  75% {
    background-position: 0% 100%;
  }
}

@keyframes particle-rise {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateY(-50px) scale(0);
    opacity: 0;
  }
}

@keyframes wave {
  0%, 100% {
    transform: rotate(0deg);
  }
  25% {
    transform: rotate(20deg);
  }
  75% {
    transform: rotate(-20deg);
  }
}

@keyframes shake {
  0%, 100% {
    transform: translateX(0);
  }
  25% {
    transform: translateX(-5px);
  }
  75% {
    transform: translateX(5px);
  }
}

@keyframes progress {
  0% {
    width: 0%;
  }
  100% {
    width: 75%;
  }
}

/* Animation Classes */
.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 6s ease-in-out infinite 2s;
}

.animate-bounce-slow {
  animation: bounce-slow 2s ease-in-out infinite;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

.animate-gradient-xy {
  background-size: 400% 400%;
  animation: gradient-xy 8s ease infinite;
}

.animate-wave {
  animation: wave 2s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out infinite;
}

.animate-progress {
  animation: progress 1.5s ease-out forwards;
}

.particle-rise {
  animation: particle-rise 2s ease-out infinite;
}

.particle-float {
  animation: float 4s ease-in-out infinite;
}

/* Product Cards */
.product-card {
  background: white !important;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  overflow: visible !important;
  cursor: pointer;
  transition: all 0.2s;
  display: flex !important;
  flex-direction: column !important;
  min-height: 240px;
}

.product-card:hover {
  border-color: #10b981;
  box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
  transform: translateY(-3px);
}

.product-card.out-of-stock {
  opacity: 0.6;
  cursor: not-allowed;
}

.product-image-wrapper {
  position: relative;
  height: 130px;
  background: linear-gradient(135deg, #f9fafb 0%, #ecfdf5 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 12px;
  flex-shrink: 0;
}

.product-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.badge {
  position: absolute;
  top: 6px;
  right: 6px;
  padding: 3px 8px;
  border-radius: 10px;
  font-size: 10px;
  font-weight: bold;
  color: white;
  line-height: 1;
}

.badge-warning {
  background: #f59e0b;
}

.badge-danger {
  background: #ef4444;
}

.product-details {
  padding: 12px !important;
  background: white !important;
  display: flex !important;
  flex-direction: column !important;
  flex: 1;
  min-height: 0;
  visibility: visible !important;
}

.product-name {
  font-size: 14px !important;
  font-weight: 700 !important;
  color: #1f2937 !important;
  line-height: 1.3;
  min-height: 36px;
  max-height: 36px;
  overflow: hidden;
  display: -webkit-box !important;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  margin-bottom: 8px;
}

.product-stock {
  padding-top: 8px;
  border-top: 1px solid #f3f4f6;
  font-size: 11px !important;
  font-weight: 600 !important;
  margin-top: auto;
  line-height: 1.3;
  display: block !important;
}

.stock-out {
  color: #dc2626 !important;
}

.stock-available {
  color: #6b7280 !important;
}

/* Loading Spinner */
.loading-spinner {
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Line Clamp Utility */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Transform 3D */
.transform-3d {
  transform-style: preserve-3d;
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

/* Responsive Design */
@media (max-width: 1024px) {
  .pos-layout {
    grid-template-columns: 1fr;
    height: auto;
  }
  
  .pos-cart-section {
    order: -1;
    max-height: 400px;
  }
  
  .pos-products-grid {
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  }
}

@media (max-width: 768px) {
  .pos-products-grid {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 0.5rem;
  }
  
  .product-card {
    min-height: 200px;
  }
  
  .product-image-wrapper {
    height: 100px;
  }
}

.product-currency {
  font-size: 11px !important;
  color: #9ca3af !important;
  font-weight: 600 !important;
  line-height: 1;
}

.product-stock {
  padding-top: 8px;
  border-top: 1px solid #f3f4f6;
  font-size: 11px !important;
  font-weight: 600 !important;
  margin-top: auto;
  line-height: 1.3;
  display: block !important;
}

.stock-out {
  color: #dc2626 !important;
}

.stock-available {
  color: #6b7280 !important;
}


/* Cart Section */
.pos-cart-section {
  background: white;
  border-radius: 1.5rem;
  border: 2px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.pos-cart-header {
  padding: 1rem 1.25rem;
  border-bottom: 2px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fafbfc;
}

.pos-cart-items {
  flex: 1;
  overflow-y: auto;
  padding: 0.5rem;
  min-height: 100px;
}

.pos-cart-item {
  display: grid;
  grid-template-columns: 24px 48px 1fr auto auto 24px;
  gap: 0.5rem;
  align-items: center;
  padding: 0.6rem;
  margin-bottom: 0.5rem;
  background: #f8fafc;
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
}

.pos-cart-item-num {
  font-size: 0.7rem;
  font-weight: 700;
  color: #94a3b8;
  text-align: center;
}

.pos-cart-item-image {
  width: 48px;
  height: 48px;
  background: white;
  border-radius: 0.5rem;
  overflow: hidden;
  border: 1px solid #e5e7eb;
}

.pos-cart-item-details {
  min-width: 0;
}

.pos-cart-item-qty {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.pos-qty-btn {
  width: 26px;
  height: 26px;
  border-radius: 0.5rem;
  background: white;
  border: 1px solid #e5e7eb;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.15s;
}
.pos-qty-btn:hover {
  background: #16A34A;
  color: white;
  border-color: #16A34A;
}

.pos-qty-value {
  width: 28px;
  text-align: center;
  font-weight: 700;
  font-size: 0.9rem;
}

.pos-cart-item-total {
  text-align: right;
  min-width: 70px;
}

.pos-cart-item-remove {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #fee2e2;
  color: #dc2626;
  border: none;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.15s;
}
.pos-cart-item-remove:hover {
  background: #dc2626;
  color: white;
}

/* Cart Summary */
.pos-cart-summary {
  padding: 0.75rem 1rem;
  border-top: 2px solid #f1f5f9;
  background: #fafbfc;
  flex-shrink: 0;
}

.pos-totals {
  margin-bottom: 0.5rem;
}

.pos-total-row {
  display: flex;
  justify-content: space-between;
  padding: 0.25rem 0;
  font-size: 0.85rem;
  color: #64748b;
}

.pos-grand-total {
  font-size: 1.1rem;
  font-weight: 800;
  color: white;
  background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
  margin: 0.5rem -1rem;
  padding: 0.75rem 1rem;
}

.pos-payment {
  margin-bottom: 0.5rem;
}

.pos-payment-options {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.4rem;
}

.pos-payment-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0.4rem;
  border-radius: 0.5rem;
  border: 2px solid #e5e7eb;
  cursor: pointer;
  transition: all 0.15s;
  background: white;
}
.pos-payment-option:hover {
  border-color: #16A34A;
}
.pos-payment-option.active {
  border-color: #16A34A;
  background: #ecfdf5;
}

.pos-checkout-btn {
  width: 100%;
  padding: 0.75rem;
  border-radius: 0.75rem;
  border: none;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  transition: all 0.2s;
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}
.pos-checkout-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
}
.pos-checkout-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

@media (max-width: 1024px) {
  .pos-layout {
    grid-template-columns: 1fr;
    height: auto;
  }
  .pos-cart-section {
    order: -1;
    max-height: 400px;
  }
  .pos-cart-items {
    max-height: 150px;
  }
}
</style>
