<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm py-2">
      <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">📞 {{ t('common.phoneNumber') }}</span>
          <span class="hidden md:flex items-center gap-1">📧 {{ t('common.email') }}</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">🚚 {{ t('storefront.freeDeliveryTitle') }}</span>
          <span class="hidden md:flex items-center gap-1">🔒 {{ t('storefront.securePaymentTitle') }}</span>
        </div>
      </div>
    </div>

    <!-- Enhanced Header -->
    <div class="bg-white shadow-xl sticky top-0 z-50 border-b-2 border-gray-100">
      <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
          <router-link to="/store/products" class="group flex items-center gap-3 px-4 py-2 text-gray-600 hover:text-green-600 transition-all font-semibold rounded-xl hover:bg-green-50">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ t('storefront.continueShopping') }}
          </router-link>
          
          <div class="flex items-center gap-4">
            <!-- Language Switcher -->
            <LanguageSwitcher />
            
            <!-- Enhanced Cart Badge -->
            <div class="relative group">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
              <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-xl group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <span v-if="cartStore.itemCount > 0" class="absolute -top-2 -right-2 w-7 h-7 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-full flex items-center justify-center shadow-lg animate-bounce">
                {{ cartStore.itemCount }}
              </span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Enhanced Breadcrumb -->
      <div class="border-t border-gray-200 bg-gradient-to-r from-gray-50 to-green-50">
        <div class="container mx-auto px-4 py-3">
          <div class="flex items-center gap-2 text-sm">
            <router-link to="/store" class="text-gray-600 hover:text-green-600 font-medium transition-colors">🏪 {{ t('storefront.home') }}</router-link>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 font-bold flex items-center gap-2">
              <span>🛒</span>
              <span>{{ t('storefront.cart') }}</span>
            </span>
          </div>
        </div>
      </div>
      
      <!-- Smart Flag Bar -->
      <div class="flex">
        <div class="h-1 flex-1 bg-green-500"></div>
        <div class="h-1 flex-1 bg-yellow-500"></div>
        <div class="h-1 flex-1 bg-red-500"></div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <!-- Revolutionary Empty Cart State -->
      <div v-if="cartStore.items.length === 0" class="relative group">
        <!-- 3D Shadow -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <!-- Main Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl border-2 border-gray-100 p-16 text-center overflow-hidden">
          <!-- Animated Background Pattern -->
          <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(34, 197, 94, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(34, 197, 94, 0.3) 1px, transparent 1px); background-size: 50px 50px;"></div>
          </div>
          
          <div class="relative">
            <!-- Animated Cart Icon -->
            <div class="relative inline-block mb-8">
              <div class="absolute inset-0 bg-green-500 rounded-full blur-3xl opacity-30 animate-pulse"></div>
              <div class="relative w-40 h-40 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
            </div>
            
            <h2 class="text-4xl font-black text-gray-900 mb-4">{{ t('storefront.yourCartIsEmpty') }}</h2>
            <p class="text-gray-600 text-lg mb-10 max-w-md mx-auto">{{ t('storefront.emptyCartMessage') }}</p>
            
            <router-link to="/store/products" class="inline-flex items-center gap-4 px-10 py-5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1 group/btn text-lg">
              <svg class="w-6 h-6 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <span>{{ t('storefront.shopNow') }}</span>
              <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Cart with Items -->
      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Enhanced Cart Items (Left - 2 columns) -->
        <div class="lg:col-span-2 space-y-6">
          <div class="group relative transform transition-all duration-500 hover:scale-[1.01]">
            <!-- 3D Shadow Layer -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
            
            <!-- Main Card -->
            <div class="relative bg-white rounded-3xl shadow-2xl border-2 border-gray-100 group-hover:border-green-300 p-8 transition-all">
              <!-- Header with 3D Icon -->
              <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                  <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                    <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                      <span class="text-3xl">🛒</span>
                    </div>
                  </div>
                  <div>
                    <h1 class="text-3xl font-black text-gray-900">{{ t('storefront.cart') }}</h1>
                    <p class="text-green-600 font-semibold">{{ cartStore.itemCount }} {{ t('storefront.items') }}</p>
                  </div>
                </div>
                <div class="px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl border border-green-200">
                  <span class="text-sm font-bold text-green-700">{{ cartStore.itemCount }} {{ t('storefront.items') }}</span>
                </div>
              </div>

              <!-- Enhanced Cart Items List -->
              <div class="space-y-6">
                <div v-for="item in cartStore.items" :key="item.id" class="group/item relative transform transition-all duration-300 hover:scale-[1.02]">
                  <!-- Item Shadow -->
                  <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl blur-lg opacity-0 group-hover/item:opacity-10 transition-opacity"></div>
                  
                  <!-- Item Card -->
                  <div class="relative flex gap-6 p-6 border-2 border-gray-200 rounded-2xl hover:border-green-300 hover:shadow-xl transition-all bg-gradient-to-br from-white to-gray-50">
                    <!-- Enhanced Product Image -->
                    <router-link :to="`/store/products/${item.id}`" class="flex-shrink-0 group/img">
                      <div class="relative">
                        <div class="absolute inset-0 bg-green-500 rounded-2xl blur-md opacity-0 group-hover/img:opacity-30 transition-opacity"></div>
                        <div class="relative w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden flex items-center justify-center shadow-lg group-hover/img:scale-110 transition-transform">
                          <img v-if="item.image" :src="getImageUrl(item.image)" :alt="item.name" class="w-full h-full object-contain" />
                          <span v-else class="text-5xl">🛍️</span>
                        </div>
                      </div>
                    </router-link>
                    
                    <!-- Enhanced Product Info -->
                    <div class="flex-1 min-w-0">
                      <router-link :to="`/store/products/${item.id}`" class="font-black text-gray-900 hover:text-green-600 transition-colors text-xl mb-2 block">
                        {{ tp(item.name) }}
                      </router-link>
                      <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">✅ {{ t('storefront.inStock') }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-bold">🚚 {{ t('storefront.freeDeliveryTitle') }}</span>
                      </div>
                      
                      <!-- Enhanced Quantity Controls -->
                      <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600 font-bold">{{ t('pos.quantity') }}:</span>
                        <div class="flex items-center gap-3 bg-white rounded-xl border-2 border-gray-200 p-1">
                          <button 
                            @click="decreaseQuantity(item)"
                            class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg font-bold text-lg transition-all flex items-center justify-center shadow-md hover:scale-110"
                          >
                            −
                          </button>
                          <input 
                            :value="item.quantity" 
                            @input="updateQuantity(item, $event.target.value)"
                            type="number" 
                            min="1" 
                            :max="item.maxQuantity"
                            class="w-20 h-10 text-center border-2 border-gray-200 rounded-lg font-bold text-lg focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none"
                          />
                          <button 
                            @click="increaseQuantity(item)"
                            :disabled="item.quantity >= item.maxQuantity"
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white rounded-lg font-bold text-lg transition-all flex items-center justify-center shadow-md hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                          >
                            +
                          </button>
                        </div>
                        <span class="text-sm text-gray-500 font-medium">{{ t('storefront.maxStock') }}: {{ item.maxQuantity }}</span>
                      </div>
                    </div>
                    
                    <!-- Enhanced Price & Remove -->
                    <div class="flex flex-col items-end justify-between">
                      <button 
                        @click="removeItem(item)" 
                        class="group/remove p-3 text-red-500 hover:text-white hover:bg-red-500 transition-all rounded-xl hover:scale-110 shadow-md"
                        title="{{ t('storefront.removeItem') }}"
                      >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                      <div class="text-right">
                        <p class="text-sm text-gray-500 mb-1 font-medium">ETB {{ formatPrice(item.price) }} {{ t('storefront.eachItem') }}</p>
                        <p class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                          ETB {{ formatPrice(item.price * item.quantity) }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Enhanced Order Summary (Right - 1 column) -->
        <div class="lg:col-span-1">
          <div class="group relative transform transition-all duration-500 hover:scale-[1.02]">
            <!-- 3D Shadow -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
            
            <!-- Main Summary Card -->
            <div class="relative bg-white rounded-3xl shadow-2xl border-2 border-gray-100 group-hover:border-green-300 p-8 sticky top-24 transition-all">
              <!-- Header with Icon -->
              <div class="flex items-center gap-4 mb-8">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                  <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">📊</span>
                  </div>
                </div>
                <h2 class="text-2xl font-black text-gray-900">{{ t('storefront.orderSummary') }}</h2>
              </div>
              
              <!-- Enhanced Summary Details -->
              <div class="space-y-4 mb-8">
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-green-50 rounded-xl">
                  <span class="font-semibold text-gray-700">{{ t('storefront.subtotalItems', { count: cartStore.itemCount }) }}</span>
                  <span class="font-black text-gray-900 text-lg">ETB {{ formatPrice(cartStore.subtotal) }}</span>
                </div>
                
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                  <span class="font-semibold text-gray-700 flex items-center gap-2">
                    <span>🚚</span>
                    <span>{{ t('storefront.delivery') }}</span>
                  </span>
                  <span class="font-black text-green-600 text-lg">{{ t('storefront.free') }}</span>
                </div>
                
                <!-- Enhanced VAT Toggle -->
                <div class="border-2 border-gray-200 rounded-xl p-4 space-y-3 bg-gradient-to-br from-white to-gray-50">
                  <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer group/vat">
                      <div class="relative">
                        <input 
                          type="checkbox" 
                          v-model="includeVAT"
                          @change="toggleVAT"
                          class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                        />
                        <div class="absolute inset-0 bg-green-500 rounded opacity-0 group-hover/vat:opacity-20 transition-opacity pointer-events-none"></div>
                      </div>
                      <span class="font-bold text-gray-700">{{ t('storefront.vat') }}</span>
                    </label>
                    <span class="font-black text-lg" :class="includeVAT ? 'text-gray-900' : 'text-gray-400'">
                      ETB {{ formatPrice(cartStore.tax) }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-500 ml-8">
                    {{ includeVAT ? '✅ ' + t('storefront.vatWillBeAdded') : '❌ ' + t('storefront.orderWithoutVAT') }}
                  </p>
                </div>
                
                <!-- Enhanced Total -->
                <div class="p-4 bg-gradient-to-r from-green-100 via-emerald-100 to-teal-100 rounded-xl border-2 border-green-200">
                  <div class="flex justify-between items-center">
                    <span class="text-xl font-black text-gray-900">{{ t('storefront.total') }}</span>
                    <span class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                      ETB {{ formatPrice(cartStore.total) }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-600 text-right mt-1 font-medium">
                    {{ includeVAT ? '✅ ' + t('storefront.includeVAT') : '❌ ' + t('storefront.excludeVAT') }}
                  </p>
                </div>
              </div>
              
              <!-- Enhanced Promo Code -->
              <div class="mb-8">
                <div class="flex gap-3">
                  <input 
                    v-model="promoCode"
                    type="text" 
                    :placeholder="t('storefront.enterPromoCode')"
                    class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none font-medium"
                  />
                  <button 
                    @click="applyPromo"
                    class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 text-white rounded-xl font-bold transition-all shadow-lg hover:scale-105"
                  >
                    {{ t('common.apply') }}
                  </button>
                </div>
              </div>
              
              <!-- Enhanced Checkout Button -->
              <button 
                @click="checkout" 
                :disabled="checkingOut"
                class="w-full py-5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-black rounded-2xl shadow-2xl hover:shadow-green-500/50 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 text-xl mb-4 transform hover:scale-105 hover:-translate-y-1 group/checkout"
              >
                <svg v-if="!checkingOut" class="w-7 h-7 group-hover/checkout:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span v-if="checkingOut" class="animate-spin text-2xl">⏳</span>
                <span>{{ checkingOut ? t('storefront.processing') : t('storefront.checkout') }}</span>
                <svg v-if="!checkingOut" class="w-6 h-6 group-hover/checkout:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </button>
              
              <router-link to="/store/products" class="block text-center text-green-600 hover:text-green-700 transition-colors font-bold py-2 hover:bg-green-50 rounded-xl">
                {{ t('storefront.continueShopping') }}
              </router-link>
              
              <!-- Enhanced Trust Badges -->
              <div class="mt-8 pt-6 border-t-2 border-gray-100 space-y-4">
                <div class="flex items-center gap-4 text-sm font-medium">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <span class="text-gray-700">🔒 {{ t('storefront.secureCheckout') }}</span>
                </div>
                <div class="flex items-center gap-4 text-sm font-medium">
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <span class="text-gray-700">↩️ {{ t('storefront.freeReturns') }}</span>
                </div>
                <div class="flex items-center gap-4 text-sm font-medium">
                  <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <span class="text-white text-lg">🚚</span>
                  </div>
                  <span class="text-gray-700">🆓 {{ t('storefront.freeDeliveryOver') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useToastStore } from '@/stores/toast'
import { useTranslation } from '@/composables/useTranslation'
import { useProductTranslation } from '@/composables/useProductTranslation'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'

const { t } = useTranslation()
const { tp, tc } = useProductTranslation()
const router = useRouter()
const cartStore = useCartStore()
const toast = useToastStore()

const checkingOut = ref(false)
const promoCode = ref('')
const includeVAT = ref(cartStore.includeVAT)

const toggleVAT = () => {
  cartStore.toggleVAT(includeVAT.value)
  if (includeVAT.value) {
    toast.success('✅ VAT (15%) will be added to your order')
  } else {
    toast.info('ℹ️ Order will be processed without VAT')
  }
}

const increaseQuantity = (item) => {
  if (item.quantity < item.maxQuantity) {
    cartStore.updateQuantity(item.id, item.quantity + 1)
    toast.success(`Updated ${tp(item.name)} quantity`)
  } else {
    toast.warning(`Maximum stock reached for ${tp(item.name)}`)
  }
}

const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    cartStore.updateQuantity(item.id, item.quantity - 1)
    toast.success(`Updated ${tp(item.name)} quantity`)
  } else {
    removeItem(item)
  }
}

const updateQuantity = (item, value) => {
  const qty = parseInt(value)
  if (qty < 1) {
    removeItem(item)
  } else if (qty <= item.maxQuantity) {
    cartStore.updateQuantity(item.id, qty)
  } else {
    toast.warning(`Only ${item.maxQuantity} items available`)
  }
}

const removeItem = (item) => {
  cartStore.removeItem(item.id)
  toast.info(`🗑️ ${tp(item.name)} removed from cart`)
}

const applyPromo = () => {
  if (promoCode.value) {
    toast.info('Promo code feature coming soon!')
  }
}

const checkout = () => {
  if (cartStore.items.length === 0) {
    toast.warning('Your cart is empty')
    return
  }
  router.push('/store/checkout')
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

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-bounce-slow {
  animation: bounce-slow 2s ease-in-out infinite;
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
</style>