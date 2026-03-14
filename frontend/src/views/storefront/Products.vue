<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <!-- Revolutionary Header -->
    <div class="bg-white shadow-xl border-b-2 border-gray-100 sticky top-0 z-50">
      <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between">
          <!-- Enhanced Title Section -->
          <div class="flex items-center gap-4">
            <div class="relative">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-md opacity-50 animate-pulse"></div>
              <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl">
                <span class="text-4xl">🛍️</span>
              </div>
            </div>
            <div>
              <h1 class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                {{ t('storefront.ourProducts') }}
              </h1>
              <p class="text-green-600 font-semibold">{{ t('storefront.findEverythingYouNeed') }}</p>
            </div>
          </div>
          
          <!-- Enhanced Cart Button -->
          <router-link to="/store/cart" class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-2xl hover:shadow-green-500/50 transition-all hover:scale-110 group-hover:rotate-6">
              <span class="text-3xl">🛒</span>
            </div>
            <span v-if="cartStore.itemCount > 0" class="absolute -top-3 -right-3 w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-full flex items-center justify-center shadow-lg animate-bounce">
              {{ cartStore.itemCount }}
            </span>
          </router-link>
        </div>
      </div>
      
      <!-- Smart Flag Bar -->
      <div class="flex">
        <div class="h-1 flex-1 bg-green-500"></div>
        <div class="h-1 flex-1 bg-yellow-500"></div>
        <div class="h-1 flex-1 bg-red-500"></div>
      </div>
    </div>

    <div class="container mx-auto px-4 py-6">
      <!-- Revolutionary Filters -->
      <div class="group relative transform transition-all duration-500 hover:scale-[1.01]">
        <!-- 3D Shadow -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        
        <!-- Main Filter Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl border-2 border-gray-100 group-hover:border-green-300 p-8 mb-8 transition-all">
          <!-- Filter Header -->
          <div class="flex items-center gap-4 mb-6">
            <div class="relative">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
              <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl">🔍</span>
              </div>
            </div>
            <div>
              <h2 class="text-xl font-black text-gray-900">{{ t('storefront.findYourProducts') }}</h2>
              <p class="text-gray-600 font-medium">{{ t('storefront.searchAndFilter') }}</p>
            </div>
          </div>
          
          <div class="flex flex-col md:flex-row gap-6">
            <!-- Enhanced Search -->
            <div class="flex-1 relative group/search">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input 
                v-model="filters.search" 
                @input="debouncedFetch"
                type="text" 
                placeholder="{{ t('storefront.searchProducts') }}" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg"
              />
            </div>
            
            <!-- Enhanced Category Filter -->
            <div class="relative group/category">
              <select 
                v-model="filters.category" 
                @change="fetchProducts"
                class="appearance-none pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer min-w-[250px] font-medium text-lg hover:shadow-lg"
              >
                <option value="">{{ t('storefront.allCategories') }}</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/category:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Loading State -->
      <div v-if="loading" class="flex justify-center py-24">
        <div class="text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-20 h-20 border-4 border-green-200 border-t-green-600 rounded-full animate-spin shadow-xl"></div>
          </div>
          <p class="text-gray-600 text-lg font-medium">{{ t('storefront.loadingProducts') }}</p>
        </div>
      </div>

      <!-- Revolutionary Empty State -->
      <div v-else-if="products.length === 0" class="relative group">
        <!-- 3D Shadow -->
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <!-- Main Card -->
        <div class="relative text-center py-20 bg-white rounded-3xl shadow-2xl border-2 border-gray-100 overflow-hidden">
          <!-- Animated Background Pattern -->
          <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(34, 197, 94, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(34, 197, 94, 0.3) 1px, transparent 1px); background-size: 50px 50px;"></div>
          </div>
          
          <div class="relative">
            <div class="relative inline-block mb-8">
              <div class="absolute inset-0 bg-yellow-500 rounded-full blur-3xl opacity-30 animate-pulse"></div>
              <div class="relative w-32 h-32 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                <span class="text-8xl">🔍</span>
              </div>
            </div>
            <h3 class="text-3xl font-black text-gray-900 mb-4">{{ t('storefront.noProductsFound') }}</h3>
            <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">{{ t('storefront.tryAdjusting') }}</p>
            <button @click="filters.search = ''; filters.category = ''; fetchProducts()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 hover:-translate-y-1 group/btn">
              <span class="text-2xl group-hover/btn:scale-110 transition-transform">🔄</span>
              <span>{{ t('storefront.clearFilters') }}</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Revolutionary Products Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div 
          v-for="product in products" 
          :key="product.id" 
          @click="$router.push(`/store/products/${product.id}`)"
          class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2 cursor-pointer"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Product Card -->
          <div class="relative bg-white rounded-3xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all">
            <!-- Enhanced Product Image -->
            <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
              <img 
                v-if="product.image" 
                :src="getImageUrl(product.image)" 
                :alt="product.name"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <span v-else class="text-8xl opacity-50">🛍️</span>
              
              <!-- Enhanced Stock Badge -->
              <div class="absolute top-4 right-4">
                <span 
                  v-if="product.quantity > 0" 
                  class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold rounded-full shadow-xl animate-pulse"
                >
                  ✅ {{ t('storefront.inStock') }}
                </span>
                <span 
                  v-else 
                  class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-full shadow-xl"
                >
                  ❌ {{ t('storefront.outOfStock') }}
                </span>
              </div>
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>

            <!-- Enhanced Product Info -->
            <div class="p-6 bg-gradient-to-br from-white to-gray-50">
              <!-- Category Badge -->
              <div class="mb-3">
                <span class="px-3 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 text-xs font-bold uppercase tracking-wide rounded-full border border-green-200">
                  {{ tc(product.category?.name) || t('categories.names.Uncategorized') }}
                </span>
              </div>
              
              <!-- Product Name -->
              <h3 class="font-black text-gray-900 text-xl mb-3 line-clamp-1 group-hover:text-green-600 transition-colors">
                {{ tp(product.name) }}
              </h3>
              
              <!-- Description -->
              <p class="text-sm text-gray-600 line-clamp-2 mb-4 h-10 leading-relaxed">
                {{ product.description || t('storefront.highQualityProduct') }}
              </p>
              
              <!-- Price & Stock Info -->
              <div class="flex items-center justify-between mb-6">
                <div>
                  <p class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                    ETB {{ formatPrice(product.price) }}
                  </p>
                  <p class="text-sm text-gray-500 font-medium flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span>{{ product.quantity || 0 }} {{ t('storefront.available') }}</span>
                  </p>
                </div>
                <div class="text-right">
                  <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-2xl">⭐</span>
                  </div>
                </div>
              </div>
              
              <!-- Enhanced Action Buttons -->
              <div class="flex gap-3">
                <button 
                  @click.stop="addToCart(product)" 
                  :disabled="!product.quantity || product.quantity < 1"
                  class="flex-1 py-4 rounded-2xl font-bold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 shadow-lg"
                  :class="product.quantity > 0 
                    ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white hover:from-green-500 hover:to-emerald-500 hover:shadow-green-500/50' 
                    : 'bg-gradient-to-r from-gray-400 to-gray-500 text-white'"
                >
                  <span v-if="product.quantity > 0" class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ t('storefront.addToCart') }}
                  </span>
                  <span v-else>{{ t('storefront.outOfStock') }}</span>
                </button>
                
                <button 
                  @click.stop="$router.push(`/store/products/${product.id}`)"
                  class="px-5 py-4 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-400 hover:to-cyan-500 text-white rounded-2xl font-bold transition-all shadow-lg hover:shadow-blue-500/50 transform hover:scale-105"
                  title="{{ t('storefront.viewDetails') }}"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Pagination -->
      <div v-if="pagination.lastPage > 1" class="mt-12 flex justify-center">
        <div class="relative group">
          <!-- 3D Shadow -->
          <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-20 transition-opacity"></div>
          
          <!-- Pagination Container -->
          <div class="relative flex items-center gap-3 bg-white rounded-2xl p-3 shadow-xl border-2 border-gray-100 group-hover:border-green-300 transition-all">
            <button 
              @click="goToPage(pagination.currentPage - 1)"
              :disabled="pagination.currentPage === 1"
              class="flex items-center gap-2 px-6 py-3 rounded-xl border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all font-bold transform hover:scale-105"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              {{ t('common.previous') }}
            </button>
            
            <div class="flex gap-2">
              <button 
                v-for="page in visiblePages" 
                :key="page"
                @click="goToPage(page)"
                class="w-12 h-12 rounded-xl font-black transition-all transform hover:scale-110"
                :class="page === pagination.currentPage 
                  ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg shadow-green-500/50' 
                  : 'border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 text-gray-700'"
              >
                {{ page }}
              </button>
            </div>
            
            <button 
              @click="goToPage(pagination.currentPage + 1)"
              :disabled="pagination.currentPage === pagination.lastPage"
              class="flex items-center gap-2 px-6 py-3 rounded-xl border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all font-bold transform hover:scale-105"
            >
              {{ t('common.next') }}
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useTranslation } from '@/composables/useTranslation'
import { useProductTranslation } from '@/composables/useProductTranslation'
import { storefrontApi } from '@/services/api'
import { useCartStore } from '@/stores/cart'
import { useToastStore } from '@/stores/toast'

