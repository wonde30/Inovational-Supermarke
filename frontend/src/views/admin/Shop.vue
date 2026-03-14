<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">🛍️ {{ t('navigation.shop') }}</h1>
      <p class="text-gray-500">{{ t('storefront.browseProducts') }}</p>
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
      <div class="flex-1 relative">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
        <input v-model="search" type="text" class="input pl-12" :placeholder="t('storefront.searchProducts')" />
      </div>
      <select v-model="categoryFilter" class="input w-48">
        <option value="">{{ t('storefront.allCategories') }}</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
      <div v-for="product in filteredProducts" :key="product.id" class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all">
        <div class="h-40 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-4">
          <img :src="getImageUrl(product.image)" :alt="product.name" class="max-h-full max-w-full object-contain" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-gray-800 text-sm mb-1 line-clamp-2">{{ product.name }}</h3>
          <p class="text-xs text-gray-500 mb-2">{{ product.category?.name || t('categories.names.Uncategorized') }}</p>
          <div class="flex items-center justify-between">
            <p class="font-bold text-indigo-600">ETB {{ formatCurrency(product.price) }}</p>
            <span v-if="product.quantity > 0" class="text-xs text-green-600">In Stock</span>
            <span v-else class="text-xs text-red-600">Out of Stock</span>
          </div>
          <button 
            @click="addToCart(product)" 
            :disabled="product.quantity <= 0"
            class="w-full mt-3 py-2 rounded-xl text-sm font-medium transition-all"
            :class="product.quantity > 0 ? 'bg-indigo-600 hover:bg-indigo-700 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
          >
            {{ product.quantity > 0 ? '🛒 Add to Cart' : 'Out of Stock' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="filteredProducts.length === 0" class="text-center py-12">
      <p class="text-6xl mb-4">🔍</p>
      <p class="text-gray-500">No products found</p>
    </div>

    <!-- Cart Floating Button -->
    <div v-if="cart.length > 0" class="fixed bottom-6 right-6">
      <button @click="showCart = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transition-all">
        <span class="text-2xl">🛒</span>
        <div class="text-left">
          <p class="font-bold">{{ cart.length }} items</p>
          <p class="text-sm opacity-80">ETB {{ formatCurrency(cartTotal) }}</p>
        </div>
      </button>
    </div>

    <!-- Cart Modal -->
    <div v-if="showCart" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl w-full max-w-lg max-h-[80vh] overflow-hidden flex flex-col">
        <div class="p-4 border-b flex justify-between items-center">
          <h2 class="text-xl font-bold">🛒 Your Cart</h2>
          <button @click="showCart = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
          <div v-for="(item, index) in cart" :key="index" class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
            <img :src="getImageUrl(item.image)" class="w-16 h-16 object-contain rounded-lg bg-white" />
            <div class="flex-1">
              <p class="font-semibold text-sm">{{ item.name }}</p>
              <p class="text-indigo-600 font-bold">ETB {{ formatCurrency(item.price) }}</p>
            </div>
            <div class="flex items-center gap-2">
              <button @click="updateQty(index, -1)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300">-</button>
              <span class="w-8 text-center font-bold">{{ item.qty }}</span>
              <button @click="updateQty(index, 1)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300">+</button>
            </div>
            <button @click="removeFromCart(index)" class="text-red-500 hover:text-red-700">🗑️</button>
          </div>
        </div>
        <div class="p-4 border-t bg-gray-50">
          <div class="flex justify-between mb-2">
            <span>{{ t('common.subtotal') }}</span>
            <span class="font-bold">ETB {{ formatCurrency(cartTotal) }}</span>
          </div>
          <div class="flex justify-between mb-4">
            <span>{{ t('storefront.vat') }}</span>
            <span class="font-bold">ETB {{ formatCurrency(cartTotal * 0.15) }}</span>
          </div>
          <div class="flex justify-between text-lg font-bold mb-4 p-3 bg-indigo-100 rounded-xl">
            <span>{{ t('common.total') }}</span>
            <span class="text-indigo-600">ETB {{ formatCurrency(cartTotal * 1.15) }}</span>
          </div>
          <button @click="placeOrder" :disabled="ordering" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all">
            {{ ordering ? t('storefront.processing') : '✓ ' + t('storefront.placeOrder') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { productsApi, categoriesApi, storefrontApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'

const toast = useToastStore()
const { t } = useTranslation()
const products = ref([])
const categories = ref([])
const search = ref('')
const categoryFilter = ref('')
const cart = ref([])
const showCart = ref(false)
const ordering = ref(false)

const filteredProducts = computed(() => {
  return products.value.filter(p => {
    const matchSearch = p.name.toLowerCase().includes(search.value.toLowerCase())
    const matchCategory = !categoryFilter.value || p.category_id == categoryFilter.value
    return matchSearch && matchCategory
  })
})

const cartTotal = computed(() => cart.value.reduce((sum, item) => sum + (item.price * item.qty), 0))

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })

const getImageUrl = (image) => {
  if (!image) return '/images/products/default.jpg'
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `/storage/${image}`
}

const addToCart = (product) => {
  const existing = cart.value.find(item => item.id === product.id)
  if (existing) {
    existing.qty++
  } else {
    cart.value.push({ ...product, qty: 1 })
  }
  toast.success(`Added: ${product.name}`)
}

const updateQty = (index, delta) => {
  cart.value[index].qty += delta
  if (cart.value[index].qty <= 0) {
    cart.value.splice(index, 1)
  }
}

const removeFromCart = (index) => {
  cart.value.splice(index, 1)
}

const placeOrder = async () => {
  ordering.value = true
  try {
    await storefrontApi.createOrder({
      items: cart.value.map(item => ({ product_id: item.id, quantity: item.qty, price: item.price })),
      payment_method: 'cash'
    })
    toast.success('Order placed successfully! 🎉')
    cart.value = []
    showCart.value = false
  } catch (e) {
    toast.error(e.message || t('messages.errorOccurred'))
  } finally {
    ordering.value = false
  }
}

const fetchProducts = async () => {
  try {
    const response = await productsApi.getAll({ per_page: 100 })
    products.value = response.data
  } catch (e) {}
}

const fetchCategories = async () => {
  try {
    const response = await categoriesApi.getAll()
    categories.value = response.data
  } catch (e) {}
}

onMounted(() => {
  fetchProducts()
  fetchCategories()
})
</script>
