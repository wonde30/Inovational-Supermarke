<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white text-xs py-2">
      <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">📞 +251 911 123 456</span>
          <span class="hidden md:flex items-center gap-1">📧 info@smartsupermarket.com</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">🚚 {{ t('storefront.freeDeliveryDesc') }}</span>
          <span class="hidden md:flex items-center gap-1">🔒 {{ t('storefront.securePaymentTitle') }}</span>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="bg-white shadow-md sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
          <button @click="$router.back()" class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ t('storefront.backToProducts') }}
          </button>
          
          <div class="flex items-center gap-3">
            <!-- Wishlist -->
            <button @click="toggleWishlist" class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors" :title="isInWishlist ? t('storefront.removeFromWishlist') : t('storefront.addToWishlist')">
              <svg class="w-6 h-6" :class="isInWishlist ? 'fill-red-500 text-red-500' : 'text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>
            
            <!-- Share -->
            <button @click="shareProduct" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" :title="t('storefront.shareProduct')">
              <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
              </svg>
            </button>
            
            <!-- Cart -->
            <router-link to="/store/cart" class="relative">
              <div class="w-11 h-11 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <span v-if="cartStore.itemCount > 0" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                {{ cartStore.itemCount }}
              </span>
            </router-link>
          </div>
        </div>
      </div>
      
      <!-- Breadcrumb -->
      <div class="border-t border-gray-200">
        <div class="container mx-auto px-4 py-2">
          <div class="flex items-center gap-2 text-sm text-gray-600">
            <router-link to="/store" class="hover:text-green-600">{{ t('storefront.home') }}</router-link>
            <span>/</span>
            <router-link to="/store/products" class="hover:text-green-600">{{ t('products.title') }}</router-link>
            <span>/</span>
            <span v-if="product" class="hover:text-green-600">{{ tc(product.category?.name) || t('categories.title') }}</span>
            <span>/</span>
            <span class="text-gray-900 font-medium truncate max-w-xs">{{ tp(product?.name) || t('products.title') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center py-20">
      <div class="text-center">
        <div class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-500">{{ t('common.loading') }}...</p>
      </div>
    </div>

    <!-- Product Detail -->
    <div v-else-if="product" class="container mx-auto px-4 py-6">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Image Gallery (40%) -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
            <!-- Main Image with Zoom -->
            <div class="relative h-96 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl overflow-hidden flex items-center justify-center mb-4 group">
              <img 
                v-if="product.image" 
                :src="getImageUrl(selectedImage || product.image)" 
                :alt="tp(product.name)"
                class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110 cursor-zoom-in"
                @click="openImageZoom"
              />
              <span v-else class="text-9xl">🛍️</span>
              
              <!-- Badges -->
              <div class="absolute top-3 left-3 flex flex-col gap-2">
                <span v-if="product.quantity <= 5 && product.quantity > 0" class="px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full shadow-lg">
                  {{ t('storefront.onlyLeft', { count: product.quantity }) }}
                </span>
                <span v-if="isNewProduct" class="px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full shadow-lg">
                  {{ t('storefront.new') }}
                </span>
              </div>
            </div>
            
            <!-- Thumbnail Images -->
            <div class="flex gap-2 overflow-x-auto pb-2">
              <div 
                v-for="(img, index) in productImages" 
                :key="index"
                @click="selectedImage = img"
                class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 transition-all hover:border-green-500"
                :class="selectedImage === img ? 'border-green-600 ring-2 ring-green-200' : 'border-gray-200'"
              >
                <img :src="getImageUrl(img)" :alt="`${tp(product.name)} ${index + 1}`" class="w-full h-full object-cover" />
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-4 space-y-2">
              <button @click="compareProduct" class="w-full py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all flex items-center justify-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                {{ t('storefront.compare') }}
              </button>
              <button @click="askQuestion" class="w-full py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all flex items-center justify-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                {{ t('storefront.askQuestion') }}
              </button>
            </div>
          </div>
        </div>

        <!-- Middle Column: Product Info (40%) -->
        <div class="lg:col-span-1 space-y-4">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <!-- Category & Brand -->
            <div class="flex items-center justify-between mb-3">
              <span class="text-sm font-semibold text-green-600 uppercase tracking-wide">
                {{ tc(product.category?.name) || t('categories.names.Uncategorized') }}
              </span>
              <span class="text-xs text-gray-500">SKU: {{ product.sku || 'N/A' }}</span>
            </div>
            
            <!-- Product Name -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
              {{ tp(product.name) }}
            </h1>
            
            <!-- Rating & Reviews -->
            <div class="flex items-center gap-3 mb-4 pb-4 border-b">
              <div class="flex items-center gap-1">
                <span v-for="i in 5" :key="i" class="text-yellow-400 text-lg">
                  {{ i <= rating ? '⭐' : '☆' }}
                </span>
              </div>
              <span class="text-sm text-gray-600 font-medium">{{ rating.toFixed(1) }}</span>
              <span class="text-sm text-gray-400">|</span>
              <button @click="scrollToReviews" class="text-sm text-blue-600 hover:underline">{{ reviewCount }} Reviews</button>
              <span class="text-sm text-gray-400">|</span>
              <span class="text-sm text-green-600 font-medium">{{ soldCount }}+ Sold</span>
            </div>
            
            <!-- Price Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 mb-4">
              <div class="flex items-baseline gap-3 mb-2">
                <span class="text-4xl font-bold text-green-600">ETB {{ formatPrice(product.price) }}</span>
                <span v-if="originalPrice > product.price" class="text-lg text-gray-400 line-through">ETB {{ formatPrice(originalPrice) }}</span>
                <span v-if="discountPercent > 0" class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">-{{ discountPercent }}%</span>
              </div>
              <p class="text-xs text-gray-600">Inclusive of VAT</p>
            </div>
            
            <!-- Key Features -->
            <div class="mb-4">
              <h3 class="text-sm font-bold text-gray-900 mb-3">{{ t('storefront.keyFeatures') }}:</h3>
              <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-2 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span>{{ t('storefront.highQuality') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span>{{ t('storefront.fastDelivery') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span>{{ t('storefront.warrantyIncluded') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span>{{ t('storefront.easyReturns') }}</span>
                </div>
              </div>
            </div>
            
            <!-- Stock Status -->
            <div class="mb-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">{{ t('storefront.availability') }}:</span>
                <span v-if="product.quantity > 0" class="px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">
                  ✓ {{ t('storefront.inStock') }} ({{ product.quantity }} {{ t('storefront.units') }})
                </span>
                <span v-else class="px-3 py-1 bg-red-100 text-red-700 text-sm font-bold rounded-full">
                  ✗ {{ t('storefront.outOfStock') }}
                </span>
              </div>
              
              <!-- Stock Progress Bar -->
              <div v-if="product.quantity > 0 && product.quantity <= 20" class="mt-2">
                <div class="flex justify-between text-xs text-gray-600 mb-1">
                  <span>{{ t('storefront.hurryOnlyLeft', { count: product.quantity }) }}</span>
                  <span>{{ Math.round((product.quantity / 20) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-gradient-to-r from-orange-500 to-red-500 h-2 rounded-full transition-all" :style="{ width: Math.min((product.quantity / 20) * 100, 100) + '%' }"></div>
                </div>
              </div>
            </div>
            
            <!-- Quantity Selector -->
            <div class="mb-4">
              <label class="text-sm font-semibold text-gray-700 block mb-2">{{ t('storefront.quantity') }}:</label>
              <div class="flex items-center gap-3">
                <button 
                  @click="decreaseQuantity"
                  :disabled="quantity <= 1"
                  class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                >
                  −
                </button>
                <input 
                  v-model.number="quantity" 
                  type="number" 
                  min="1" 
                  :max="product.quantity"
                  class="w-20 h-10 text-center border-2 border-gray-200 rounded-lg font-semibold text-lg focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none"
                />
                <button 
                  @click="increaseQuantity"
                  :disabled="quantity >= product.quantity"
                  class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                >
                  +
                </button>
                <span class="text-sm text-gray-600">{{ t('storefront.max') }}: {{ product.quantity }}</span>
              </div>
            </div>
            
            <!-- Bulk Discount -->
            <div v-if="bulkDiscounts.length > 0" class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
              <p class="text-sm font-semibold text-blue-900 mb-2">💰 {{ t('storefront.bulkPurchaseDiscounts') }}:</p>
              <div class="space-y-1">
                <p v-for="discount in bulkDiscounts" :key="discount.min" class="text-xs text-blue-700">
                  {{ t('storefront.buyItemsSave', { min: discount.min, percent: discount.percent }) }}
                </p>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-3">
              <button 
                @click="addToCart"
                :disabled="!product.quantity || product.quantity < 1"
                class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-lg"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ t('storefront.addToCart') }}
              </button>
              
              <button 
                @click="buyNow"
                :disabled="!product.quantity || product.quantity < 1"
                class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-lg"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                {{ t('storefront.buyNow') }}
              </button>
            </div>
          </div>
        </div>

        <!-- Right Column: Delivery & Seller Info (20%) -->
        <div class="lg:col-span-1 space-y-4">
          <!-- Delivery Information -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
              </svg>
              {{ t('storefront.deliveryInfo') }}
            </h3>
            
            <div class="space-y-3">
              <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                <span class="text-2xl">🚚</span>
                <div class="flex-1">
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.freeDelivery') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.onOrdersOver') }}</p>
                </div>
              </div>
              
              <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                <span class="text-2xl">📦</span>
                <div class="flex-1">
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.standardDelivery') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.estimated') }}: {{ estimatedDelivery }}</p>
                </div>
              </div>
              
              <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                <span class="text-2xl">⚡</span>
                <div class="flex-1">
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.expressAvailable') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.sameDayDelivery') }}</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Seller Information -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              {{ t('storefront.sellerInfo') }}
            </h3>
            
            <div class="flex items-center gap-3 mb-3">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                SM
              </div>
              <div>
                <p class="font-bold text-gray-900">Smart SuperMarket</p>
                <div class="flex items-center gap-1">
                  <span class="text-yellow-400 text-sm">⭐⭐⭐⭐⭐</span>
                  <span class="text-xs text-gray-600">(4.8)</span>
                </div>
              </div>
            </div>
            
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-600">{{ t('storefront.products') }}:</span>
                <span class="font-semibold text-gray-900">500+</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600">{{ t('storefront.responseRate') }}:</span>
                <span class="font-semibold text-green-600">98%</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600">{{ t('storefront.shipOnTime') }}:</span>
                <span class="font-semibold text-green-600">99%</span>
              </div>
            </div>
            
            <button class="w-full mt-4 py-2 border-2 border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-all font-semibold text-sm">
              {{ t('storefront.visitStore') }}
            </button>
          </div>
          
          <!-- Warranty & Returns -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              {{ t('storefront.protection') }}
            </h3>
            
            <div class="space-y-3">
              <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <div>
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.sevenDayReturns') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.changeOfMind') }}</p>
                </div>
              </div>
              
              <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <div>
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.warranty') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.yearWarranty') }}</p>
                </div>
              </div>
              
              <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <div>
                  <p class="font-semibold text-gray-900 text-sm">{{ t('storefront.securePayment') }}</p>
                  <p class="text-xs text-gray-600">{{ t('storefront.secureTransactions') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs Section -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6">
        <!-- Tab Headers -->
        <div class="border-b border-gray-200 bg-gray-50">
          <div class="flex overflow-x-auto">
            <button 
              v-for="tab in tabs" 
              :key="tab.id"
              @click="activeTab = tab.id"
              class="flex-shrink-0 px-6 py-4 font-semibold transition-all relative whitespace-nowrap"
              :class="activeTab === tab.id 
                ? 'text-green-600 bg-white' 
                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'"
            >
              {{ tab.label }}
              <div 
                v-if="activeTab === tab.id" 
                class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-600 to-emerald-600"
              ></div>
            </button>
          </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
          <!-- Description Tab -->
          <div v-if="activeTab === 'description'">
            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ t('storefront.productDescription') }}</h3>
            <div class="prose max-w-none text-gray-700 leading-relaxed">
              <p>{{ product.description || t('storefront.noDescriptionAvailable') }}</p>
            </div>
          </div>

          <!-- Specifications Tab -->
          <div v-if="activeTab === 'specifications'">
            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ t('storefront.technicalSpecifications') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">SKU:</span>
                <span class="text-gray-900">{{ product.sku || 'N/A' }}</span>
              </div>
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">{{ t('categories.title') }}:</span>
                <span class="text-gray-900">{{ product.category?.name || 'N/A' }}</span>
              </div>
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">{{ t('products.price') }}:</span>
                <span class="text-gray-900">ETB {{ formatPrice(product.price) }}</span>
              </div>
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">{{ t('products.stock') }}:</span>
                <span class="text-gray-900">{{ product.quantity }} {{ t('storefront.units') }}</span>
              </div>
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">Weight:</span>
                <span class="text-gray-900">N/A</span>
              </div>
              <div class="flex justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="font-semibold text-gray-700">Dimensions:</span>
                <span class="text-gray-900">N/A</span>
              </div>
            </div>
          </div>

          <!-- Reviews Tab -->
          <div v-if="activeTab === 'reviews'" ref="reviewsSection">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-bold text-gray-900">{{ t('storefront.customerReviews') }}</h3>
              <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-semibold text-sm">
                {{ t('storefront.writeReview') }}
              </button>
            </div>
            
            <!-- Rating Summary -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 mb-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center">
                  <p class="text-6xl font-bold text-gray-900 mb-2">{{ rating.toFixed(1) }}</p>
                  <div class="flex justify-center mb-2">
                    <span v-for="i in 5" :key="i" class="text-yellow-400 text-3xl">
                      {{ i <= rating ? '⭐' : '☆' }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-600">{{ t('storefront.basedOnReviews', { count: reviewCount }) }}</p>
                </div>
                <div class="space-y-2">
                  <div v-for="star in [5, 4, 3, 2, 1]" :key="star" class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 w-12">{{ star }} {{ t('storefront.star') }}</span>
                    <div class="flex-1 h-3 bg-gray-200 rounded-full overflow-hidden">
                      <div class="h-full bg-yellow-400 transition-all" :style="{ width: getStarPercentage(star) + '%' }"></div>
                    </div>
                    <span class="text-sm text-gray-600 w-12 text-right">{{ getStarCount(star) }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-4">
              <div v-for="review in reviews" :key="review.id" class="border-b border-gray-200 pb-4 last:border-0">
                <div class="flex items-start justify-between mb-2">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                      {{ review.author.charAt(0) }}
                    </div>
                    <div>
                      <p class="font-semibold text-gray-900">{{ review.author }}</p>
                      <div class="flex items-center gap-2">
                        <div class="flex">
                          <span v-for="i in 5" :key="i" class="text-yellow-400 text-sm">
                            {{ i <= review.rating ? '⭐' : '☆' }}
                          </span>
                        </div>
                        <span class="text-xs text-gray-500">{{ review.date }}</span>
                      </div>
                    </div>
                  </div>
                  <span class="text-xs text-green-600 font-semibold">✓ {{ t('storefront.verifiedPurchase') }}</span>
                </div>
                <p class="text-gray-700 ml-13">{{ review.comment }}</p>
              </div>
            </div>
          </div>
          
          <!-- Q&A Tab -->
          <div v-if="activeTab === 'qa'">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-bold text-gray-900">{{ t('storefront.questionsAnswers') }}</h3>
              <button @click="askQuestion" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-semibold text-sm">
                {{ t('storefront.askQuestion') }}
              </button>
            </div>
            
            <div class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-start gap-3 mb-3">
                  <span class="text-2xl">❓</span>
                  <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ t('storefront.isProductOriginal') }}</p>
                    <p class="text-xs text-gray-500">{{ t('storefront.askedByJohn') }}</p>
                  </div>
                </div>
                <div class="flex items-start gap-3 ml-11 bg-white rounded-lg p-3">
                  <span class="text-xl">💬</span>
                  <div class="flex-1">
                    <p class="text-gray-700 text-sm">{{ t('storefront.yesAllProductsOriginal') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('storefront.answeredByStore') }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Frequently Bought Together -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ t('storefront.frequentlyBoughtTogether') }}</h3>
        <div class="flex flex-wrap items-center gap-4">
          <div class="flex items-center gap-3 flex-wrap">
            <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
              <img v-if="product.image" :src="getImageUrl(product.image)" class="w-full h-full object-contain" />
            </div>
            <span class="text-2xl text-gray-400">+</span>
            <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
              <span class="text-4xl">🎧</span>
            </div>
            <span class="text-2xl text-gray-400">+</span>
            <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
              <span class="text-4xl">📱</span>
            </div>
          </div>
          <div class="flex-1 min-w-[200px]">
            <p class="text-sm text-gray-600 mb-2">{{ t('storefront.totalPrice') }}:</p>
            <p class="text-2xl font-bold text-green-600 mb-3">ETB {{ formatPrice(product.price * 1.5) }}</p>
            <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-semibold">
              {{ t('storefront.addAllToCart') }}
            </button>
          </div>
        </div>
      </div>

      <!-- Related Products -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ t('storefront.relatedProducts') }}</h3>
        
        <div v-if="relatedProducts.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          <div 
            v-for="relatedProduct in relatedProducts" 
            :key="relatedProduct.id"
            @click="navigateToProduct(relatedProduct.id)"
            class="group cursor-pointer bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-green-200 transition-all duration-300"
          >
            <div class="relative h-40 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
              <img 
                v-if="relatedProduct.image" 
                :src="getImageUrl(relatedProduct.image)" 
                :alt="tp(relatedProduct.name)"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
              />
              <span v-else class="text-4xl">🛍️</span>
            </div>
            <div class="p-3">
              <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2 group-hover:text-green-600 transition-colors">
                {{ tp(relatedProduct.name) }}
              </h4>
              <p class="text-lg font-bold text-green-600">
                ETB {{ formatPrice(relatedProduct.price) }}
              </p>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-8 text-gray-500">
          {{ t('storefront.noRelatedProducts') }}
        </div>
      </div>

      <!-- Recently Viewed -->
      <div v-if="recentlyViewed.length > 0" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ t('storefront.recentlyViewed') }}</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
          <div 
            v-for="item in recentlyViewed" 
            :key="item.id"
            @click="navigateToProduct(item.id)"
            class="cursor-pointer bg-white rounded-lg border border-gray-200 p-3 hover:border-green-500 hover:shadow-md transition-all"
          >
            <div class="h-24 bg-gray-100 rounded-lg flex items-center justify-center mb-2">
              <img v-if="item.image" :src="getImageUrl(item.image)" class="w-full h-full object-contain" />
            </div>
            <p class="text-xs text-gray-700 line-clamp-2 mb-1">{{ tp(item.name) }}</p>
            <p class="text-sm font-bold text-green-600">ETB {{ formatPrice(item.price) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="text-center py-20">
      <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <span class="text-5xl">⚠️</span>
      </div>
      <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ t('storefront.productNotFound') }}</h3>
      <p class="text-gray-500 mb-6">{{ t('storefront.productNotFoundDesc') }}</p>
      <button @click="$router.push('/store/products')" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all">
        {{ t('storefront.browseProducts') }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTranslation } from '@/composables/useTranslation'