const { t } = useTranslation()
const { tp, tc } = useProductTranslation()
const route = useRoute()
const cartStore = useCartStore()
const toast = useToastStore()

const loading = ref(true)
const products = ref([])
const categories = ref([])
const filters = reactive({ search: '', category: '' })
const pagination = reactive({ currentPage: 1, lastPage: 1 })

const visiblePages = computed(() => {
  const pages = []
  const start = Math.max(1, pagination.currentPage - 2)
  const end = Math.min(pagination.lastPage, pagination.currentPage + 2)
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  return pages
})

let debounceTimer = null
const debouncedFetch = () => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchProducts, 300)
}

const fetchProducts = async () => {
  try {
    loading.value = true
    const params = { page: pagination.currentPage }
    if (filters.search) params.search = filters.search
    if (filters.category) params.category_id = filters.category
    
    const res = await storefrontApi.getProducts(params)
    products.value = res.data?.data || res.data || []
    pagination.currentPage = res.data?.current_page || res.meta?.current_page || 1
    pagination.lastPage = res.data?.last_page || res.meta?.last_page || 1
  } catch (error) {
    toast.error('Failed to load products')
  } finally {
    loading.value = false
  }
}

const fetchCategories = async () => {
  try {
    const res = await storefrontApi.getCategories()
    categories.value = res.data || []
  } catch (error) {
    console.error('Failed to load categories')
  }
}

