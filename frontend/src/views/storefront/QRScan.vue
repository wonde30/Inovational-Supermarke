<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white sticky top-0 z-50 shadow-lg">
      <div class="max-w-4xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <router-link to="/store" class="text-2xl">←</router-link>
            <div>
              <h1 class="text-xl font-bold">{{ t('storefront.qrScanner') }}</h1>
              <p class="text-xs text-blue-100">{{ t('storefront.scanProductsToCart') }}</p>
            </div>
          </div>
          <router-link to="/store/cart" class="relative">
            <span class="text-3xl">🛒</span>
            <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold animate-bounce">
              {{ cartCount }}
            </span>
          </router-link>
        </div>
      </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-6">
      <!-- QR Scanner -->
      <div class="mb-6">
        <QRScanner @scanned="handleScan" @error="handleError" />
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-600">{{ t('storefront.loadingProduct') }}</p>
      </div>

      <!-- Scanned Product Display -->
      <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 transform scale-95"
        enter-to-class="opacity-100 transform scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 transform scale-100"
        leave-to-class="opacity-0 transform scale-95"
      >
        <div v-if="scannedProduct && !loading" class="bg-white rounded-2xl shadow-2xl overflow-hidden">
          <!-- Product Image -->
          <div class="relative h-64 bg-gradient-to-br from-blue-100 to-purple-100">
            <img 
              :src="getImageUrl(scannedProduct.image)" 
              :alt="tp(scannedProduct.name)"
              class="w-full h-full object-contain p-4"
            />
            <div class="absolute top-4 right-4">
              <span v-if="scannedProduct.quantity > 0" class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                ✓ {{ t('storefront.inStock') }}
              </span>
              <span v-else class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                ✗ {{ t('storefront.outOfStock') }}
              </span>
            </div>
          </div>

          <!-- Product Details -->
          <div class="p-6">
            <div class="mb-4">
              <span class="text-sm text-blue-600 font-semibold">{{ tc(scannedProduct.category?.name) || t('categories.names.Uncategorized') }}</span>
              <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ tp(scannedProduct.name) }}</h2>
              <p class="text-gray-600 mt-2">{{ scannedProduct.description || t('storefront.noDescription') }}</p>
            </div>

            <!-- Price -->
            <div class="flex items-center justify-between mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
              <div>
                <p class="text-sm text-gray-600">{{ t('storefront.price') }}</p>
                <p class="text-3xl font-bold text-green-600">ETB {{ formatCurrency(scannedProduct.price) }}</p>
              </div>
              <div class="text-right">
                <p class="text-sm text-gray-600">{{ t('storefront.available') }}</p>
                <p class="text-2xl font-bold text-gray-800">{{ scannedProduct.quantity }}</p>
              </div>
            </div>

            <!-- Quantity Selector -->
            <div class="mb-6">
              <label class="form-label">{{ t('storefront.quantity') }}</label>
              <div class="flex items-center gap-4">
                <button 
                  @click="decreaseQuantity" 
                  :disabled="quantity <= 1"
                  class="w-12 h-12 rounded-xl bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed font-bold text-xl transition-all"
                >
                  −
                </button>
                <input 
                  v-model.number="quantity" 
                  type="number" 
                  min="1" 
                  :max="scannedProduct.quantity"
                  class="flex-1 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                />
                <button 
                  @click="increaseQuantity" 
                  :disabled="quantity >= scannedProduct.quantity"
                  class="w-12 h-12 rounded-xl bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed font-bold text-xl transition-all"
                >
                  +
                </button>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
              <button 
                @click="addToCart" 
                :disabled="scannedProduct.quantity <= 0 || adding"
                class="flex-1 py-4 rounded-xl font-bold text-white text-lg transition-all shadow-lg"
                :class="scannedProduct.quantity > 0 && !adding ? 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700' : 'bg-gray-400 cursor-not-allowed'"
              >
                <span v-if="adding">{{ t('storefront.adding') }}</span>
                <span v-else-if="scannedProduct.quantity > 0">🛒 {{ t('storefront.addToCart') }}</span>
                <span v-else>{{ t('storefront.outOfStock') }}</span>
              </button>
              <button 
                @click="clearProduct" 
                class="px-6 py-4 bg-gray-200 hover:bg-gray-300 rounded-xl font-bold transition-all"
              >
                ✕
              </button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Recent Scans -->
      <div v-if="recentScans.length > 0" class="mt-6">
        <h3 class="text-lg font-bold text-gray-800 mb-3">{{ t('storefront.recentScans') }}</h3>
        <div class="grid grid-cols-2 gap-3">
          <div 
            v-for="product in recentScans" 
            :key="product.id"
            @click="selectProduct(product)"
            class="bg-white rounded-xl p-3 shadow hover:shadow-lg transition-all cursor-pointer"
          >
            <img :src="getImageUrl(product.image)" class="w-full h-20 object-contain mb-2" />
            <p class="text-sm font-semibold text-gray-800 truncate">{{ tp(product.name) }}</p>
            <p class="text-lg font-bold text-green-600">ETB {{ formatCurrency(product.price) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Toast -->
    <transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 transform translate-y-full"
      enter-to-class="opacity-100 transform translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 transform translate-y-0"
      leave-to-class="opacity-0 transform translate-y-full"
    >
      <div v-if="showSuccess" class="fixed bottom-6 left-4 right-4 bg-green-500 text-white p-4 rounded-xl shadow-2xl z-50">
        <div class="flex items-center gap-3">
          <span class="text-2xl">✅</span>
          <div class="flex-1">
            <p class="font-bold">{{ t('storefront.addedToCart') }}</p>
            <p class="text-sm text-green-100">{{ quantity }} × {{ scannedProduct?.name }}</p>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslation } from '@/composables/useTranslation'
import { useProductTranslation } from '@/composables/useProductTranslation'
import QRScanner from '@/components/QRScanner.vue'
import api from '@/services/api'

const { t } = useTranslation()
const { tp, tc } = useProductTranslation()
const router = useRouter()

const loading = ref(false)
const adding = ref(false)
const scannedProduct = ref(null)
const quantity = ref(1)
const cartCount = ref(0)
const recentScans = ref([])
const showSuccess = ref(false)

const handleScan = async (qrCode) => {
  loading.value = true
  try {
    const response = await api.get(`/api/storefront/scan/${qrCode}`)
    scannedProduct.value = response.data.product
    quantity.value = 1
    
    // Add to recent scans
    if (!recentScans.value.find(p => p.id === scannedProduct.value.id)) {
      recentScans.value.unshift(scannedProduct.value)
      if (recentScans.value.length > 6) {
        recentScans.value.pop()
      }
    }
  } catch (error) {
    alert(error.response?.data?.message || t('storefront.invalidQRCode'))
  } finally {
    loading.value = false
  }
}

const handleError = (error) => {
  console.error('Scanner error:', error)
}

const addToCart = async () => {
  adding.value = true
  try {
    // For now, use localStorage cart (you can replace with API call)
    const cart = JSON.parse(localStorage.getItem('cart') || '[]')
    
    const existingItem = cart.find(item => item.id === scannedProduct.value.id)
    if (existingItem) {
      existingItem.quantity += quantity.value
    } else {
      cart.push({
        ...scannedProduct.value,
        quantity: quantity.value
      })
    }
    
    localStorage.setItem('cart', JSON.stringify(cart))
    cartCount.value = cart.reduce((sum, item) => sum + item.quantity, 0)
    
    // Show success message
    showSuccess.value = true
    setTimeout(() => {
      showSuccess.value = false
      clearProduct()
    }, 2000)
  } catch (error) {
    alert(t('storefront.failedToAddToCart'))
  } finally {
    adding.value = false
  }
}

const clearProduct = () => {
  scannedProduct.value = null
  quantity.value = 1
}

const selectProduct = (product) => {
  scannedProduct.value = product
  quantity.value = 1
}

const increaseQuantity = () => {
  if (quantity.value < scannedProduct.value.quantity) {
    quantity.value++
  }
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

const formatCurrency = (value) => {
  return Number(value).toFixed(2)
}

const getImageUrl = (image) => {
  if (!image) return '/placeholder.png'
  if (image.startsWith('http')) return image
  return `http://localhost:8000/storage/${image}`
}

// Load cart count on mount
const loadCartCount = () => {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]')
  cartCount.value = cart.reduce((sum, item) => sum + item.quantity, 0)
}

loadCartCount()
</script>

<style scoped>
@keyframes bounce {
  0%, 100% {
    transform: translateY(-25%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
  }
  50% {
    transform: translateY(0);
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
  }
}

.animate-bounce {
  animation: bounce 1s infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>