import { useProductTranslation } from '@/composables/useProductTranslation'
import { storefrontApi } from '@/services/api'
import { useCartStore } from '@/stores/cart'
import { useToastStore } from '@/stores/toast'

const { t } = useTranslation()
const { tp, tc } = useProductTranslation()
const { tp, tc } = useProductTranslation()
const route = useRoute()
const router = useRouter()
const cartStore = useCartStore()
const toast = useToastStore()

const loading = ref(true)
const product = ref(null)
const quantity = ref(1)
const selectedImage = ref(null)
const activeTab = ref('description')
const relatedProducts = ref([])
const isInWishlist = ref(false)
const recentlyViewed = ref([])
const reviewsSection = ref(null)

// Mock data
const rating = ref(4.5)
const reviewCount = ref(128)
const soldCount = ref(250)
const originalPrice = ref(0)
const discountPercent = ref(0)
const isNewProduct = ref(true)

const bulkDiscounts = ref([
  { min: 5, percent: 5 },
  { min: 10, percent: 10 },
  { min: 20, percent: 15 }
])

const reviews = ref([
  { id: 1, author: 'John Doe', rating: 5, date: '2 days ago', comment: 'Excellent product! Highly recommended. The quality is outstanding and delivery was fast.' },
  { id: 2, author: 'Jane Smith', rating: 4, date: '1 week ago', comment: 'Good quality, fast delivery. Very satisfied with my purchase.' },
  { id: 3, author: 'Mike Johnson', rating: 5, date: '2 weeks ago', comment: 'Perfect! Exactly what I needed. Will buy again.' }
])