const goToPage = (page) => {
  if (page >= 1 && page <= pagination.lastPage) {
    pagination.currentPage = page
    fetchProducts()
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const addToCart = (product) => {
  cartStore.addItem(product)
  toast.success(`✅ ${tp(product.name)} ${t('storefront.addedToCart')}!`)
}

const formatPrice = (price) => {
  return Number(price || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const getImageUrl = (image) => {
  if (!image) return ''
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `/storage/${image}`
}

onMounted(() => {
  if (route.query.category) filters.category = route.query.category
  fetchCategories()
  fetchProducts()
})

watch(() => route.query.category, (val) => {
  if (val) {
    filters.category = val
    fetchProducts()
  }
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

@keyframes bounce-slow {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

@keyframes pulse-glow {
  0%, 100% {
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
  }
  50% {
    box-shadow: 0 0 40px rgba(34, 197, 94, 0.6);
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-bounce-slow {
  animation: bounce-slow 2s ease-in-out infinite;
}

.animate-pulse-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

/* Line Clamp Utility */
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
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

/* Product Card Hover Effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

.group:hover .group-hover\:rotate-12 {
  transform: rotate(12deg);
}

/* Focus States */
input:focus, select:focus {
  transform: translateY(-2px);
}

/* Button Hover Effects */
button:hover:not(:disabled) {
  transform: translateY(-2px);
}

button:active:not(:disabled) {
  transform: translateY(0);
}
</style>