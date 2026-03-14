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
          <span class="flex items-center gap-1">🔒 {{ t('storefront.secureCheckout') }}</span>
          <span class="hidden md:flex items-center gap-1">✓ 100% Secure Payment</span>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="bg-white shadow-md sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
          <router-link to="/store/cart" class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ t('storefront.backToCart') }}
          </router-link>
          
          <div class="flex items-center gap-3">
            <!-- Language Switcher -->
            <LanguageSwitcher />
            
            <!-- Logo -->
            <div class="flex items-center gap-2">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-lg flex items-center justify-center shadow-lg">
                <span class="text-xl">🏪</span>
              </div>
              <div class="hidden sm:block">
                <span class="font-bold text-gray-800 text-sm">Smart SuperMarket</span>
                <p class="text-xs text-gray-500">{{ t('storefront.yourCity') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Ethiopian Flag -->
      <div class="flex h-1">
        <div class="flex-1 bg-green-500"></div>
        <div class="flex-1 bg-yellow-500"></div>
        <div class="flex-1 bg-red-500"></div>
      </div>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white border-b shadow-sm">
      <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-center gap-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">✓</div>
            <span class="text-green-600 text-sm font-semibold hidden sm:inline">{{ t('storefront.cart') }}</span>
          </div>
          <div class="w-12 sm:w-20 h-1 bg-green-500 rounded"></div>
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md animate-pulse">2</div>
            <span class="text-green-600 text-sm font-semibold hidden sm:inline">{{ t('storefront.checkout') }}</span>
          </div>
          <div class="w-12 sm:w-20 h-1 bg-gray-200 rounded"></div>
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">3</div>
            <span class="text-gray-500 text-sm font-medium hidden sm:inline">{{ t('storefront.complete') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ t('storefront.checkoutTitle') }}</h1>
        <p class="text-gray-600">{{ t('storefront.completeYourOrder') }}</p>
      </div>

      <!-- Empty Cart State -->
      <div v-if="cart.length === 0" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ t('storefront.yourCartIsEmpty') }}</h2>
        <p class="text-gray-600 mb-8">{{ t('storefront.addItemsToCheckout') }}</p>
        <router-link to="/store/products" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:from-green-700 hover:to-emerald-700 shadow-lg hover:shadow-xl transition-all">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          {{ t('storefront.continueShopping') }}
        </router-link>
      </div>

      <div v-else class="grid lg:grid-cols-2 gap-4">
        <!-- Left Column: Order Summary, Contact, Delivery -->
        <div class="space-y-4">
          <!-- Collapsible Order Summary with Edit -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button @click="orderSummaryExpanded = !orderSummaryExpanded" class="w-full p-3 border-b bg-gradient-to-r from-green-600 to-emerald-600 text-white flex items-center justify-between hover:from-green-700 hover:to-emerald-700 transition-all">
              <h2 class="text-sm font-bold flex items-center gap-2">
                <span>📦</span> {{ t('storefront.orderSummary') }} ({{ cart.length }} {{ t('storefront.items') }})
              </h2>
              <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': orderSummaryExpanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="orderSummaryExpanded" class="divide-y max-h-80 overflow-y-auto">
              <div v-for="item in cart" :key="item.id" class="flex items-center gap-3 p-3 hover:bg-green-50 transition-colors group">
                <router-link :to="`/store/products/${item.id}`" class="w-14 h-14 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg flex items-center justify-center p-2 flex-shrink-0 hover:scale-110 transition-transform">
                  <img :src="getImageUrl(item.image)" class="max-h-full max-w-full object-contain" />
                </router-link>
                <div class="flex-1 min-w-0">
                  <router-link :to="`/store/products/${item.id}`" class="font-semibold text-gray-800 text-sm truncate hover:text-green-600 block">{{ tp(item.name) }}</router-link>
                  <div class="flex items-center gap-2 mt-1">
                    <button @click="updateCartQuantity(item.id, item.qty - 1)" class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-xs font-bold">−</button>
                    <span class="text-gray-600 text-xs font-medium">{{ item.qty }}</span>
                    <button @click="updateCartQuantity(item.id, item.qty + 1)" class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-xs font-bold">+</button>
                    <button @click="removeFromCart(item.id)" class="ml-auto text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                </div>
                <p class="font-bold text-green-600 text-sm flex-shrink-0">ETB {{ formatCurrency(item.price * item.qty) }}</p>
              </div>
            </div>
          </div>

          <!-- Delivery Method with Time Slots -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-3 border-b">
              <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <span>🚚</span> {{ t('storefront.deliveryMethod') }}
              </h2>
            </div>
            <div class="p-3 space-y-2">
              <label v-for="method in deliveryMethods" :key="method.value" class="flex items-center gap-3 p-2.5 border-2 rounded-lg cursor-pointer transition-all hover:border-green-400 hover:shadow-md" :class="deliveryMethod === method.value ? 'border-green-600 bg-green-50 shadow-md' : 'border-gray-200'">
                <input type="radio" v-model="deliveryMethod" :value="method.value" class="hidden" />
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl flex-shrink-0 shadow-sm" :class="method.bgColor">
                  {{ method.icon }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-bold text-gray-800 text-sm">{{ method.label }}</p>
                  <p class="text-xs text-gray-500 mt-0.5">{{ method.desc }}</p>
                  <p v-if="method.estimatedTime" class="text-xs text-green-600 mt-1 font-medium">⏱️ {{ method.estimatedTime }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                  <p class="font-bold text-green-600 text-sm mb-1.5">{{ method.cost === 0 ? t('storefront.free') : 'ETB ' + method.cost }}</p>
                  <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center mx-auto transition-all" :class="deliveryMethod === method.value ? 'border-green-600 bg-green-600 scale-110' : 'border-gray-300'">
                    <span v-if="deliveryMethod === method.value" class="text-white text-xs">✓</span>
                  </div>
                </div>
              </label>
            </div>
            
            <!-- Delivery Time Slot (shown for delivery methods) -->
            <div v-if="needsAddress && deliveryMethod !== 'self_pickup'" class="px-3 pb-3">
              <label class="text-xs text-gray-700 font-medium block mb-2">⏰ Preferred Delivery Time</label>
              <select v-model="deliveryTimeSlot" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all">
                <option value="">Select time slot</option>
                <option value="morning">Morning (8:00 AM - 12:00 PM)</option>
                <option value="afternoon">Afternoon (12:00 PM - 4:00 PM)</option>
                <option value="evening">Evening (4:00 PM - 8:00 PM)</option>
                <option value="anytime">Anytime (Flexible)</option>
              </select>
            </div>
          </div>

          <!-- Delivery Address (shown only if delivery is selected) -->
          <div v-if="needsAddress" class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-3 border-b">
              <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <span>📍</span> {{ t('storefront.deliveryAddress') }} <span class="text-xs text-red-500">*</span>
              </h2>
            </div>
            <div class="p-3 space-y-3">
              <!-- Saved Addresses -->
              <div v-if="savedAddresses.length > 0" class="mb-3">
                <label class="text-xs text-gray-700 font-medium block mb-2">📋 Use Saved Address</label>
                <select v-model="selectedSavedAddress" @change="useSavedAddress" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all">
                  <option value="">Select a saved address</option>
                  <option v-for="(addr, idx) in savedAddresses" :key="idx" :value="idx">{{ addr.label }}</option>
                </select>
              </div>
              
              <div>
                <label class="text-sm text-gray-700 font-medium block mb-1.5">{{ t('storefront.streetAddress') }} *</label>
                <textarea v-model="address" rows="2" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all resize-none" :placeholder="t('storefront.enterStreetAddress')" required></textarea>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="text-sm text-gray-700 font-medium block mb-1.5">{{ t('storefront.cityRegion') }} *</label>
                  <input v-model="city" type="text" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all" :placeholder="t('storefront.enterCity')" required />
                </div>
                <div>
                  <label class="text-sm text-gray-700 font-medium block mb-1.5">Postal Code</label>
                  <input v-model="postalCode" type="text" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all" placeholder="Optional" />
                </div>
              </div>
              <div>
                <label class="text-sm text-gray-700 font-medium block mb-1.5">{{ t('storefront.deliveryInstructions') }} <span class="text-xs text-gray-400">({{ t('storefront.optional') }})</span></label>
                <textarea v-model="deliveryInstructions" rows="2" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all resize-none" :placeholder="t('storefront.enterDeliveryInstructions')"></textarea>
              </div>
              <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" v-model="saveAddress" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                <span>💾 Save this address for future orders</span>
              </label>
            </div>
          </div>

          <!-- Gift Options -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button @click="giftOptionsExpanded = !giftOptionsExpanded" class="w-full p-3 border-b flex items-center justify-between hover:bg-gray-50 transition-all">
              <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <span>🎁</span> Gift Options <span class="text-xs text-gray-400">(Optional)</span>
              </h2>
              <svg class="w-5 h-5 transition-transform text-gray-400" :class="{ 'rotate-180': giftOptionsExpanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="giftOptionsExpanded" class="p-3 space-y-3">
              <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" v-model="isGift" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                <span>🎁 This is a gift</span>
              </label>
              <div v-if="isGift" class="space-y-3 pl-6 border-l-2 border-green-200">
                <div>
                  <label class="text-sm text-gray-700 font-medium block mb-1.5">Gift Message</label>
                  <textarea v-model="giftMessage" rows="3" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all resize-none" placeholder="Write a personal message..."></textarea>
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                  <input type="checkbox" v-model="giftWrap" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                  <span>📦 Add gift wrapping (+ETB 25)</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: Payment Method & Order Total -->
        <div class="space-y-4">
          <!-- Payment Method -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-3 border-b">
              <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <span>💳</span> {{ t('storefront.paymentMethod') }}
              </h2>
            </div>
            <div class="p-3 space-y-2">
              <label v-for="method in paymentMethods" :key="method.value" class="flex items-center gap-3 p-2.5 border-2 rounded-lg cursor-pointer transition-all" :class="[
                paymentMethod === method.value ? 'border-green-600 bg-green-50 shadow-md' : 'border-gray-200',
                !method.available ? 'opacity-60 cursor-not-allowed' : 'hover:border-green-400 hover:shadow-md'
              ]">
                <input type="radio" v-model="paymentMethod" :value="method.value" :disabled="!method.available" class="hidden" />
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl flex-shrink-0 shadow-sm" :class="method.bgColor">
                  {{ method.icon }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-bold text-gray-800 text-sm">{{ method.label }}</p>
                  <p class="text-xs truncate mt-0.5" :class="method.available ? 'text-gray-500' : 'text-orange-600'">{{ method.desc }}</p>
                  <div v-if="method.available && method.features" class="flex gap-1 mt-1">
                    <span v-for="feature in method.features" :key="feature" class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">{{ feature }}</span>
                  </div>
                </div>
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all" :class="paymentMethod === method.value ? 'border-green-600 bg-green-600 scale-110' : 'border-gray-300'">
                  <span v-if="paymentMethod === method.value" class="text-white text-xs">✓</span>
                </div>
              </label>
            </div>
            
            <!-- Split Payment Option -->
            <div class="px-3 pb-3">
              <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition-all">
                <input type="checkbox" v-model="splitPayment" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                <span>💰 Split payment (Coming Soon)</span>
              </label>
            </div>
          </div>

          <!-- Coupon & Loyalty Points -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <button @click="discountsExpanded = !discountsExpanded" class="w-full p-3 border-b flex items-center justify-between hover:bg-gray-50 transition-all">
              <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <span>🎟️</span> Discounts & Rewards
              </h2>
              <svg class="w-5 h-5 transition-transform text-gray-400" :class="{ 'rotate-180': discountsExpanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="discountsExpanded" class="p-3 space-y-3">
              <div>
                <label class="text-sm text-gray-700 font-medium block mb-1.5">🎫 Promo Code</label>
                <div class="flex gap-2">
                  <input v-model="promoCode" type="text" class="flex-1 border-2 border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all" placeholder="Enter code" />
                  <button @click="applyPromo" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-all shadow-md">Apply</button>
                </div>
                <p v-if="promoApplied" class="text-xs text-green-600 mt-1.5">✅ Promo code applied!</p>
              </div>
              <div>
                <label class="text-sm text-gray-700 font-medium block mb-1.5">⭐ Loyalty Points (Coming Soon)</label>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                  <span class="text-sm text-gray-600">Available: 0 points</span>
                  <span class="text-xs text-gray-500">= ETB 0.00</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Total -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
            <div class="p-3 border-b bg-gradient-to-r from-green-600 to-emerald-600 text-white">
              <h2 class="text-sm font-bold flex items-center gap-2">
                <span>🧾</span> {{ t('storefront.orderTotal') }}
              </h2>
            </div>
            <div class="p-4 space-y-3">
              <!-- Progress Indicator -->
              <div class="mb-4">
                <div class="flex justify-between text-xs text-gray-600 mb-1">
                  <span>Order Completion</span>
                  <span class="font-semibold">{{ completionPercentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                  <div class="bg-gradient-to-r from-green-600 to-emerald-600 h-2 rounded-full transition-all duration-500" :style="{ width: completionPercentage + '%' }"></div>
                </div>
              </div>
              
              <div class="flex justify-between text-gray-700 text-sm">
                <span>{{ t('storefront.subtotalItems', { count: cart.length }) }}</span>
                <span class="font-semibold">ETB {{ formatCurrency(cartTotal) }}</span>
              </div>
              <div class="flex justify-between text-gray-700 text-sm">
                <span>{{ t('storefront.delivery') }}</span>
                <span class="font-semibold" :class="deliveryCost === 0 ? 'text-green-600' : 'text-gray-800'">
                  {{ deliveryCost === 0 ? t('storefront.free') : 'ETB ' + formatCurrency(deliveryCost) }}
                </span>
              </div>
              <div v-if="giftWrap" class="flex justify-between text-gray-700 text-sm">
                <span>🎁 Gift Wrapping</span>
                <span class="font-semibold">ETB 25.00</span>
              </div>
              <div class="flex justify-between text-gray-700 text-sm">
                <div class="flex items-center gap-2">
                  <span>{{ t('storefront.vat') }} (15%)</span>
                  <span v-if="!cart.value || cart.value.length === 0" class="text-xs text-gray-400">(Optional)</span>
                </div>
                <span class="font-semibold" :class="taxAmount > 0 ? 'text-gray-900' : 'text-gray-400'">
                  ETB {{ formatCurrency(taxAmount) }}
                </span>
              </div>
              <p v-if="taxAmount === 0" class="text-xs text-orange-600 -mt-1 flex items-center gap-1">
                <span>⚠️</span>
                <span>VAT not included. Enable in cart if required.</span>
              </p>
              <div v-if="promoDiscount > 0" class="flex justify-between text-green-600 text-sm">
                <span>🎟️ Promo Discount</span>
                <span class="font-semibold">-ETB {{ formatCurrency(promoDiscount) }}</span>
              </div>
              <div class="border-t pt-3">
                <div class="flex justify-between text-lg font-bold">
                  <span class="text-gray-800">{{ t('storefront.total') }}</span>
                  <span class="text-green-600">ETB {{ formatCurrency(grandTotal) }}</span>
                </div>
                <p class="text-xs text-right mt-1" :class="taxAmount > 0 ? 'text-gray-600' : 'text-orange-600'">
                  {{ taxAmount > 0 ? '✓ Including VAT (15%)' : '⚠️ Excluding VAT' }}
                </p>
              </div>

              <!-- Order Notifications -->
              <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 space-y-2">
                <p class="text-xs text-blue-800 font-medium">📧 Order Notifications</p>
                <div class="text-xs text-blue-700 space-y-1">
                  <p>📧 Email: {{ auth.user?.email }}</p>
                  <p v-if="auth.user?.phone">📱 Phone: {{ auth.user.phone }}</p>
                  <p v-else class="text-red-600">⚠️ Phone number missing - required for payment</p>
                </div>
                <label class="flex items-center gap-2 text-xs text-blue-700 cursor-pointer">
                  <input type="checkbox" v-model="sendEmailConfirmation" checked class="w-3 h-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                  <span>Send email confirmation</span>
                </label>
                <label class="flex items-center gap-2 text-xs text-blue-700 cursor-pointer">
                  <input type="checkbox" v-model="sendSmsConfirmation" class="w-3 h-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                  <span>Send SMS updates</span>
                </label>
              </div>

              <div v-if="!auth.isAuthenticated" class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg p-3 text-xs">
                <p class="font-semibold mb-1">⚠️ {{ t('storefront.pleaseLoginToContinue') }}</p>
                <router-link to="/login" class="text-green-600 underline font-medium">{{ t('storefront.clickHereToLogin') }}</router-link>
              </div>

              <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 flex items-center gap-2 text-xs">
                <span>❌</span>
                <span>{{ error }}</span>
              </div>

              <button @click="placeOrder" :disabled="ordering || !isFormValid" class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:via-yellow-400 hover:to-red-500 text-white rounded-lg font-bold text-sm transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95">
                <span v-if="ordering" class="animate-spin">⏳</span>
                <span v-else>✓</span>
                <span>{{ ordering ? t('storefront.processing') : t('storefront.placeOrder') }}</span>
              </button>
              
              <!-- Validation Messages -->
              <div class="space-y-1">
                <p v-if="!auth.isAuthenticated" class="text-center text-red-500 text-xs">
                  {{ t('storefront.pleaseLoginToContinue') }}
                </p>
                <p v-else-if="needsAddress && (!address || !city)" class="text-center text-red-500 text-xs">
                  {{ t('storefront.pleaseEnterDeliveryAddress') }}
                </p>
                <p v-else-if="!isPaymentMethodAvailable" class="text-center text-orange-600 text-xs">
                  {{ t('storefront.paymentMethodNotAvailable') }}
                </p>
              </div>

              <!-- Trust Badges -->
              <div class="pt-3 border-t space-y-2">
                <div class="flex items-center gap-2 text-xs text-gray-600">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  <span>🔒 {{ t('storefront.yourPaymentIsSecure') }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  <span>Free Returns within 7 days</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                  <span>24/7 Customer Support</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div v-if="orderSuccess" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl">
        <div class="w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
          <span class="text-5xl">🎉</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ t('storefront.orderPlaced') }}</h3>
        <p class="text-gray-500 mb-2">{{ t('storefront.orderPlacedAmharic') }}</p>
        <p class="text-gray-600 mb-2">{{ t('storefront.thankYouForShopping') }}</p>
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 mb-6">
          <p class="text-sm text-gray-500">{{ t('storefront.orderNumber') }} / {{ t('storefront.orderNumberAmharic') }}</p>
          <p class="text-xl font-bold text-green-600">{{ orderNumber }}</p>
        </div>
        <div class="space-y-3">
          <router-link to="/store" class="block w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:via-yellow-400 hover:to-red-500 text-white rounded-xl font-bold transition-all shadow-lg">
            🛍️ {{ t('storefront.continueShopping') }}
          </router-link>
          <router-link to="/store/my-orders" class="block w-full py-4 border-2 border-green-600 text-green-600 hover:bg-green-50 rounded-xl font-bold transition-all">
            📋 {{ t('storefront.viewMyOrders') }} / {{ t('storefront.viewMyOrdersAmharic') }}
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import { storefrontApi, authApi } from '../../services/api'
import { useAuthStore } from '../../stores/auth'
import { useCartStore } from '../../stores/cart'
import { useI18nStore } from '../../stores/i18n'
import { useTranslation } from '../../composables/useTranslation'
import { useProductTranslation } from '../../composables/useProductTranslation'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'

const router = useRouter()
const { t } = useTranslation()
const { tp, tc } = useProductTranslation()
const auth = useAuthStore()
const cartStore = useCartStore()
const i18n = useI18nStore()
const { t } = useTranslation()

// Force reactivity by watching the locale
const currentLocale = computed(() => i18n.currentLocale)

// Watch for locale changes and force component update
watch(currentLocale, (newLocale) => {
  console.log('Locale changed in checkout:', newLocale)
  // Force re-render by updating a reactive property
  nextTick(() => {
    // This will trigger reactivity
  })
})

const cart = computed(() => cartStore.items.map(item => ({
  id: item.id,
  name: item.name,
  price: item.price,
  qty: item.quantity,
  image: item.image
})))

const paymentMethod = ref('chapa')
const deliveryMethod = ref('self_pickup')
const email = ref('')
const phone = ref('')
const address = ref('')
const city = ref('')
const postalCode = ref('')
const deliveryInstructions = ref('')
const deliveryTimeSlot = ref('')
const ordering = ref(false)
const error = ref('')
const orderSuccess = ref(false)
const orderNumber = ref('')

// UI State
const orderSummaryExpanded = ref(true)
const giftOptionsExpanded = ref(false)
const discountsExpanded = ref(false)

// Gift Options
const isGift = ref(false)
const giftMessage = ref('')
const giftWrap = ref(false)

// Discounts
const promoCode = ref('')
const promoApplied = ref(false)
const promoDiscount = ref(0)

// Address Management
const savedAddresses = ref([
  { label: 'Home - Bole, Addis Ababa', address: 'Bole Road, Near Edna Mall', city: 'Addis Ababa' },
  { label: 'Office - Megenagna', address: 'Megenagna, CMC Area', city: 'Addis Ababa' }
])
const selectedSavedAddress = ref('')
const saveAddress = ref(false)

// Notifications
const sendEmailConfirmation = ref(true)
const sendSmsConfirmation = ref(false)
const splitPayment = ref(false)

const paymentMethods = computed(() => [
  { 
    value: 'chapa', 
    label: 'Chapa Gateway', 
    desc: 'Fast & Secure Payment - Available Now', 
    icon: '💳', 
    bgColor: 'bg-green-100', 
    available: true,
    features: ['Instant', 'Secure', 'Available']
  },
  { 
    value: 'telebirr', 
    label: 'Telebirr', 
    desc: 'Pay with Telebirr - Coming Soon', 
    icon: '📱', 
    bgColor: 'bg-orange-100', 
    available: false 
  },
  { 
    value: 'cbe_birr', 
    label: 'CBE Birr', 
    desc: 'Commercial Bank of Ethiopia - Coming Soon', 
    icon: '🏦', 
    bgColor: 'bg-blue-100', 
    available: false 
  },
  { 
    value: 'mobile_banking', 
    label: 'Mobile Banking', 
    desc: 'Pay via Mobile Banking - Coming Soon', 
    icon: '📲', 
    bgColor: 'bg-purple-100', 
    available: false 
  },
])

const deliveryMethods = computed(() => [
  { 
    value: 'self_pickup', 
    label: t('storefront.selfPickup'), 
    desc: t('storefront.pickupFromStore'), 
    icon: '🏪', 
    bgColor: 'bg-green-100', 
    cost: 0,
    estimatedTime: 'Ready in 2 hours'
  },
  { 
    value: 'standard_delivery', 
    label: t('storefront.standardDelivery'), 
    desc: t('storefront.delivery2to3Days'), 
    icon: '🚚', 
    bgColor: 'bg-blue-100', 
    cost: 50,
    estimatedTime: '2-3 business days'
  },
  { 
    value: 'express_delivery', 
    label: t('storefront.expressDelivery'), 
    desc: t('storefront.sameDayDelivery'), 
    icon: '⚡', 
    bgColor: 'bg-yellow-100', 
    cost: 100,
    estimatedTime: 'Same day delivery'
  },
  { 
    value: 'dhl', 
    label: 'DHL Express', 
    desc: t('storefront.internationalShipping'), 
    icon: '✈️', 
    bgColor: 'bg-red-100', 
    cost: 500,
    estimatedTime: '3-5 business days'
  },
  { 
    value: 'fedex', 
    label: 'FedEx', 
    desc: t('storefront.worldwideDelivery'), 
    icon: '📦', 
    bgColor: 'bg-purple-100', 
    cost: 450,
    estimatedTime: '4-6 business days'
  },
])

const selectedDelivery = computed(() => {
  return deliveryMethods.value.find(d => d.value === deliveryMethod.value)
})

const selectedPaymentMethod = computed(() => {
  return paymentMethods.value.find(p => p.value === paymentMethod.value)
})

const isPaymentMethodAvailable = computed(() => {
  return selectedPaymentMethod.value?.available || false
})

const isFormValid = computed(() => {
  return auth.isAuthenticated && 
         (!needsAddress.value || (address.value && city.value)) &&
         isPaymentMethodAvailable.value
})

const deliveryCost = computed(() => selectedDelivery.value?.cost || 0)

const needsAddress = computed(() => deliveryMethod.value !== 'self_pickup')

const cartTotal = computed(() => cart.value.reduce((sum, item) => sum + (item.price * item.qty), 0))

const giftWrapCost = computed(() => giftWrap.value ? 25 : 0)

const subtotalWithDelivery = computed(() => cartTotal.value + deliveryCost.value + giftWrapCost.value)
const taxAmount = computed(() => {
  // Use the cart store's VAT setting
  if (!cartStore.includeVAT) return 0
  return subtotalWithDelivery.value * 0.15
})
const grandTotal = computed(() => subtotalWithDelivery.value + taxAmount.value - promoDiscount.value)

// Completion percentage for progress bar
const completionPercentage = computed(() => {
  let progress = 0
  if (auth.isAuthenticated) progress += 25
  if (deliveryMethod.value) progress += 25
  if (!needsAddress.value || (address.value && city.value)) progress += 25
  if (paymentMethod.value && isPaymentMethodAvailable.value) progress += 25
  return progress
})

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })

const isValidPhone = (phoneNumber) => {
  if (!phoneNumber) return false
  const cleaned = phoneNumber.replace(/[\s\-\(\)]/g, '')
  return /^(\+?251|0)?[79]\d{8}$/.test(cleaned)
}

const getImageUrl = (image) => {
  if (!image) return '/images/products/default.jpg'
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `/storage/${image}`
}

const translateError = (errorMsg) => {
  if (errorMsg && errorMsg.includes('validation.')) {
    const key = errorMsg.replace('validation.', '')
    const translated = i18n.t(`validation.${key}`)
    if (translated && translated !== `validation.${key}`) {
      return translated
    }
  }
  return errorMsg
}

// Cart Management Functions
const updateCartQuantity = (productId, newQty) => {
  if (newQty < 1) {
    removeFromCart(productId)
  } else {
    cartStore.updateQuantity(productId, newQty)
  }
}

const removeFromCart = (productId) => {
  cartStore.removeItem(productId)
  if (cart.value.length === 0) {
    router.push('/store/cart')
  }
}

// Saved Address Functions
const useSavedAddress = () => {
  if (selectedSavedAddress.value !== '') {
    const addr = savedAddresses.value[selectedSavedAddress.value]
    address.value = addr.address
    city.value = addr.city
  }
}

// Promo Code Function
const applyPromo = () => {
  if (!promoCode.value) return
  
  // Simulate promo code validation (replace with actual API call)
  const validCodes = {
    'SAVE10': 10,
    'WELCOME': 50,
    'FIRST': 25
  }
  
  if (validCodes[promoCode.value.toUpperCase()]) {
    promoDiscount.value = validCodes[promoCode.value.toUpperCase()]
    promoApplied.value = true
  } else {
    promoApplied.value = false
    promoDiscount.value = 0
    error.value = 'Invalid promo code'
    setTimeout(() => error.value = '', 3000)
  }
}

const placeOrder = async () => {
  if (!auth.isAuthenticated) {
    error.value = t('storefront.pleaseLoginToContinue')
    setTimeout(() => router.push('/login'), 2000)
    return
  }

  // Validate phone number (required for Chapa payment)
  if (!auth.user?.phone || auth.user.phone.trim() === '') {
    error.value = 'Phone number is required for payment. Please update your profile with a valid phone number.'
    setTimeout(() => router.push('/store/profile'), 2000)
    return
  }

  // Validate delivery address if needed
  if (needsAddress.value && (!address.value || !city.value)) {
    error.value = t('storefront.pleaseEnterDeliveryAddress')
    return
  }

  // Validate payment method availability
  if (!isPaymentMethodAvailable.value) {
    error.value = t('storefront.paymentMethodNotAvailable')
    return
  }

  // Only allow Chapa payments for now
  if (paymentMethod.value !== 'chapa') {
    error.value = t('storefront.onlyChapaAvailable')
    return
  }

  ordering.value = true
  error.value = ''

  try {
    const fullAddress = needsAddress.value 
      ? `${address.value}, ${city.value}${postalCode.value ? ', ' + postalCode.value : ''}${deliveryInstructions.value ? ' - ' + deliveryInstructions.value : ''}`
      : 'Self Pickup - No delivery needed'

    const checkoutData = {
      items: cart.value.map(item => ({ 
        product_id: item.id, 
        quantity: item.qty 
      })),
      payment_method: paymentMethod.value,
      delivery_method: deliveryMethod.value,
      shipping_address: fullAddress,
      phone: auth.user.phone,
      delivery_time_slot: deliveryTimeSlot.value || null,
      is_gift: isGift.value,
      gift_message: isGift.value ? giftMessage.value : null,
      gift_wrap: giftWrap.value,
      promo_code: promoApplied.value ? promoCode.value : null,
      send_email: sendEmailConfirmation.value,
      send_sms: sendSmsConfirmation.value
    }

    console.log('Checkout data:', checkoutData)

    const response = await storefrontApi.checkout(checkoutData)
    console.log('Checkout response:', response)
    
    if (response.success && response.data) {
      const { order, payment } = response.data
      
      if (order && order.id) {
        localStorage.setItem('pending_order_id', order.id)
      }
      
      if (paymentMethod.value === 'chapa' && payment && payment.checkout_url) {
        console.log('Redirecting to Chapa:', payment.checkout_url)
        window.location.href = payment.checkout_url
        return
      } else if (paymentMethod.value === 'chapa') {
        error.value = 'Failed to initialize Chapa payment. Please try again or use another payment method.'
        ordering.value = false
        return
      } else {
        orderNumber.value = order?.order_number || 'ORD-' + Date.now()
        orderSuccess.value = true
        cartStore.clear()
      }
    }
  } catch (e) {
    console.error('Order error:', e)
    
    if (e.message === 'Unauthenticated.' || e.message?.includes('Unauthenticated')) {
      error.value = 'Your session has expired. Please login again.'
      setTimeout(() => {
        auth.logout()
        router.push('/login')
      }, 2000)
      return
    }
    
    const errorMsg = e.message || 'Failed to place order. Please try again.'
    error.value = translateError(errorMsg)
  } finally {
    ordering.value = false
  }
}

onMounted(async () => {
  if (!auth.isAuthenticated) {
    router.push('/login')
  } else {
    // Fetch latest user data including phone number from database
    try {
      await auth.fetchUser()
      
      // Validate phone number exists
      if (!auth.user?.phone || auth.user.phone.trim() === '') {
        error.value = 'Phone number is required for checkout. Please update your profile.'
      }
    } catch (e) {
      auth.logout()
      router.push('/login')
    }
  }
})
</script>