const tabs = [
  { id: 'description', label: t('storefront.description') },
  { id: 'specifications', label: t('storefront.specifications') },
  { id: 'reviews', label: t('storefront.reviewsCount', { count: reviewCount.value }) },
  { id: 'qa', label: t('storefront.questionsAnswers') }
]

const productImages = computed(() => {
  if (!product.value?.image) return []
  return [product.value.image]
})

const estimatedDelivery = computed(() => {
  const date = new Date()
  date.setDate(date.getDate() + 3)
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
})

const fetchProduct = async () => {
  try {
    loading.value = true
    const res = await storefrontApi.getProduct(route.params.id)
    product.value = res.data
    selectedImage.value = product.value.image
    
    // Calculate discount
    originalPrice.value = product.value.price * 1.2
    discountPercent.value = Math.round(((originalPrice.value - product.value.price) / originalPrice.value) * 100)
    
    // Add to recently viewed
    addToRecentlyViewed(product.value)
    
    // Fetch related products
    if (product.value.category?.id) {
      fetchRelatedProducts(product.value.category.id)
    }
  } catch (error) {
    toast.error('Failed to load product details')
    product.value = null
  } finally {
    loading.value = false
  }
}

const fetchRelatedProducts = async (categoryId) => {
  try {
    const res = await storefrontApi.getProducts({ category_id: categoryId, per_page: 5 })
    relatedProducts.value = (res.data?.data || res.data || [])
      .filter(p => p.id !== product.value.id)
      .slice(0, 5)
  } catch (error) {
    console.error('Failed to load related products')
  }
}

