<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Top Bar - Enhanced -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm py-2.5 shadow-md">
      <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4 lg:gap-6">
          <span class="flex items-center gap-1.5 hover:text-yellow-300 transition-colors cursor-pointer">
            <span class="text-base">📞</span>
            <span class="hidden sm:inline">{{ t('common.phoneNumber') }}</span>
          </span>
          <span class="hidden md:flex items-center gap-1.5 hover:text-yellow-300 transition-colors cursor-pointer">
            <span class="text-base">📧</span>
            <span>{{ t('common.email') }}</span>
          </span>
        </div>
        <div class="flex items-center gap-4 lg:gap-6">
          <span class="flex items-center gap-1.5 bg-white/10 px-3 py-1 rounded-full">
            <span class="text-base">🚚</span>
            <span class="hidden sm:inline">{{ t('storefront.freeDeliveryDesc') }}</span>
            <span class="sm:hidden">{{ t('storefront.freeDeliveryTitle') }}</span>
          </span>
          <span class="hidden md:flex items-center gap-1.5">
            <span class="text-base">🔒</span>
            <span>{{ t('storefront.securePaymentTitle') }}</span>
          </span>
        </div>
      </div>
    </div>

    <!-- Header - Enhanced -->
    <header class="bg-white/95 backdrop-blur-md shadow-xl sticky top-0 z-50 border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-4 py-3 lg:py-4">
        <div class="flex items-center justify-between">
          <!-- Revolutionary Mobile Menu Button -->
          <button @click="showMobileMenu = true" class="lg:hidden group relative w-12 h-12 rounded-xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-500 hover:via-emerald-500 hover:to-teal-500 flex items-center justify-center text-white shadow-xl hover:shadow-2xl transition-all hover:scale-105 border-2 border-green-300/50 overflow-hidden">
            <!-- Animated Background Shine -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
            
            <!-- Menu Icon with Glow -->
            <div class="relative">
              <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
              </div>
              <svg class="relative w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </div>
            
            <!-- Live Indicator -->
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
          </button>

          <router-link to="/store" class="flex items-center gap-2 lg:gap-4 group">
            <div class="w-11 h-11 lg:w-16 lg:h-16 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-xl lg:rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all group-hover:scale-105 ring-2 ring-white">
              <span class="text-2xl lg:text-4xl">🏪</span>
            </div>
            <div class="hidden sm:block">
              <h1 class="text-lg lg:text-2xl font-extrabold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ t('storefront.smartSuperMarket') }}</h1>
              <p class="text-xs lg:text-sm text-gray-500 flex items-center gap-1">
                <span>📍</span>
                <span>{{ t('storefront.smartShoppingDestination') }}</span>
              </p>
            </div>
          </router-link>
          
          <!-- AI Smart Search Bar - Enhanced -->
          <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
            <AISmartSearch @search="handleAISearch" />
          </div>
          
          <div class="flex items-center gap-2 lg:gap-3">
            <!-- Theme and Language Controls -->
            <ThemeToggle />
            <LanguageSwitcher />
            
            <!-- Revolutionary Cart Button -->
            <button @click="openCart" class="group relative p-3 lg:p-3.5 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-400 hover:via-emerald-400 hover:to-teal-400 rounded-xl lg:rounded-2xl transition-all shadow-lg hover:shadow-2xl hover:scale-105 border-2 border-green-300/50 overflow-hidden">
              <!-- Animated Background Shine -->
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
              
              <!-- Cart Icon with Glow -->
              <div class="relative">
                <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                  <span class="text-xl lg:text-2xl">🛒</span>
                </div>
                <span class="relative text-xl lg:text-2xl group-hover:scale-110 group-hover:rotate-12 transition-all inline-block">🛒</span>
              </div>
              
              <!-- Cart Count Badge -->
              <span v-if="cartCount > 0" class="absolute -top-2 -right-2 w-7 h-7 lg:w-8 lg:h-8 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs lg:text-sm rounded-full flex items-center justify-center font-black shadow-xl ring-4 ring-white animate-bounce">{{ cartCount }}</span>
              
              <!-- Live Indicator -->
              <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
            </button>
            
            <!-- Revolutionary Auth Buttons - Desktop -->
            <div v-if="!isLoggedIn" class="hidden sm:flex items-center gap-3">
              <!-- Login Button -->
              <router-link to="/login" class="group relative px-5 lg:px-6 py-2.5 lg:py-3 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-400 hover:via-emerald-400 hover:to-teal-400 text-white rounded-xl lg:rounded-2xl font-black transition-all text-sm lg:text-base shadow-lg hover:shadow-2xl hover:scale-105 border-2 border-green-300/50 overflow-hidden flex items-center gap-2">
                <!-- Animated Background Shine -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                
                <!-- Icon with Glow -->
                <div class="relative">
                  <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                    <span class="text-lg">🔐</span>
                  </div>
                  <span class="relative text-lg group-hover:scale-110 group-hover:rotate-12 transition-all inline-block">🔐</span>
                </div>
                
                <span class="relative">{{ t('auth.login') }}</span>
                
                <!-- Live Indicator -->
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
              </router-link>
              
              <!-- Register Button -->
              <router-link to="/register" class="group relative px-5 lg:px-6 py-2.5 lg:py-3 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-500 hover:via-emerald-500 hover:to-teal-500 text-white rounded-xl lg:rounded-2xl font-black transition-all shadow-xl hover:shadow-2xl text-sm lg:text-base hover:scale-105 border-2 border-green-300/50 overflow-hidden flex items-center gap-2">
                <!-- Animated Background Shine -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                
                <!-- Icon with Glow -->
                <div class="relative">
                  <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                    <span class="text-lg">📝</span>
                  </div>
                  <span class="relative text-lg group-hover:scale-110 group-hover:rotate-12 transition-all inline-block">📝</span>
                </div>
                
                <span class="relative">{{ t('auth.register') }}</span>
                
                <!-- Sparkle Effect -->
                <div class="absolute top-0 right-0 w-2 h-2 bg-yellow-300 rounded-full animate-ping"></div>
                
                <!-- Live Indicator -->
                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
              </router-link>
            </div>
            <!-- Revolutionary User Profile Button -->
            <div v-else class="relative">
              <button 
                @click="showUserMenu = !showUserMenu" 
                class="group relative flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-2.5 rounded-2xl bg-gradient-to-r from-green-50 via-emerald-50 to-teal-50 border-2 border-green-200 hover:border-green-400 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 active:scale-95 transition-all duration-300 cursor-pointer shadow-lg hover:shadow-xl overflow-hidden"
                :aria-label="`User menu for ${userName}`"
                type="button"
              >
                <!-- Animated Background -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                
                <!-- Welcome Text with Enhanced Styling -->
                <div class="relative text-right hidden md:block">
                  <p class="text-[10px] text-green-600 font-black uppercase tracking-wider flex items-center gap-1 justify-end">
                    <span class="inline-block w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    {{ t('storefront.welcomeBack') }}
                  </p>
                  <p class="font-black text-gray-800 text-sm group-hover:text-green-600 transition-colors">{{ userName }}</p>
                </div>
                
                <!-- Avatar with Glow Effect -->
                <div class="relative">
                  <!-- Glow Layer -->
                  <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl"></div>
                  </div>
                  <!-- Avatar -->
                  <div class="relative w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-black text-base lg:text-xl shadow-lg cursor-pointer group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 ring-2 ring-white">
                    {{ userName.charAt(0).toUpperCase() }}
                  </div>
                </div>
                
                <!-- Animated Arrow -->
                <svg 
                  class="relative w-4 h-4 text-green-600 hidden sm:block transition-all duration-300" 
                  :class="{ 'rotate-180 text-emerald-600': showUserMenu }"
                  fill="none" 
                  stroke="currentColor" 
                  viewBox="0 0 24 24"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                </svg>
                
                <!-- Live Indicator -->
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
              </button>
              
            </div>
          </div>
        </div>
      </div>
      <!-- Smart Flag Bar - Enhanced -->
      <div class="flex h-1.5">
        <div class="flex-1 bg-gradient-to-r from-green-400 to-green-500"></div>
        <div class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
        <div class="flex-1 bg-gradient-to-r from-red-400 to-red-500"></div>
      </div>
    </header>

    <!-- Revolutionary Side Panel Overlay -->
    <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="showUserMenu" class="fixed inset-0 z-[60]" @click="showUserMenu = false">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
      </div>
    </transition>
    
    <!-- Revolutionary Side Panel -->
    <transition enter-active-class="transition ease-out duration-300" enter-from-class="translate-x-full" enter-to-class="translate-x-0" leave-active-class="transition ease-in duration-200" leave-from-class="translate-x-0" leave-to-class="translate-x-full">
      <div v-if="showUserMenu" @click.stop class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl z-[70] flex flex-col">
                  <!-- Animated Top Bar -->
                  <div class="flex h-2 relative overflow-hidden">
                    <div class="flex-1 bg-gradient-to-r from-green-400 to-green-500 animate-gradient-x"></div>
                    <div class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500 animate-gradient-x" style="animation-delay: 0.3s"></div>
                    <div class="flex-1 bg-gradient-to-r from-red-400 to-red-500 animate-gradient-x" style="animation-delay: 0.6s"></div>
                  </div>
                  
                  <!-- Premium Header with Stats -->
                  <div class="relative px-6 py-6 bg-gradient-to-br from-purple-600 via-pink-600 to-blue-600 text-white overflow-hidden">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 opacity-20">
                      <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
                      <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
                    </div>
                    
                    <div class="relative flex items-start justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <!-- Avatar with Glow -->
                        <div class="relative">
                          <div class="absolute inset-0 bg-white rounded-2xl blur-lg opacity-50 animate-pulse"></div>
                          <div class="relative w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-3xl shadow-2xl ring-4 ring-white/30 border-2 border-white/50">
                            {{ userName.charAt(0).toUpperCase() }}
                          </div>
                        </div>
                        
                        <div>
                          <p class="font-black text-2xl mb-1">{{ userName }}</p>
                          <div class="flex items-center gap-2 mb-2">
                            <div class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/30">
                              <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                              <p class="text-xs font-bold">{{ isStaff ? userRole : 'Customer' }}</p>
                            </div>
                          </div>
                          <div class="flex items-center gap-2">
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-400 px-3 py-1 rounded-full text-xs font-black flex items-center gap-1">
                              <span>⭐</span> VIP Member
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <button @click="showUserMenu = false" class="w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl flex items-center justify-center transition-all border border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                      </button>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="relative grid grid-cols-3 gap-3">
                      <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 text-center">
                        <p class="text-2xl font-black mb-1">12</p>
                        <p class="text-xs opacity-90">Orders</p>
                      </div>
                      <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 text-center">
                        <p class="text-2xl font-black mb-1">850</p>
                        <p class="text-xs opacity-90">Points</p>
                      </div>
                      <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 text-center">
                        <p class="text-2xl font-black mb-1">5</p>
                        <p class="text-xs opacity-90">Saved</p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Menu Items -->
                  <div class="flex-1 overflow-y-auto p-4 bg-gradient-to-b from-gray-50 to-white">
                    <div class="space-y-2">
                    <!-- Admin Panel -->
                    <router-link v-if="isStaff" to="/admin/dashboard" @click="showUserMenu = false" class="group relative flex items-center gap-4 p-4 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-all shadow-md hover:shadow-xl border-2 border-transparent hover:border-purple-200 overflow-hidden">
                      <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
                      <div class="relative w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all shadow-lg">
                        <span class="text-3xl">⚙️</span>
                      </div>
                      <div class="relative flex-1">
                        <p class="font-black text-gray-900 text-lg mb-1">{{ t('storefront.adminPanel') }}</p>
                        <p class="text-xs text-purple-600 font-bold">{{ t('storefront.adminPanelAmharic') }}</p>
                      </div>
                      <div class="relative w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-all">
                        <svg class="w-5 h-5 text-purple-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </div>
                    </router-link>

                    <router-link to="/store/profile" @click="showUserMenu = false" class="group relative flex items-center gap-4 p-4 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 transition-all shadow-md hover:shadow-xl border-2 border-transparent hover:border-blue-200 overflow-hidden">
                      <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
                      <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all shadow-lg">
                        <span class="text-3xl">👤</span>
                      </div>
                      <div class="relative flex-1">
                        <p class="font-black text-gray-900 text-lg mb-1">{{ t('storefront.myProfile') }}</p>
                        <p class="text-xs text-blue-600 font-bold">{{ t('storefront.myProfileAmharic') }}</p>
                      </div>
                      <div class="relative w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-all">
                        <svg class="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </div>
                    </router-link>

                    <router-link to="/store/my-orders" @click="showUserMenu = false" class="group relative flex items-center gap-4 p-4 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all shadow-md hover:shadow-xl border-2 border-transparent hover:border-green-200 overflow-hidden">
                      <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
                      <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all shadow-lg">
                        <span class="text-3xl">📋</span>
                      </div>
                      <div class="relative flex-1">
                        <p class="font-black text-gray-900 text-lg mb-1">{{ t('storefront.myOrders') }}</p>
                        <p class="text-xs text-green-600 font-bold">{{ t('storefront.myOrdersAmharic') }}</p>
                      </div>
                      <div class="relative w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-all">
                        <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </div>
                    </router-link>
                    
                    <router-link to="/store" @click="showUserMenu = false" class="group relative flex items-center gap-4 p-4 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 transition-all shadow-md hover:shadow-xl border-2 border-transparent hover:border-yellow-200 overflow-hidden">
                      <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-orange-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
                      <div class="relative w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all shadow-lg">
                        <span class="text-3xl">🛍️</span>
                      </div>
                      <div class="relative flex-1">
                        <p class="font-black text-gray-900 text-lg mb-1">{{ t('storefront.continueShopping') }}</p>
                        <p class="text-xs text-yellow-600 font-bold">{{ t('storefront.continueShoppingAmharic') }}</p>
                      </div>
                      <div class="relative w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-200 transition-all">
                        <svg class="w-5 h-5 text-yellow-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </div>
                    </router-link>
                  </div>
                </div>
                
                <!-- Logout Section -->
                <div class="p-4 bg-gradient-to-t from-gray-100 to-white border-t-2 border-gray-200">
                  <button @click="handleLogout" class="group relative w-full flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white transition-all shadow-xl hover:shadow-2xl overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-12 transition-all border-2 border-white/30">
                      <span class="text-3xl">🚪</span>
                    </div>
                    <div class="relative flex-1 text-left">
                      <p class="font-black text-xl mb-1">{{ t('common.logout') }}</p>
                      <p class="text-xs text-red-100 font-bold">{{ t('storefront.logoutAmharic') }}</p>
                    </div>
                    <div class="relative w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all">
                      <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                      </svg>
                    </div>
                  </button>
                </div>
                <!-- Animated Bottom Bar -->
                <div class="flex h-2 relative overflow-hidden">
                  <div class="flex-1 bg-gradient-to-r from-green-400 to-green-500 animate-gradient-x"></div>
                  <div class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500 animate-gradient-x" style="animation-delay: 0.3s"></div>
                  <div class="flex-1 bg-gradient-to-r from-red-400 to-red-500 animate-gradient-x" style="animation-delay: 0.6s"></div>
                </div>
              </div>
            </transition>

    <!-- Mobile Menu Sidebar -->
    <div v-if="showMobileMenu" class="fixed inset-0 z-50 lg:hidden">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showMobileMenu = false"></div>
      <div class="absolute left-0 top-0 h-full w-72 bg-gradient-to-b from-green-600 via-emerald-600 to-teal-600 shadow-2xl flex flex-col">
        <!-- Mobile Menu Header -->
        <div class="p-4 border-b border-white/10">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-400 via-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl">🏪</span>
              </div>
              <div>
                <h2 class="text-white font-bold">{{ t('common.smart') }}</h2>
                <p class="text-yellow-300 text-xs">{{ t('common.supermarketSystem') }}</p>
              </div>
            </div>
            <button @click="showMobileMenu = false" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white">
              <span class="text-xl">✕</span>
            </button>
          </div>
          <!-- Smart Flag Bar -->
          <div class="flex gap-1 mt-4">
            <div class="h-1.5 flex-1 bg-green-500 rounded-l-full"></div>
            <div class="h-1.5 flex-1 bg-yellow-500"></div>
            <div class="h-1.5 flex-1 bg-red-500 rounded-r-full"></div>
          </div>
        </div>

        <!-- Mobile Menu Links -->
        <nav class="flex-1 overflow-y-auto p-4">
          <div class="space-y-2">
            <router-link to="/store" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition-all">
              <span class="text-xl">🏪</span>
              <span class="font-medium">{{ t('storefront.home') }} / {{ t('storefront.homeAmharic') }}</span>
            </router-link>
            <a href="#categories" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition-all">
              <span class="text-xl">📦</span>
              <span class="font-medium">{{ t('storefront.categories') }} / {{ t('storefront.categoriesAmharic') }}</span>
            </a>
            <a href="#products" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition-all">
              <span class="text-xl">🛍️</span>
              <span class="font-medium">{{ t('storefront.products') }} / {{ t('storefront.productsAmharic') }}</span>
            </a>
            <router-link v-if="isLoggedIn" to="/store/my-orders" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition-all">
              <span class="text-xl">📋</span>
              <span class="font-medium">{{ t('storefront.myOrders') }} / {{ t('storefront.myOrdersAmharic') }}</span>
            </router-link>
          </div>

          <!-- Auth Section in Mobile Menu -->
          <div class="mt-6 pt-6 border-t border-white/10">
            <p class="text-xs text-yellow-400/70 uppercase tracking-wider mb-3 px-4">{{ t('storefront.account') }}</p>
            <div v-if="!isLoggedIn" class="space-y-2">
              <router-link to="/login" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition-all">
                <span class="text-xl">🔐</span>
                <span class="font-medium">{{ t('auth.login') }} / {{ t('storefront.loginAmharic') }}</span>
              </router-link>
              <router-link to="/register" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gradient-to-r from-green-600/40 to-emerald-600/40 text-white border border-green-500/30 transition-all">
                <span class="text-xl">📝</span>
                <span class="font-medium">{{ t('auth.register') }} / {{ t('storefront.registerAmharic') }}</span>
              </router-link>
            </div>
            <div v-else class="space-y-2">
              <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                  {{ userName.charAt(0).toUpperCase() }}
                </div>
                <div>
                  <p class="text-white font-medium">{{ userName }}</p>
                  <p class="text-yellow-300 text-xs">{{ isStaff ? '⚙️ ' + userRole : '🛍️ ' + t('storefront.customer') }}</p>
                </div>
              </div>
              <!-- Admin Panel Link for Staff in Mobile Menu -->
              <router-link v-if="isStaff" to="/admin/dashboard" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-purple-500/20 text-purple-300 hover:bg-purple-500/30 transition-all border border-purple-500/30">
                <span class="text-xl">⚙️</span>
                <span class="font-medium">{{ t('storefront.adminPanel') }} / {{ t('storefront.adminPanelAmharic') }}</span>
              </router-link>
              <!-- Profile Link -->
              <router-link to="/store/profile" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 transition-all border border-blue-500/30">
                <span class="text-xl">👤</span>
                <span class="font-medium">{{ t('storefront.myProfile') }} / {{ t('storefront.myProfileAmharic') }}</span>
              </router-link>
              <!-- My Orders Link -->
              <router-link to="/store/my-orders" @click="showMobileMenu = false" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-500/20 text-green-300 hover:bg-green-500/30 transition-all border border-green-500/30">
                <span class="text-xl">📋</span>
                <span class="font-medium">{{ t('storefront.myOrders') }} / {{ t('storefront.myOrdersAmharic') }}</span>
              </router-link>
              <button @click="handleLogout; showMobileMenu = false" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/20 transition-all">
                <span class="text-xl">🚪</span>
                <span class="font-medium">{{ t('common.logout') }} / {{ t('storefront.logoutAmharic') }}</span>
              </button>
            </div>
          </div>
        </nav>

        <!-- Mobile Menu Footer -->
        <div class="p-4 border-t border-white/10 bg-black/20">
          <div class="flex items-center gap-2 text-gray-400 text-xs">
            <span>📍</span>
            <span>{{ t('storefront.yourCity') }}</span>
          </div>
          <div class="flex items-center gap-2 text-gray-400 text-xs mt-1">
            <span>📞</span>
            <span>+251 911 123 456</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Revolutionary AI-Powered Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 min-h-[90vh] flex items-center">
      <!-- Animated Grid Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
      </div>
      
      <!-- Animated Mesh Background -->
      <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-pink-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-cyan-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s"></div>
      </div>
      
      <!-- Floating Particles -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle absolute w-2 h-2 bg-white rounded-full opacity-60 animate-particle-1"></div>
        <div class="particle absolute w-3 h-3 bg-yellow-300 rounded-full opacity-40 animate-particle-2"></div>
        <div class="particle absolute w-2 h-2 bg-pink-300 rounded-full opacity-50 animate-particle-3"></div>
        <div class="particle absolute w-4 h-4 bg-purple-300 rounded-full opacity-30 animate-particle-4"></div>
        <div class="particle absolute w-2 h-2 bg-cyan-300 rounded-full opacity-50 animate-particle-1" style="animation-delay: 2s"></div>
        <div class="particle absolute w-3 h-3 bg-green-300 rounded-full opacity-40 animate-particle-2" style="animation-delay: 3s"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-20 w-full">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div class="text-white space-y-8">
            <!-- Premium AI Badge with Animation -->
            <div class="inline-flex items-center gap-3 bg-gradient-to-r from-white/20 to-white/10 backdrop-blur-xl px-6 py-3 rounded-full border-2 border-white/30 shadow-2xl hover:scale-105 transition-all cursor-pointer group">
              <div class="relative w-10 h-10">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-full blur-md opacity-75 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-full h-full bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-full flex items-center justify-center animate-spin-slow">
                  <span class="text-xl animate-bounce">🤖</span>
                </div>
              </div>
              <div>
                <p class="font-black text-sm tracking-wide">{{ t('storefront.aiPoweredShopping') }}</p>
                <p class="text-xs text-purple-200">{{ t('storefront.nextGenerationExperience') }}</p>
              </div>
              <div class="flex items-center gap-1">
                <span class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full text-xs font-black shadow-lg flex items-center gap-1">
                  <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                  LIVE
                </span>
              </div>
            </div>
            
            <!-- Main Heading with Enhanced Animation -->
            <div class="space-y-4">
              <h1 class="text-6xl md:text-8xl font-black leading-tight">
                <span class="block animate-fade-in-up">{{ t('storefront.shopSmarter').split(' ')[0] }}</span>
                <span class="block bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-400 bg-clip-text text-transparent animate-gradient-x" style="animation-delay: 0.2s">
                  {{ t('storefront.shopSmarter').split(' ')[1] }}
                </span>
                <span class="block text-5xl md:text-6xl text-purple-200 animate-fade-in-up" style="animation-delay: 0.4s">{{ t('storefront.withAIPower') }}</span>
              </h1>
              <div class="flex items-center gap-3 mt-4">
                <div class="h-1 w-20 bg-gradient-to-r from-yellow-400 to-pink-500 rounded-full animate-expand"></div>
                <div class="h-1 w-12 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full animate-expand" style="animation-delay: 0.2s"></div>
                <div class="h-1 w-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full animate-expand" style="animation-delay: 0.4s"></div>
              </div>
            </div>
            
            <!-- Enhanced Subheading -->
            <p class="text-xl md:text-2xl text-purple-100 font-medium leading-relaxed animate-fade-in" style="animation-delay: 0.6s">
              {{ t('storefront.revolutionaryExperience') }}
            </p>
            
            <!-- Enhanced AI Features Grid -->
            <div class="grid grid-cols-2 gap-4">
              <div class="group bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:border-purple-400 hover:bg-white/15 transition-all cursor-pointer hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl">
                <div class="flex items-center gap-3">
                  <div class="relative w-12 h-12">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all">
                      <span class="text-2xl">🎯</span>
                    </div>
                  </div>
                  <div>
                    <p class="font-bold text-sm">{{ t('storefront.smartMatch') }}</p>
                    <p class="text-xs text-purple-200">{{ t('storefront.accuracyPercent') }}</p>
                  </div>
                </div>
              </div>
              
              <div class="group bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:border-blue-400 hover:bg-white/15 transition-all cursor-pointer hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl">
                <div class="flex items-center gap-3">
                  <div class="relative w-12 h-12">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all">
                      <span class="text-2xl">🎤</span>
                    </div>
                  </div>
                  <div>
                    <p class="font-bold text-sm">{{ t('storefront.voiceShop') }}</p>
                    <p class="text-xs text-blue-200">{{ t('storefront.handsFree') }}</p>
                  </div>
                </div>
              </div>
              
              <div class="group bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:border-green-400 hover:bg-white/15 transition-all cursor-pointer hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl">
                <div class="flex items-center gap-3">
                  <div class="relative w-12 h-12">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all">
                      <span class="text-2xl">📊</span>
                    </div>
                  </div>
                  <div>
                    <p class="font-bold text-sm">{{ t('storefront.priceAI') }}</p>
                    <p class="text-xs text-green-200">{{ t('storefront.bestDeals') }}</p>
                  </div>
                </div>
              </div>
              
              <div class="group bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:border-yellow-400 hover:bg-white/15 transition-all cursor-pointer hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl">
                <div class="flex items-center gap-3">
                  <div class="relative w-12 h-12">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all">
                      <span class="text-2xl">⚡</span>
                    </div>
                  </div>
                  <div>
                    <p class="font-bold text-sm">{{ t('storefront.instantAI') }}</p>
                    <p class="text-xs text-yellow-200">{{ t('storefront.live247') }}</p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Enhanced CTA Buttons -->
            <div class="flex flex-wrap gap-4 pt-4">
              <button @click="startAIShopping" class="group relative px-10 py-5 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 hover:from-purple-500 hover:via-pink-500 hover:to-red-500 rounded-2xl font-black text-lg shadow-2xl transition-all transform hover:scale-105 hover:-translate-y-1 flex items-center gap-3 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl group-hover:rotate-12 transition-transform relative">🤖</span>
                <span class="relative">{{ t('storefront.startAIShopping') }}</span>
                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </button>
              
              <router-link to="/store/scan" class="group px-8 py-5 bg-white/10 backdrop-blur-xl hover:bg-white/20 rounded-2xl font-bold text-lg border-2 border-white/30 hover:border-white/50 transition-all flex items-center gap-3 hover:scale-105 hover:-translate-y-1">
                <span class="text-2xl group-hover:scale-110 transition-transform">📱</span>
                <span>{{ t('storefront.qrScan') }}</span>
              </router-link>
            </div>
            
            <!-- Enhanced Live Stats -->
            <div class="flex gap-8 pt-8 border-t border-white/20">
              <div class="group cursor-pointer hover:scale-110 transition-transform">
                <div class="text-4xl font-black bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">95%</div>
                <div class="text-sm text-purple-200 font-medium">{{ t('storefront.aiAccuracy') }}</div>
                <div class="w-full h-1 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full mt-2 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
              </div>
              <div class="group cursor-pointer hover:scale-110 transition-transform">
                <div class="text-4xl font-black bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">15K+</div>
                <div class="text-sm text-purple-200 font-medium">{{ t('storefront.activeUsers') }}</div>
                <div class="w-full h-1 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full mt-2 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
              </div>
              <div class="group cursor-pointer hover:scale-110 transition-transform">
                <div class="text-4xl font-black bg-gradient-to-r from-pink-400 to-red-400 bg-clip-text text-transparent">24/7</div>
                <div class="text-sm text-purple-200 font-medium">{{ t('storefront.aiSupport') }}</div>
                <div class="w-full h-1 bg-gradient-to-r from-pink-400 to-red-400 rounded-full mt-2 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
              </div>
            </div>
          </div>
          
          <!-- Right Content - 3D AI Visualization -->
          <div class="hidden md:block relative">
            <div class="relative w-full h-[600px]">
              <!-- Central AI Core with Glow -->
              <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 h-56">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 rounded-full blur-2xl opacity-60 animate-pulse"></div>
                <div class="relative w-full h-full bg-gradient-to-br from-purple-600 via-pink-600 to-red-600 rounded-full flex items-center justify-center shadow-2xl border-4 border-white/20 animate-spin-slow">
                  <span class="text-8xl animate-bounce-slow">🤖</span>
                </div>
              </div>
              
              <!-- Orbiting Feature Nodes -->
              <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-28 animate-orbit-1">
                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl hover:scale-110 transition-transform cursor-pointer">
                  <span class="text-5xl">🎯</span>
                </div>
              </div>
              
              <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-28 h-28 animate-orbit-2">
                <div class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-500 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl hover:scale-110 transition-transform cursor-pointer">
                  <span class="text-5xl">💰</span>
                </div>
              </div>
              
              <div class="absolute top-1/2 left-0 -translate-y-1/2 w-28 h-28 animate-orbit-3">
                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-cyan-500 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl hover:scale-110 transition-transform cursor-pointer">
                  <span class="text-5xl">🎤</span>
                </div>
              </div>
              
              <div class="absolute top-1/2 right-0 -translate-y-1/2 w-28 h-28 animate-orbit-4">
                <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-orange-500 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl hover:scale-110 transition-transform cursor-pointer">
                  <span class="text-5xl">📊</span>
                </div>
              </div>
              
              <!-- Connecting Energy Lines -->
              <svg class="absolute inset-0 w-full h-full opacity-40">
                <defs>
                  <linearGradient id="lineGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:rgb(168,85,247);stop-opacity:1" />
                    <stop offset="100%" style="stop-color:rgb(236,72,153);stop-opacity:1" />
                  </linearGradient>
                </defs>
                <line x1="50%" y1="50%" x2="50%" y2="10%" stroke="url(#lineGradient1)" stroke-width="3" stroke-dasharray="10,5" class="animate-dash-fast" />
                <line x1="50%" y1="50%" x2="50%" y2="90%" stroke="url(#lineGradient1)" stroke-width="3" stroke-dasharray="10,5" class="animate-dash-fast" />
                <line x1="50%" y1="50%" x2="10%" y2="50%" stroke="url(#lineGradient1)" stroke-width="3" stroke-dasharray="10,5" class="animate-dash-fast" />
                <line x1="50%" y1="50%" x2="90%" y2="50%" stroke="url(#lineGradient1)" stroke-width="3" stroke-dasharray="10,5" class="animate-dash-fast" />
              </svg>
              
              <!-- Data Flow Indicators -->
              <div class="absolute top-1/4 right-1/4 w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full opacity-60 animate-ping"></div>
              <div class="absolute bottom-1/4 left-1/4 w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full opacity-60 animate-ping" style="animation-delay: 1s"></div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Scroll Indicator -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <div class="w-8 h-12 border-2 border-white/30 rounded-full flex items-start justify-center p-2">
          <div class="w-2 h-3 bg-white rounded-full animate-pulse"></div>
        </div>
      </div>
    </section>

    <!-- AI Features Showcase -->
    <section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-semibold mb-4">
            <span>🚀</span> {{ t('storefront.poweredByAI') }}
          </div>
          <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ t('storefront.revolutionaryAIFeatures') }}</h2>
          <p class="text-xl text-gray-600">{{ t('storefront.experienceFuture') }}</p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-6">
          <!-- Feature 1 -->
          <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-500">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <span class="text-3xl">🎯</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ t('storefront.smartRecommendations') }}</h3>
            <p class="text-gray-600 text-sm">{{ t('storefront.aiAnalyzesPreferences') }}</p>
            <div class="mt-4 flex items-center gap-2 text-purple-600 font-semibold text-sm">
              <span>{{ t('storefront.learnMore') }}</span>
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
          
          <!-- Feature 2 -->
          <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-blue-500">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <span class="text-3xl">🎤</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ t('storefront.voiceShopping') }}</h3>
            <p class="text-gray-600 text-sm">{{ t('storefront.shopHandsFree') }}</p>
            <div class="mt-4 flex items-center gap-2 text-blue-600 font-semibold text-sm">
              <span>{{ t('storefront.tryNow') }}</span>
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
          
          <!-- Feature 3 -->
          <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-green-500">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <span class="text-3xl">📊</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ t('storefront.pricePredictions') }}</h3>
            <p class="text-gray-600 text-sm">{{ t('storefront.aiPredictsPriceDrops') }}</p>
            <div class="mt-4 flex items-center gap-2 text-green-600 font-semibold text-sm">
              <span>{{ t('storefront.getAlerts') }}</span>
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
          
          <!-- Feature 4 -->
          <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-orange-500">
            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <span class="text-3xl">💬</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ t('storefront.aiAssistant247') }}</h3>
            <p class="text-gray-600 text-sm">{{ t('storefront.instantHelpChatbot') }}</p>
            <div class="mt-4 flex items-center gap-2 text-orange-600 font-semibold text-sm">
              <span>{{ t('storefront.chatNow') }}</span>
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8">
          <h3 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">{{ t('storefront.shopByCategory') }}</h3>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
          <button @click="categoryFilter = ''" class="px-6 py-3 rounded-full font-semibold transition-all shadow-md" :class="categoryFilter === '' ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-green-200' : 'bg-white hover:bg-gray-50 text-gray-700 hover:shadow-lg'">
            🏷️ {{ t('storefront.allProducts') }}
          </button>
          <button v-for="cat in categories" :key="cat.id" @click="categoryFilter = cat.id" class="px-6 py-3 rounded-full font-semibold transition-all shadow-md" :class="categoryFilter === cat.id ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-green-200' : 'bg-white hover:bg-gray-50 text-gray-700 hover:shadow-lg'">
            {{ getCategoryIcon(cat.name) }} {{ translateCategoryName(cat.name) }}
          </button>
        </div>
      </div>
    </section>

    <!-- Mobile Search -->
    <section class="py-4 bg-white md:hidden">
      <div class="max-w-7xl mx-auto px-4">
        <div class="relative">
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-yellow-500">🔍</span>
          <input v-model="search" type="text" class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-yellow-300 focus:border-yellow-500 outline-none" :placeholder="t('storefront.searchProducts')" />
        </div>
      </div>
    </section>

    <!-- AI Recommendations Section -->
    <section id="ai-recommendations" v-if="isLoggedIn" class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="max-w-7xl mx-auto px-4">
        <AIRecommendations />
      </div>
    </section>
    <!-- AI-Powered Products Section -->
    <section id="products" class="py-16 bg-gradient-to-br from-gray-50 via-white to-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 px-4 py-2 rounded-full font-semibold mb-4">
            <span>🤖</span> {{ t('storefront.aiCuratedProducts') }}
          </div>
          <h3 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
            {{ t('storefront.discoverPerfectMatch') }}
          </h3>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            {{ t('storefront.aiAnalyzesYourPreferences') }}
          </p>
        </div>

        <!-- Smart Filters Bar -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-purple-100 p-6 mb-8">
          <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Results Count -->
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                {{ filteredProducts.length }}
              </div>
              <div>
                <p class="text-sm text-gray-500">Products Found</p>
                <p class="font-bold text-gray-900">{{ filteredProducts.length }} {{ t('storefront.items') }}</p>
              </div>
            </div>

            <!-- AI Sort Options -->
            <div class="flex items-center gap-3">
              <span class="text-sm font-semibold text-gray-700">Sort by:</span>
              <select v-model="sortBy" class="px-4 py-2.5 rounded-xl border-2 border-purple-200 focus:border-purple-500 outline-none bg-white font-semibold text-gray-700 cursor-pointer hover:border-purple-400 transition-all">
                <option value="ai_recommended">🤖 AI Recommended</option>
                <option value="name">📝 Name</option>
                <option value="price_low">💰 Price: Low to High</option>
                <option value="price_high">💎 Price: High to Low</option>
                <option value="popularity">🔥 Most Popular</option>
              </select>
            </div>

            <!-- View Toggle -->
            <div class="flex items-center gap-2 bg-gray-100 rounded-xl p-1">
              <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white shadow-md' : ''" class="px-4 py-2 rounded-lg font-semibold text-sm transition-all">
                <span>⊞</span> Grid
              </button>
              <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white shadow-md' : ''" class="px-4 py-2 rounded-lg font-semibold text-sm transition-all">
                <span>☰</span> List
              </button>
            </div>
          </div>
        </div>
        
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-20">
          <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="absolute inset-0 border-4 border-purple-200 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-purple-600 border-t-transparent rounded-full animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center text-3xl animate-pulse">🤖</div>
          </div>
          <p class="text-xl font-bold text-gray-900 mb-2">AI is finding perfect products for you...</p>
          <p class="text-gray-500">Analyzing your preferences</p>
        </div>

        <!-- Products Grid -->
        <div v-else-if="viewMode === 'grid'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
          <div v-for="(product, index) in sortedProducts" :key="product.id" 
               @click="viewProduct(product)" 
               class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-purple-500 cursor-pointer transform hover:-translate-y-2"
               :style="{ animationDelay: `${index * 50}ms` }">
            
            <!-- Product Image -->
            <div class="relative h-56 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 flex items-center justify-center p-4 overflow-hidden">
              <img :src="getImageUrl(product.image)" :alt="product.name" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-700" />
              
              <!-- AI Badge -->
              <div class="absolute top-3 right-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg flex items-center gap-1 animate-pulse">
                <span>🤖</span>
                <span>{{ Math.floor(Math.random() * 20) + 80 }}%</span>
              </div>
              
              <!-- Stock Badge -->
              <div class="absolute top-3 left-3 flex flex-col gap-2">
                <span v-if="product.quantity <= 5 && product.quantity > 0" class="bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg animate-bounce">
                  🔥 Only {{ product.quantity }} left!
                </span>
                <span v-if="product.quantity === 0" class="bg-gradient-to-r from-gray-600 to-gray-800 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg">
                  ❌ Sold Out
                </span>
              </div>
              
              <!-- Quick Actions Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-4 gap-3">
                <button @click.stop="viewProduct(product)" class="w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center hover:bg-purple-500 hover:text-white transition-all transform translate-y-10 group-hover:translate-y-0">
                  <span class="text-xl">👁️</span>
                </button>
                <button @click.stop="addToCart(product)" :disabled="product.quantity <= 0" class="w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center hover:bg-green-500 hover:text-white transition-all transform translate-y-10 group-hover:translate-y-0 delay-75" :class="product.quantity <= 0 ? 'opacity-50 cursor-not-allowed' : ''">
                  <span class="text-xl">🛒</span>
                </button>
                <button @click.stop="toggleWishlist(product)" class="w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all transform translate-y-10 group-hover:translate-y-0 delay-100">
                  <span class="text-xl">❤️</span>
                </button>
              </div>
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
              <!-- Category -->
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">
                  {{ tc(product.category?.name) }}
                </span>
                <div class="flex items-center gap-1">
                  <span class="text-yellow-400 text-sm">★</span>
                  <span class="text-xs font-bold text-gray-700">4.{{ Math.floor(Math.random() * 9) + 1 }}</span>
                </div>
              </div>
              
              <!-- Product Name -->
              <h4 class="font-bold text-gray-900 mb-2 line-clamp-2 h-12 group-hover:text-purple-600 transition-colors">
                {{ tp(product.name) }}
              </h4>
              
              <!-- AI Insights -->
              <div class="mb-3 text-xs text-gray-600 bg-gradient-to-r from-purple-50 to-pink-50 px-2 py-1.5 rounded-lg">
                <span class="font-semibold">💡 AI:</span> {{ getAIInsight() }}
              </div>
              
              <!-- Price & Stock -->
              <div class="flex items-center justify-between mb-3">
                <div>
                  <p class="text-2xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                    ETB {{ formatCurrency(product.price) }}
                  </p>
                  <p class="text-xs text-gray-500 line-through">ETB {{ formatCurrency(product.price * 1.2) }}</p>
                </div>
                <span v-if="product.quantity > 0" class="text-xs text-green-600 bg-green-50 px-3 py-1.5 rounded-full font-bold border border-green-200">
                  ✓ In Stock
                </span>
              </div>
              
              <!-- Add to Cart Button -->
              <button @click.stop="addToCart(product)" :disabled="product.quantity <= 0" 
                      class="w-full py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2 transform active:scale-95" 
                      :class="product.quantity > 0 ? 'bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 hover:from-purple-700 hover:via-pink-700 hover:to-red-700 text-white shadow-lg hover:shadow-xl' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                <span class="text-xl">{{ product.quantity > 0 ? '🛒' : '❌' }}</span>
                <span>{{ product.quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!loading && filteredProducts.length === 0" class="text-center py-20">
          <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-6xl">🔍</span>
          </div>
          <h3 class="text-3xl font-bold text-gray-900 mb-3">No Products Found</h3>
          <p class="text-xl text-gray-600 mb-6">Try adjusting your search or filters</p>
          <button @click="search = ''; categoryFilter = ''" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-bold shadow-lg transition-all">
            Clear Filters
          </button>
        </div>
      </div>
    </section>

    <!-- AI-Powered Stats Bar -->
    <section class="relative py-16 bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 overflow-hidden">
      <!-- Animated Background -->
      <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-purple-500 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-blue-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white px-4 py-2 rounded-full font-semibold mb-4 border border-white/20">
            <span>📊</span> {{ t('storefront.realTimePlatformStatistics') }}
          </div>
          <h3 class="text-4xl font-black text-white mb-2">{{ t('storefront.poweredByAIAnalytics') }}</h3>
          <p class="text-purple-200">{{ t('storefront.liveDataUpdated') }}</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <!-- Stat 1 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-white/40 transition-all transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <span class="text-3xl">📦</span>
              </div>
              <div class="text-center">
                <p class="text-4xl font-black text-white mb-2 animate-count">{{ products.length }}+</p>
                <p class="text-green-200 font-semibold mb-1">{{ t('storefront.productsCount') }}</p>
                <div class="flex items-center justify-center gap-1 text-xs text-green-300">
                  <span>↗</span>
                  <span>{{ t('storefront.thisWeekGrowth') }}</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Stat 2 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-white/40 transition-all transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <span class="text-3xl">🏷️</span>
              </div>
              <div class="text-center">
                <p class="text-4xl font-black text-white mb-2 animate-count">{{ categories.length }}</p>
                <p class="text-yellow-200 font-semibold mb-1">{{ t('storefront.categoriesCount') }}</p>
                <div class="flex items-center justify-center gap-1 text-xs text-yellow-300">
                  <span>✓</span>
                  <span>{{ t('storefront.allVerified') }}</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Stat 3 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-red-500 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-white/40 transition-all transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-red-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <span class="text-3xl">😊</span>
              </div>
              <div class="text-center">
                <p class="text-4xl font-black text-white mb-2 animate-count">10K+</p>
                <p class="text-pink-200 font-semibold mb-1">{{ t('storefront.happyCustomers') }}</p>
                <div class="flex items-center justify-center gap-1 text-xs text-pink-300">
                  <span>⭐</span>
                  <span>{{ t('storefront.starRating') }}</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Stat 4 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-white/40 transition-all transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <span class="text-3xl">🤖</span>
              </div>
              <div class="text-center">
                <p class="text-4xl font-black text-white mb-2">24/7</p>
                <p class="text-blue-200 font-semibold mb-1">AI {{ t('storefront.support247') }}</p>
                <div class="flex items-center justify-center gap-1 text-xs text-blue-300">
                  <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                  <span>{{ t('storefront.onlineNow') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Live Activity Feed -->
        <div class="mt-12 bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-white font-bold">{{ t('storefront.liveActivity') }}</span>
          </div>
          <div class="space-y-2 text-sm text-purple-200">
            <p>🛒 <strong>Sarah M.</strong> just purchased Ethiopian Coffee</p>
            <p>⭐ <strong>John D.</strong> rated Fresh Tomatoes 5 stars</p>
            <p>🎯 AI recommended 15 products to <strong>Mike K.</strong></p>
          </div>
        </div>
      </div>
    </section>

    <!-- Revolutionary Features Section -->
    <section class="py-20 bg-white relative overflow-hidden">
      <!-- Decorative Elements -->
      <div class="absolute top-0 left-0 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-30"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-100 rounded-full blur-3xl opacity-30"></div>
      
      <div class="relative max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
          <div class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 px-4 py-2 rounded-full font-semibold mb-4">
            <span>✨</span> {{ t('storefront.whyChooseUs') }}
          </div>
          <h3 class="text-5xl font-black text-gray-900 mb-4">
            {{ t('storefront.experienceTheFuture') }}
          </h3>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            {{ t('storefront.revolutionaryFeatures') }}
          </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Feature 1 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-500 rounded-3xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-green-500">
              <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                <span class="text-4xl">🚚</span>
              </div>
              <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ t('storefront.freeDeliveryTitle') }}</h4>
              <p class="text-gray-600 mb-4">{{ t('storefront.freeDeliveryDesc') }}</p>
              <div class="flex items-center gap-2 text-green-600 font-semibold">
                <span>{{ t('storefront.learnMore') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
              <!-- Floating Badge -->
              <div class="absolute -top-3 -right-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg animate-bounce">
                FREE
              </div>
            </div>
          </div>
          
          <!-- Feature 2 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-blue-500">
              <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                <span class="text-4xl">🔒</span>
              </div>
              <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ t('storefront.securePaymentTitle') }}</h4>
              <p class="text-gray-600 mb-4">{{ t('storefront.securePaymentDesc') }}</p>
              <div class="flex items-center gap-2 text-blue-600 font-semibold">
                <span>{{ t('storefront.learnMore') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
              <!-- Security Badge -->
              <div class="absolute -top-3 -right-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                SSL
              </div>
            </div>
          </div>
          
          <!-- Feature 3 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-orange-500">
              <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                <span class="text-4xl">🔄</span>
              </div>
              <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ t('storefront.easyReturnsTitle') }}</h4>
              <p class="text-gray-600 mb-4">{{ t('storefront.easyReturnsDesc') }}</p>
              <div class="flex items-center gap-2 text-orange-600 font-semibold">
                <span>{{ t('storefront.learnMore') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
              <!-- Days Badge -->
              <div class="absolute -top-3 -right-3 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                7 DAYS
              </div>
            </div>
          </div>
          
          <!-- Feature 4 -->
          <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-500">
              <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                <span class="text-4xl">🤖</span>
              </div>
              <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ t('storefront.aiAssistant') }}</h4>
              <p class="text-gray-600 mb-4">{{ t('storefront.intelligentSupport247') }}</p>
              <div class="flex items-center gap-2 text-purple-600 font-semibold">
                <span>{{ t('storefront.chatNow') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
              <!-- AI Badge -->
              <div class="absolute -top-3 -right-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg animate-pulse">
                AI
              </div>
            </div>
          </div>
        </div>
        
        <!-- Trust Badges -->
        <div class="mt-16 bg-gradient-to-r from-purple-50 via-pink-50 to-blue-50 rounded-3xl p-8 border-2 border-purple-100">
          <div class="text-center mb-8">
            <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ t('storefront.trustedByThousands') }}</h4>
            <p class="text-gray-600">{{ t('storefront.joinGrowingCommunity') }}</p>
          </div>
          <div class="flex flex-wrap justify-center items-center gap-8">
            <div class="flex items-center gap-2">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                ✓
              </div>
              <div>
                <p class="font-bold text-gray-900">{{ t('storefront.verifiedSecure') }}</p>
                <p class="text-sm text-gray-600">{{ t('storefront.sslEncrypted') }}</p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                ⭐
              </div>
              <div>
                <p class="font-bold text-gray-900">{{ t('storefront.starRatingReviews') }}</p>
                <p class="text-sm text-gray-600">{{ t('storefront.thousandReviews') }}</p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                🏆
              </div>
              <div>
                <p class="font-bold text-gray-900">{{ t('storefront.awardWinning') }}</p>
                <p class="text-sm text-gray-600">{{ t('storefront.bestEcommerce2026') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-green-600 via-emerald-600 to-teal-600 text-white">
      <!-- Smart Flag Top -->
      <div class="flex">
        <div class="h-1.5 flex-1 bg-green-500"></div>
        <div class="h-1.5 flex-1 bg-yellow-500"></div>
        <div class="h-1.5 flex-1 bg-red-500"></div>
      </div>
      <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-400 via-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl">🏪</span>
              </div>
              <div>
                <h3 class="text-xl font-bold">{{ t('storefront.smartSuperMarket') }}</h3>
                <p class="text-yellow-300 text-sm">{{ t('storefront.yourCity') }}</p>
              </div>
            </div>
            <p class="text-gray-300 text-sm">{{ t('storefront.trustedPartner') }}</p>
            <div class="flex gap-1 mt-4">
              <div class="h-1.5 w-8 bg-green-500 rounded-full"></div>
              <div class="h-1.5 w-8 bg-yellow-500 rounded-full"></div>
              <div class="h-1.5 w-8 bg-red-500 rounded-full"></div>
            </div>
          </div>
          <div>
            <h4 class="font-bold mb-4 text-yellow-300">{{ t('storefront.quickLinks') }}</h4>
            <ul class="space-y-2 text-gray-300">
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.aboutUs') }}</a></li>
              <li><a href="#products" class="hover:text-yellow-300 transition-colors">{{ t('storefront.ourProducts') }}</a></li>
              <li><a href="#categories" class="hover:text-yellow-300 transition-colors">{{ t('storefront.shopByCategory') }}</a></li>
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.contactUs') }}</a></li>
            </ul>
          </div>
          <div>
            <h4 class="font-bold mb-4 text-yellow-300">{{ t('storefront.customerService') }}</h4>
            <ul class="space-y-2 text-gray-300">
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.faq') }}</a></li>
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.shippingInfo') }}</a></li>
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.returns') }}</a></li>
              <li><a href="#" class="hover:text-yellow-300 transition-colors">{{ t('storefront.trackOrder') }}</a></li>
            </ul>
          </div>
          <div>
            <h4 class="font-bold mb-4 text-yellow-300">{{ t('storefront.contactUs') }}</h4>
            <ul class="space-y-2 text-gray-300">
              <li>📍 {{ t('storefront.yourCity') }}</li>
              <li>📞 +251 911 123 456</li>
              <li>📧 info@SuperMarket.et</li>
            </ul>
          </div>
        </div>
        <div class="border-t border-white/20 pt-8 text-center text-gray-300">
          <p>© {{ new Date().getFullYear() }} {{ t('storefront.smartSuperMarket') }} - {{ t('storefront.smartSuperMarket') }}, {{ t('storefront.yourCity') }}. {{ t('storefront.allRightsReserved') }}</p>
          <p class="text-sm mt-2">{{ t('storefront.builtWithLove') }}</p>
        </div>
      </div>
    </footer>

    <!-- Cart Sidebar -->
    <div v-if="showCart" class="fixed inset-0 z-50">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showCart = false"></div>
      <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">
        <div class="flex-shrink-0 p-4 border-b bg-gradient-to-r from-green-600 to-emerald-600 text-white">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-bold">🛒 {{ t('storefront.cart') }}</h2>
              <p class="text-green-100 text-sm">{{ cartCount }} {{ t('storefront.items') }}</p>
            </div>
            <button @click="showCart = false" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center">✕</button>
          </div>
        </div>
        
        <div v-if="cart.length === 0" class="flex-1 flex items-center justify-center">
          <div class="text-center p-6">
            <p class="text-5xl mb-3">🛒</p>
            <p class="text-lg text-gray-500 mb-1">{{ t('storefront.cartIsEmpty') }}</p>
            <button @click="showCart = false" class="px-4 py-2 bg-gradient-to-r from-green-600 to-yellow-500 text-white rounded-lg font-semibold">{{ t('storefront.continueShopping') }}</button>
          </div>
        </div>

        <div v-else class="flex-1 overflow-y-auto p-3 space-y-2">
          <div v-for="(item, index) in cart" :key="index" class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center p-1 shadow-sm flex-shrink-0">
              <img :src="getImageUrl(item.image)" class="max-h-full max-w-full object-contain" />
            </div>
            <div class="flex-1 min-w-0">
              <p class="font-semibold text-gray-800 truncate text-sm">{{ tp(item.name) }}</p>
              <p class="text-green-600 font-bold text-sm">ETB {{ formatCurrency(item.price) }}</p>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">
              <button @click="updateQty(index, -1)" class="w-7 h-7 rounded-lg bg-gray-200 hover:bg-gray-300 font-bold">-</button>
              <span class="w-8 text-center font-bold text-sm">{{ item.qty }}</span>
              <button @click="updateQty(index, 1)" class="w-7 h-7 rounded-lg bg-gray-200 hover:bg-gray-300 font-bold">+</button>
            </div>
            <button @click="removeFromCart(index)" class="w-8 h-8 text-red-500 hover:bg-red-50 rounded-lg flex items-center justify-center">🗑️</button>
          </div>
        </div>

        <div v-if="cart.length > 0" class="flex-shrink-0 p-4 border-t bg-gray-50">
          <div class="space-y-1 mb-3 text-sm">
            <div class="flex justify-between text-gray-600">
              <span>{{ t('storefront.subtotal') }}</span>
              <span class="font-semibold">ETB {{ formatCurrency(cartTotal) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
              <span>{{ t('storefront.vat') }}</span>
              <span class="font-semibold">ETB {{ formatCurrency(cartTotal * 0.15) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold pt-2 border-t">
              <span>{{ t('storefront.total') }}</span>
              <span class="text-green-600">ETB {{ formatCurrency(cartTotal * 1.15) }}</span>
            </div>
          </div>
          <button @click="checkout" class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold shadow-lg flex items-center justify-center gap-2">
            <span>✓</span>
            <span>{{ t('storefront.placeOrder') }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Login Required Modal -->
    <div v-if="showLoginModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="showLoginModal = false">
      <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl">
        <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <span class="text-4xl">🔐</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ t('storefront.loginRequired') }}</h3>
        <p class="text-gray-600 mb-8">{{ t('storefront.loginRequiredDesc') }} {{ loginAction }}</p>
        <div class="flex gap-4">
          <router-link to="/login" class="flex-1 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold shadow-lg">{{ t('auth.login') }}</router-link>
          <router-link to="/register" class="flex-1 py-4 border-2 border-green-600 text-green-600 hover:bg-green-50 rounded-xl font-bold">{{ t('auth.register') }}</router-link>
        </div>
        <button @click="showLoginModal = false" class="mt-6 text-gray-500 hover:text-gray-700 font-medium">{{ t('common.cancel') }}</button>
      </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div v-if="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);" @click.self="showLogoutModal = false">
      <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl">
        <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mx-auto mb-6">
          <span class="text-5xl">🚪</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ t('auth.logoutConfirm') }}</h3>
        <p class="text-gray-600 mb-8">{{ t('auth.logoutConfirmMessage') }}</p>
        <div class="flex gap-4">
          <button @click="showLogoutModal = false" class="flex-1 py-4 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-bold transition-all">
            {{ t('common.cancel') }}
          </button>
          <button @click="confirmLogout" class="flex-1 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl font-bold transition-all shadow-lg flex items-center justify-center gap-2">
            <span>🚪</span>
            <span>{{ t('common.logout') }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- AI Shopping Assistant -->
  <AIShoppingAssistant />
  
  <!-- Translation Debug Component (removed - working!) -->
  <!-- <TranslationDebug v-if="showDebug" @close="showDebug = false" /> -->
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { storefrontApi } from '../../services/api'
import { useAuthStore } from '../../stores/auth'
import { useCartStore } from '../../stores/cart'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'
import { useProductTranslation } from '../../composables/useProductTranslation'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'
import AIRecommendations from '../../components/AIRecommendations.vue'
import AIShoppingAssistant from '../../components/AIShoppingAssistant.vue'
import AISmartSearch from '../../components/AISmartSearch.vue'

const router = useRouter()
const auth = useAuthStore()
const cartStore = useCartStore()
const toast = useToastStore()
const { t } = useTranslation()
const { tp, tc } = useProductTranslation()

const products = ref([])
const categories = ref([])
const loading = ref(true)
const search = ref('')
const categoryFilter = ref('')
const sortBy = ref('ai_recommended')
const viewMode = ref('grid')
const showCart = ref(false)
const showUserMenu = ref(false)
const showLoginModal = ref(false)
const loginAction = ref('')

const showLogoutModal = ref(false)
const showMobileMenu = ref(false)
// const showDebug = ref(true) // Debug component removed - translation system working!

const isLoggedIn = computed(() => auth.isAuthenticated)
const userName = computed(() => auth.user?.name || 'Guest')
const userRole = computed(() => {
  const role = auth.user?.role || 'customer'
  return role.charAt(0).toUpperCase() + role.slice(1)
})
const isStaff = computed(() => ['admin', 'manager', 'cashier'].includes(auth.user?.role))

const filteredProducts = computed(() => {
  let result = products.value
  if (search.value) {
    const s = search.value.toLowerCase()
    result = result.filter(p => p.name.toLowerCase().includes(s))
  }
  if (categoryFilter.value) {
    result = result.filter(p => p.category_id === categoryFilter.value)
  }
  return result
})

const sortedProducts = computed(() => {
  const sorted = [...filteredProducts.value]
  if (sortBy.value === 'price_low') sorted.sort((a, b) => a.price - b.price)
  else if (sortBy.value === 'price_high') sorted.sort((a, b) => b.price - a.price)
  else sorted.sort((a, b) => a.name.localeCompare(b.name))
  return sorted
})

const cartCount = computed(() => cartStore.itemCount)
const cartTotal = computed(() => cartStore.subtotal)

const cart = computed(() => cartStore.items.map(item => ({
  id: item.id,
  name: item.name,
  price: item.price,
  qty: item.quantity,
  image: item.image
})))

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })

const getImageUrl = (image) => {
  if (!image) return '/images/products/default.jpg'
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}/storage/${image}`
}

const getCategoryIcon = (name) => {
  const icons = { 'Electronics': '📱', 'Clothing': '👕', 'Food': '🍎', 'Beverages': '🥤', 'Household': '🏠', 'Beauty': '💄', 'Sports': '⚽', 'Books': '📚' }
  return icons[name] || '📦'
}

const translateCategoryName = (name) => {
  if (!name) return t('categories.names.Uncategorized')
  return t(`categories.names.${name}`) || name
}

const openCart = () => { showCart.value = true }
const viewProduct = (product) => { router.push(`/store/products/${product.id}`) }

const addToCart = (product) => {
  if (!isLoggedIn.value) {
    loginAction.value = 'add items to cart'
    showLoginModal.value = true
    return
  }
  
  cartStore.addItem(product, 1)
  toast.success(`✅ ${tp(product.name)} ${t('storefront.addedToCart')}!`)
}

const updateQty = (index, delta) => {
  const item = cartStore.items[index]
  if (!item) return
  
  const newQty = item.quantity + delta
  if (newQty <= 0) {
    cartStore.removeItem(item.id)
    toast.info(`🗑️ ${tp(item.name)} removed from cart`)
  } else if (newQty <= item.maxQuantity) {
    cartStore.updateQuantity(item.id, newQty)
    toast.success(`🔄 ${tp(item.name)} quantity updated to ${newQty}`)
  } else {
    toast.warning(`⚠️ Only ${item.maxQuantity} items available`)
  }
}

const removeFromCart = (index) => {
  const item = cartStore.items[index]
  if (!item) return
  
  cartStore.removeItem(item.id)
  toast.info(`🗑️ ${tp(item.name)} removed from cart`)
}

const checkout = () => {
  if (!isLoggedIn.value) {
    loginAction.value = 'checkout'
    showLoginModal.value = true
    return
  }
  router.push('/store/checkout')
}

const handleLogout = () => {
  showLogoutModal.value = true
  showUserMenu.value = false
}

const confirmLogout = () => {
  auth.logout()
  cartStore.clear()
  showLogoutModal.value = false
  router.push('/store')
}

const handleClickOutside = (e) => {
  if (showUserMenu.value && !e.target.closest('.relative')) showUserMenu.value = false
}

const startAIShopping = () => {
  // Scroll to AI recommendations section
  const aiSection = document.querySelector('#ai-recommendations')
  if (aiSection) {
    aiSection.scrollIntoView({ behavior: 'smooth' })
  } else {
    // If not logged in, scroll to products
    const productsSection = document.querySelector('#products')
    if (productsSection) {
      productsSection.scrollIntoView({ behavior: 'smooth' })
    }
  }
}

const handleAISearch = (query) => {
  search.value = query
  // Filter products based on search
  // The computed filteredProducts will automatically update
}

const getAIInsight = () => {
  const insights = [
    'Popular choice',
    'Trending now',
    'Best seller',
    'Highly rated',
    'Great value',
    'Customer favorite',
    'Top quality',
    'Fresh arrival'
  ]
  return insights[Math.floor(Math.random() * insights.length)]
}

const toggleWishlist = (product) => {
  toast.success(`${tp(product.name)} added to wishlist!`)
}

onMounted(async () => {
  document.addEventListener('click', handleClickOutside)
  try {
    const [prodRes, catRes] = await Promise.all([storefrontApi.getProducts(), storefrontApi.getCategories()])
    // Handle different response structures
    // prodRes could be: { success, data: [...], meta, links } for paginated
    // catRes could be: { success, data: [...] } for non-paginated
    if (Array.isArray(prodRes)) {
      products.value = prodRes
    } else if (prodRes?.data) {
      products.value = Array.isArray(prodRes.data) ? prodRes.data : []
    } else {
      products.value = []
    }
    
    if (Array.isArray(catRes)) {
      categories.value = catRes
    } else if (catRes?.data) {
      categories.value = Array.isArray(catRes.data) ? catRes.data : []
    } else {
      categories.value = []
    }
  } catch (e) {
    console.error('Failed to load storefront data:', e)
    products.value = []
    categories.value = []
  } finally {
    loading.value = false
  }
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

@keyframes dash {
  to {
    stroke-dashoffset: -100;
  }
}

@keyframes dash-fast {
  to {
    stroke-dashoffset: -50;
  }
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
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

@keyframes spin-slow {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
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

@keyframes orbit-1 {
  0% {
    transform: translate(-50%, 0) rotate(0deg) translateX(200px) rotate(0deg);
  }
  100% {
    transform: translate(-50%, 0) rotate(360deg) translateX(200px) rotate(-360deg);
  }
}

@keyframes orbit-2 {
  0% {
    transform: translate(-50%, 0) rotate(90deg) translateX(200px) rotate(-90deg);
  }
  100% {
    transform: translate(-50%, 0) rotate(450deg) translateX(200px) rotate(-450deg);
  }
}

@keyframes orbit-3 {
  0% {
    transform: translate(0, -50%) rotate(180deg) translateX(200px) rotate(-180deg);
  }
  100% {
    transform: translate(0, -50%) rotate(540deg) translateX(200px) rotate(-540deg);
  }
}

@keyframes orbit-4 {
  0% {
    transform: translate(0, -50%) rotate(270deg) translateX(200px) rotate(-270deg);
  }
  100% {
    transform: translate(0, -50%) rotate(630deg) translateX(200px) rotate(-630deg);
  }
}

@keyframes particle-1 {
  0% {
    top: 10%;
    left: 10%;
    opacity: 0;
  }
  50% {
    opacity: 0.6;
  }
  100% {
    top: 90%;
    left: 90%;
    opacity: 0;
  }
}

@keyframes particle-2 {
  0% {
    top: 20%;
    right: 10%;
    opacity: 0;
  }
  50% {
    opacity: 0.4;
  }
  100% {
    top: 80%;
    right: 80%;
    opacity: 0;
  }
}

@keyframes particle-3 {
  0% {
    bottom: 10%;
    left: 20%;
    opacity: 0;
  }
  50% {
    opacity: 0.5;
  }
  100% {
    bottom: 80%;
    left: 80%;
    opacity: 0;
  }
}

@keyframes particle-4 {
  0% {
    bottom: 20%;
    right: 20%;
    opacity: 0;
  }
  50% {
    opacity: 0.3;
  }
  100% {
    bottom: 90%;
    right: 90%;
    opacity: 0;
  }
}

@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes expand {
  from {
    width: 0;
  }
  to {
    width: 100%;
  }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-dash {
  animation: dash 20s linear infinite;
}

.animate-dash-fast {
  animation: dash-fast 10s linear infinite;
}

.animate-gradient {
  background-size: 200% 200%;
  animation: gradient 3s ease infinite;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 5s ease infinite;
}

.animate-spin-slow {
  animation: spin-slow 20s linear infinite;
}

.animate-bounce-slow {
  animation: bounce-slow 2s ease-in-out infinite;
}

.animate-orbit-1 {
  animation: orbit-1 20s linear infinite;
}

.animate-orbit-2 {
  animation: orbit-2 20s linear infinite;
}

.animate-orbit-3 {
  animation: orbit-3 20s linear infinite;
}

.animate-orbit-4 {
  animation: orbit-4 20s linear infinite;
}

.animate-particle-1 {
  animation: particle-1 15s ease-in-out infinite;
}

.animate-particle-2 {
  animation: particle-2 18s ease-in-out infinite;
}

.animate-particle-3 {
  animation: particle-3 20s ease-in-out infinite;
}

.animate-particle-4 {
  animation: particle-4 22s ease-in-out infinite;
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out forwards;
}

.animate-fade-in {
  animation: fade-in 1s ease-out forwards;
}

.animate-expand {
  animation: expand 0.8s ease-out forwards;
}
</style>