const addToRecentlyViewed = (prod) => {
  let viewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]')
  viewed = viewed.filter(item => item.id !== prod.id)
  viewed.unshift({ id: prod.id, name: prod.name, price: prod.price, image: prod.image })
  viewed = viewed.slice(0, 6)
  localStorage.setItem('recentlyViewed', JSON.stringify(viewed))
  recentlyViewed.value = viewed
}

const increaseQuantity = () => {
  if (quantity.value < product.value.quantity) {
    quantity.value++
  }
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

const addToCart = () => {
  if (!product.value.quantity || product.value.quantity < 1) return
  
  cartStore.addItem(product.value, quantity.value)
  toast.success(`✅ ${quantity.value} × ${tp(product.value.name)} added to cart!`)
}

const buyNow = () => {
  if (!product.value.quantity || product.value.quantity < 1) return
  
  cartStore.addItem(product.value, quantity.value)
  router.push('/store/checkout')
}

const toggleWishlist = () => {
  isInWishlist.value = !isInWishlist.value
  if (isInWishlist.value) {
    toast.success('❤️ Added to wishlist!')
  } else {
    toast.info('Removed from wishlist')
  }
}

const shareProduct = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: tp(product.value.name),
        text: `Check out ${tp(product.value.name)} on Smart SuperMarket`,
        url: window.location.href
      })
    } catch (error) {
      copyToClipboard()
    }
  } else {
    copyToClipboard()
  }
}

const copyToClipboard = () => {
  navigator.clipboard.writeText(window.location.href)
  toast.success('🔗 Link copied to clipboard!')
}

const compareProduct = () => {
  toast.info('🔄 Compare feature coming soon!')
}

const askQuestion = () => {
  toast.info('💬 Q&A feature coming soon!')
}

const openImageZoom = () => {
  toast.info('🔍 Image zoom feature coming soon!')
}

const scrollToReviews = () => {
  activeTab.value = 'reviews'
  setTimeout(() => {
    reviewsSection.value?.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }, 100)
}

const navigateToProduct = (productId) => {
  router.push(`/store/products/${productId}`)
  quantity.value = 1
  activeTab.value = 'description'
  window.scrollTo({ top: 0, behavior: 'smooth' })
  fetchProduct()
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

const getStarPercentage = (star) => {
  const distribution = { 5: 70, 4: 20, 3: 7, 2: 2, 1: 1 }
  return distribution[star] || 0
}

const getStarCount = (star) => {
  const distribution = { 5: 90, 4: 26, 3: 9, 2: 2, 1: 1 }
  return distribution[star] || 0
}

onMounted(() => {
  fetchProduct()
  const viewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]')
  recentlyViewed.value = viewed.filter(item => item.id !== parseInt(route.params.id))
})
</script>
