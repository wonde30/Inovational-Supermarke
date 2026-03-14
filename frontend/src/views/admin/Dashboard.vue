<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Decorative Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-green-200/30 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-teal-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <LoadingSpinner v-if="loading" />
    <div v-else class="relative z-10 space-y-4 p-4 sm:p-6">
      
      <!-- Revolutionary Welcome Header -->
      <div class="group relative bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-2xl p-6 shadow-2xl overflow-hidden border-2 border-green-300/50">
        <!-- Animated Background Shine -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-2000"></div>
        
        <!-- Animated Background Patterns -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
          <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        </div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="flex items-center gap-4">
            <!-- Avatar with Glow -->
            <div class="relative">
              <div class="absolute inset-0 bg-white rounded-2xl blur-lg opacity-50 animate-pulse"></div>
              <div class="relative w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-3xl sm:text-4xl shadow-2xl ring-4 ring-white/30 border-2 border-white/50">
                {{ userName.charAt(0).toUpperCase() }}
              </div>
            </div>
            
            <div>
              <h1 class="text-2xl sm:text-3xl font-black text-white flex items-center gap-2 mb-2">
                {{ t('common.welcome') }}, {{ userName }}!
                <span class="text-2xl sm:text-3xl animate-bounce inline-block">👋</span>
              </h1>
              <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <p class="text-white/90 text-sm flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/20">
                  <span>📅</span> {{ currentDate }}
                </p>
                <div class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/30">
                  <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                  <span class="text-white text-sm font-bold">{{ getRoleLabel }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Live Time Display -->
          <div class="relative bg-white/10 backdrop-blur-md rounded-xl px-4 py-3 border border-white/20 text-center">
            <p class="text-white/80 text-xs font-bold mb-1">{{ t('dashboard.currentTime') || 'Current Time' }}</p>
            <p class="text-white text-xl font-black">{{ currentTime }}</p>
          </div>
        </div>

        <!-- Animated Bottom Bar -->
        <div class="absolute bottom-0 left-0 right-0 flex h-1.5">
          <div class="flex-1 bg-green-400 animate-pulse"></div>
          <div class="flex-1 bg-yellow-400 animate-pulse" style="animation-delay: 0.3s"></div>
          <div class="flex-1 bg-red-400 animate-pulse" style="animation-delay: 0.6s"></div>
        </div>
      </div>

      <!-- Revolutionary Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Today's Sales -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border-2 border-green-200 hover:border-green-400 overflow-hidden">
          <!-- Animated Background -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover:opacity-5 transition-opacity"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
          
          <div class="relative flex items-start justify-between">
            <div class="flex-1">
              <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">{{ t('dashboard.todaySales') }}</p>
              <p class="text-3xl font-black text-green-600 mb-2">ETB {{ formatCurrency(data.today_sales) }}</p>
              <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 bg-green-50 px-2 py-1 rounded-full">
                  <span class="text-green-600 text-sm">📈</span>
                  <span class="text-xs text-green-700 font-bold">{{ data.today_transactions || 0 }} {{ (t('reports.transactions') || 'transactions').toLowerCase() }}</span>
                </div>
              </div>
            </div>
            <!-- Icon with Glow -->
            <div class="relative">
              <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl"></div>
              </div>
              <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all">💵</div>
            </div>
          </div>
          
          <!-- Live Indicator -->
          <div class="absolute top-3 right-3 w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg ring-2 ring-white"></div>
        </div>

        <!-- Monthly Sales -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border-2 border-blue-200 hover:border-blue-400 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 opacity-0 group-hover:opacity-5 transition-opacity"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
          
          <div class="relative flex items-start justify-between">
            <div class="flex-1">
              <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">{{ t('dashboard.totalSales') }}</p>
              <p class="text-3xl font-black text-blue-600 mb-2">ETB {{ formatCurrency(data.monthly_sales) }}</p>
              <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 bg-blue-50 px-2 py-1 rounded-full">
                  <span class="text-blue-600 text-sm">📊</span>
                  <span class="text-xs text-blue-700 font-bold">{{ currentMonth }}</span>
                </div>
              </div>
            </div>
            <div class="relative">
              <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl"></div>
              </div>
              <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all">📈</div>
            </div>
          </div>
          
          <div class="absolute top-3 right-3 w-3 h-3 bg-blue-500 rounded-full animate-pulse shadow-lg ring-2 ring-white"></div>
        </div>

        <!-- Total Products -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border-2 border-orange-200 hover:border-orange-400 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 opacity-0 group-hover:opacity-5 transition-opacity"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
          
          <div class="relative flex items-start justify-between">
            <div class="flex-1">
              <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">{{ t('dashboard.totalProducts') }}</p>
              <p class="text-3xl font-black text-orange-600 mb-2">{{ data.total_products }}</p>
              <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 bg-orange-50 px-2 py-1 rounded-full">
                  <span class="text-orange-600 text-sm">📦</span>
                  <span class="text-xs text-orange-700 font-bold">{{ data.categories_count || 0 }} {{ (t('categories.title') || 'categories').toLowerCase() }}</span>
                </div>
              </div>
            </div>
            <div class="relative">
              <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl"></div>
              </div>
              <div class="relative w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all">📦</div>
            </div>
          </div>
          
          <div class="absolute top-3 right-3 w-3 h-3 bg-orange-500 rounded-full animate-pulse shadow-lg ring-2 ring-white"></div>
        </div>

        <!-- Stock Alerts -->
        <router-link to="/admin/stock-alerts" class="group relative bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all border-2 overflow-hidden cursor-pointer" :class="alertCounts.total > 0 ? 'border-red-300 hover:border-red-500' : 'border-gray-200 hover:border-gray-300'">
          <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-rose-600 opacity-0 group-hover:opacity-5 transition-opacity"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
          
          <div class="relative flex items-start justify-between">
            <div class="flex-1">
              <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">{{ t('dashboard.stockAlerts') }}</p>
              <p class="text-3xl font-black mb-2" :class="alertCounts.total > 0 ? 'text-red-600' : 'text-gray-400'">{{ alertCounts.total }}</p>
              <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 px-2 py-1 rounded-full" :class="alertCounts.total > 0 ? 'bg-red-50' : 'bg-gray-50'">
                  <span :class="alertCounts.total > 0 ? 'animate-pulse' : ''">🚨</span>
                  <span class="text-xs font-bold" :class="alertCounts.total > 0 ? 'text-red-700' : 'text-gray-600'">{{ alertCounts.out_of_stock }} out, {{ alertCounts.low_stock }} low</span>
                </div>
              </div>
            </div>
            <div class="relative">
              <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
                <div class="w-14 h-14 rounded-2xl" :class="alertCounts.total > 0 ? 'bg-gradient-to-br from-red-500 to-rose-600' : 'bg-gradient-to-br from-gray-400 to-gray-500'"></div>
              </div>
              <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all" :class="alertCounts.total > 0 ? 'bg-gradient-to-br from-red-500 to-rose-600' : 'bg-gradient-to-br from-gray-400 to-gray-500'">⚠️</div>
            </div>
          </div>
          
          <div v-if="alertCounts.total > 0" class="absolute top-3 right-3 w-3 h-3 bg-red-500 rounded-full animate-ping shadow-lg"></div>
        </router-link>
      </div>

      <!-- Revolutionary Alert Banner -->
      <div v-if="alertCounts.total > 0" class="group relative bg-gradient-to-r from-red-500 via-rose-500 to-red-600 rounded-2xl p-5 shadow-2xl overflow-hidden border-2 border-red-300">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
        
        <div class="relative flex flex-col sm:flex-row items-center gap-4">
          <!-- Animated Alert Icon -->
          <div class="relative">
            <div class="absolute inset-0 bg-white rounded-2xl blur-lg opacity-50 animate-pulse"></div>
            <div class="relative w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/50">
              <span class="text-4xl animate-bounce">⚠️</span>
            </div>
          </div>
          
          <div class="flex-1 text-center sm:text-left">
            <p class="font-black text-xl text-white mb-1 flex items-center justify-center sm:justify-start gap-2">
              <span class="animate-pulse">🚨</span>
              {{ t('dashboard.stockAlerts') }}!
            </p>
            <p class="text-white/90 text-sm font-bold">
              {{ alertCounts.out_of_stock }} {{ t('dashboard.outOfStock') }} • {{ alertCounts.low_stock }} {{ t('dashboard.runningLow') }}
            </p>
          </div>
          
          <router-link to="/admin/stock-alerts" class="group/btn relative px-6 py-3 bg-white hover:bg-yellow-50 text-red-600 rounded-xl font-black transition-all shadow-xl hover:shadow-2xl flex items-center gap-2 overflow-hidden hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/0 via-yellow-400/20 to-yellow-400/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
            <span class="relative text-xl">🔔</span>
            <span class="relative">{{ t('dashboard.viewAll') }}</span>
          </router-link>
        </div>
      </div>

      <!-- Revolutionary Quick Actions & Performance -->
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        <!-- Quick Actions - Revolutionary Design -->
        <div class="lg:col-span-3 group relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          
          <h3 class="relative text-xl font-black text-gray-800 flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
              <span class="text-xl">⚡</span>
            </div>
            {{ t('dashboard.quickActions') }}
          </h3>
          
          <div class="relative grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- New Sale Button -->
            <router-link v-if="canAccessPOS" to="/admin/pos" class="group/btn relative flex flex-col items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl hover:shadow-xl transition-all border-2 border-blue-200 hover:border-blue-400 overflow-hidden hover:scale-105">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 opacity-0 group-hover/btn:opacity-10 transition-opacity"></div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
              
              <div class="relative mb-3">
                <div class="absolute inset-0 blur-md opacity-50 group-hover/btn:opacity-75 transition-opacity">
                  <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl"></div>
                </div>
                <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg group-hover/btn:scale-110 group-hover/btn:rotate-6 transition-all">
                  <span class="text-2xl">🛒</span>
                </div>
              </div>
              
              <p class="relative font-black text-gray-800 text-sm text-center mb-1">{{ t('dashboard.newSale') }}</p>
              <p class="relative text-xs text-blue-600 font-bold">ሽያጭ</p>
              
              <div class="absolute top-2 right-2 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
            </router-link>

            <!-- Products Button -->
            <router-link to="/admin/products" class="group/btn relative flex flex-col items-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl hover:shadow-xl transition-all border-2 border-orange-200 hover:border-orange-400 overflow-hidden hover:scale-105">
              <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 opacity-0 group-hover/btn:opacity-10 transition-opacity"></div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
              
              <div class="relative mb-3">
                <div class="absolute inset-0 blur-md opacity-50 group-hover/btn:opacity-75 transition-opacity">
                  <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl"></div>
                </div>
                <div class="relative w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover/btn:scale-110 group-hover/btn:rotate-6 transition-all">
                  <span class="text-2xl">📦</span>
                </div>
              </div>
              
              <p class="relative font-black text-gray-800 text-sm text-center mb-1">{{ t('navigation.products') }}</p>
              <p class="relative text-xs text-orange-600 font-bold">ምርቶች</p>
              
              <div class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
            </router-link>

            <!-- Reports Button -->
            <router-link to="/admin/reports" class="group/btn relative flex flex-col items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl hover:shadow-xl transition-all border-2 border-purple-200 hover:border-purple-400 overflow-hidden hover:scale-105">
              <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 opacity-0 group-hover/btn:opacity-10 transition-opacity"></div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
              
              <div class="relative mb-3">
                <div class="absolute inset-0 blur-md opacity-50 group-hover/btn:opacity-75 transition-opacity">
                  <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl"></div>
                </div>
                <div class="relative w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover/btn:scale-110 group-hover/btn:rotate-6 transition-all">
                  <span class="text-2xl">📊</span>
                </div>
              </div>
              
              <p class="relative font-black text-gray-800 text-sm text-center mb-1">{{ t('navigation.reports') }}</p>
              <p class="relative text-xs text-purple-600 font-bold">ሪፖርት</p>
              
              <div class="absolute top-2 right-2 w-2 h-2 bg-purple-500 rounded-full animate-pulse"></div>
            </router-link>

            <!-- Customers Button -->
            <router-link to="/admin/customers" class="group/btn relative flex flex-col items-center p-4 bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl hover:shadow-xl transition-all border-2 border-amber-200 hover:border-amber-400 overflow-hidden hover:scale-105">
              <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-600 opacity-0 group-hover/btn:opacity-10 transition-opacity"></div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
              
              <div class="relative mb-3">
                <div class="absolute inset-0 blur-md opacity-50 group-hover/btn:opacity-75 transition-opacity">
                  <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl"></div>
                </div>
                <div class="relative w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover/btn:scale-110 group-hover/btn:rotate-6 transition-all">
                  <span class="text-2xl">👥</span>
                </div>
              </div>
              
              <p class="relative font-black text-gray-800 text-sm text-center mb-1">{{ t('navigation.customers') }}</p>
              <p class="relative text-xs text-amber-600 font-bold">ደንበኞች</p>
              
              <div class="absolute top-2 right-2 w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
            </router-link>
          </div>
        </div>

        <!-- Performance Summary - Revolutionary Design -->
        <div class="lg:col-span-2 group relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          
          <h3 class="relative text-xl font-black text-gray-800 flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
              <span class="text-xl">📈</span>
            </div>
            {{ t('dashboard.salesOverview') }}
          </h3>
          
          <div class="relative space-y-5">
            <!-- Today Progress -->
            <div>
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-bold text-gray-700 flex items-center gap-2">
                  <span>☀️</span> {{ t('dashboard.today') }}
                </span>
                <span class="text-lg font-black text-green-600">{{ dailyProgress }}%</span>
              </div>
              <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 h-full rounded-full transition-all duration-500 shadow-lg" :style="{ width: dailyProgress + '%' }">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 animate-shimmer"></div>
                </div>
              </div>
            </div>

            <!-- Monthly Progress -->
            <div>
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-bold text-gray-700 flex items-center gap-2">
                  <span>📅</span> {{ t('dashboard.thisMonth') }}
                </span>
                <span class="text-lg font-black text-blue-600">{{ monthlyProgress }}%</span>
              </div>
              <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-600 h-full rounded-full transition-all duration-500 shadow-lg" :style="{ width: monthlyProgress + '%' }">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 animate-shimmer"></div>
                </div>
              </div>
            </div>

            <!-- Stock Health -->
            <div>
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-bold text-gray-700 flex items-center gap-2">
                  <span>📦</span> {{ t('products.stock') }}
                </span>
                <span class="text-lg font-black" :class="stockHealth > 70 ? 'text-green-600' : stockHealth > 40 ? 'text-amber-600' : 'text-red-600'">{{ stockHealth }}%</span>
              </div>
              <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="h-full rounded-full transition-all duration-500 shadow-lg" :class="stockHealth > 70 ? 'bg-gradient-to-r from-green-500 to-emerald-600' : stockHealth > 40 ? 'bg-gradient-to-r from-amber-500 to-orange-600' : 'bg-gradient-to-r from-red-500 to-rose-600'" :style="{ width: stockHealth + '%' }">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 animate-shimmer"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Recent Sales & Top Products -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Recent Sales -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          
          <div class="relative flex items-center justify-between mb-5">
            <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-xl">💰</span>
              </div>
              {{ t('dashboard.recentSales') }}
            </h3>
            <router-link to="/admin/sales" class="group/link flex items-center gap-2 text-green-600 hover:text-green-700 font-black text-sm transition-all hover:scale-105">
              {{ t('dashboard.viewAll') }}
              <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
            </router-link>
          </div>
          
          <div class="relative space-y-3">
            <div v-for="sale in data.recent_sales?.slice(0, 4)" :key="sale.id" class="group/item relative flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-green-50 rounded-xl hover:shadow-lg transition-all border-2 border-gray-100 hover:border-green-300 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 to-green-500/5 opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
              
              <div class="relative flex items-center gap-3">
                <div class="relative">
                  <div class="absolute inset-0 blur-md opacity-50 group-hover/item:opacity-75 transition-opacity">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl"></div>
                  </div>
                  <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg group-hover/item:scale-110 group-hover/item:rotate-6 transition-all">
                    {{ (sale.invoice_number || '00').toString().slice(-2) }}
                  </div>
                </div>
                <div>
                  <p class="font-black text-gray-800 text-sm">{{ sale.invoice_number }}</p>
                  <p class="text-xs text-gray-500 flex items-center gap-1">
                    <span>📅</span> {{ formatDate(sale.created_at) }}
                  </p>
                </div>
              </div>
              
              <div class="relative text-right">
                <p class="font-black text-green-600 text-base mb-1">ETB {{ formatCurrency(sale.total) }}</p>
                <span :class="paymentBadgeClass(sale.payment_method)" class="inline-block px-3 py-1 rounded-full text-xs font-bold shadow-sm">{{ paymentLabel(sale.payment_method) }}</span>
              </div>
            </div>
            
            <div v-if="!data.recent_sales?.length" class="text-center py-12">
              <div class="relative inline-block mb-4">
                <div class="absolute inset-0 blur-xl opacity-30">
                  <div class="w-20 h-20 bg-gray-400 rounded-full"></div>
                </div>
                <div class="relative text-6xl">📋</div>
              </div>
              <p class="font-black text-gray-400 text-lg">{{ t('dashboard.startSelling') }}</p>
            </div>
          </div>
        </div>

        <!-- Top Products -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          
          <div class="relative flex items-center justify-between mb-5">
            <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-xl">🏆</span>
              </div>
              {{ t('dashboard.topProducts') }}
            </h3>
            <router-link to="/admin/products" class="group/link flex items-center gap-2 text-orange-600 hover:text-orange-700 font-black text-sm transition-all hover:scale-105">
              {{ t('dashboard.viewAll') }}
              <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
            </router-link>
          </div>
          
          <div class="relative space-y-3">
            <div v-for="(product, index) in topProducts" :key="product.id" class="group/item relative flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-orange-50 rounded-xl hover:shadow-lg transition-all border-2 border-gray-100 hover:border-orange-300 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-orange-500/5 opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
              
              <div class="relative flex items-center gap-3">
                <div class="relative">
                  <div class="absolute inset-0 blur-md opacity-50 group-hover/item:opacity-75 transition-opacity">
                    <div class="w-12 h-12 rounded-xl" :class="index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-orange-500 to-red-600'"></div>
                  </div>
                  <div class="relative w-12 h-12 rounded-xl flex items-center justify-center text-white font-black text-base shadow-lg group-hover/item:scale-110 group-hover/item:rotate-6 transition-all" :class="index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-orange-500 to-red-600'">
                    {{ index + 1 }}
                  </div>
                </div>
                <div>
                  <p class="font-black text-gray-800 text-sm">{{ product.name }}</p>
                  <p class="text-xs text-gray-500 flex items-center gap-1">
                    <span>📦</span> {{ product.sold || 0 }} {{ (t('reports.unitsSold') || 'units sold').toLowerCase() }}
                  </p>
                </div>
              </div>
              
              <div class="relative text-right">
                <p class="font-black text-orange-600 text-base">ETB {{ formatCurrency(product.revenue || 0) }}</p>
              </div>
              
              <!-- Trophy for top 3 -->
              <div v-if="index < 3" class="absolute top-2 right-2">
                <span class="text-lg" :class="index === 0 ? 'animate-bounce' : 'animate-pulse'">
                  {{ index === 0 ? '🥇' : index === 1 ? '🥈' : '🥉' }}
                </span>
              </div>
            </div>
            
            <div v-if="!topProducts.length" class="text-center py-12">
              <div class="relative inline-block mb-4">
                <div class="absolute inset-0 blur-xl opacity-30">
                  <div class="w-20 h-20 bg-gray-400 rounded-full"></div>
                </div>
                <div class="relative text-6xl">🏆</div>
              </div>
              <p class="font-black text-gray-400 text-lg">{{ t('messages.noDataFound') }}</p>
              <p class="text-sm text-gray-400 mt-1">{{ t('dashboard.startSellingTopProducts') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary System Overview -->
      <div class="group relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <h3 class="relative text-xl font-black text-gray-800 flex items-center gap-3 mb-5">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
            <span class="text-xl">📊</span>
          </div>
          {{ t('dashboard.systemOverview') }}
        </h3>
        
        <div class="relative grid grid-cols-2 md:grid-cols-4 gap-4">
          <!-- Products -->
          <div class="group/card relative text-center p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all hover:shadow-lg overflow-hidden hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover/card:opacity-10 transition-opacity"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-700"></div>
            
            <div class="relative mb-3">
              <div class="absolute inset-0 blur-md opacity-50 group-hover/card:opacity-75 transition-opacity mx-auto" style="width: 48px; height: 48px;">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl"></div>
              </div>
              <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-2xl shadow-lg mx-auto group-hover/card:scale-110 group-hover/card:rotate-6 transition-all">📦</div>
            </div>
            
            <p class="relative text-3xl font-black text-blue-600 mb-2">{{ data.total_products || 0 }}</p>
            <p class="relative text-xs text-gray-700 font-bold uppercase tracking-wide">{{ t('navigation.products') }}</p>
            
            <div class="absolute top-2 right-2 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
          </div>

          <!-- Customers -->
          <div class="group/card relative text-center p-5 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all hover:shadow-lg overflow-hidden hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover/card:opacity-10 transition-opacity"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-700"></div>
            
            <div class="relative mb-3">
              <div class="absolute inset-0 blur-md opacity-50 group-hover/card:opacity-75 transition-opacity mx-auto" style="width: 48px; height: 48px;">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl"></div>
              </div>
              <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-2xl shadow-lg mx-auto group-hover/card:scale-110 group-hover/card:rotate-6 transition-all">👥</div>
            </div>
            
            <p class="relative text-3xl font-black text-green-600 mb-2">{{ data.total_customers || 0 }}</p>
            <p class="relative text-xs text-gray-700 font-bold uppercase tracking-wide">{{ t('navigation.customers') }}</p>
            
            <div class="absolute top-2 right-2 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
          </div>

          <!-- Suppliers -->
          <div class="group/card relative text-center p-5 bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl border-2 border-orange-200 hover:border-orange-400 transition-all hover:shadow-lg overflow-hidden hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 opacity-0 group-hover/card:opacity-10 transition-opacity"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-700"></div>
            
            <div class="relative mb-3">
              <div class="absolute inset-0 blur-md opacity-50 group-hover/card:opacity-75 transition-opacity mx-auto" style="width: 48px; height: 48px;">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl"></div>
              </div>
              <div class="relative w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center text-2xl shadow-lg mx-auto group-hover/card:scale-110 group-hover/card:rotate-6 transition-all">🏭</div>
            </div>
            
            <p class="relative text-3xl font-black text-orange-600 mb-2">{{ data.total_suppliers || 0 }}</p>
            <p class="relative text-xs text-gray-700 font-bold uppercase tracking-wide">{{ t('navigation.suppliers') }}</p>
            
            <div class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
          </div>

          <!-- Total Sales -->
          <div class="group/card relative text-center p-5 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl border-2 border-amber-200 hover:border-amber-400 transition-all hover:shadow-lg overflow-hidden hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-yellow-600 opacity-0 group-hover/card:opacity-10 transition-opacity"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-700"></div>
            
            <div class="relative mb-3">
              <div class="absolute inset-0 blur-md opacity-50 group-hover/card:opacity-75 transition-opacity mx-auto" style="width: 48px; height: 48px;">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl"></div>
              </div>
              <div class="relative w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center text-2xl shadow-lg mx-auto group-hover/card:scale-110 group-hover/card:rotate-6 transition-all">💰</div>
            </div>
            
            <p class="relative text-3xl font-black text-amber-600 mb-2">{{ data.total_sales || 0 }}</p>
            <p class="relative text-xs text-gray-700 font-bold uppercase tracking-wide">{{ t('dashboard.totalSales') }}</p>
            
            <div class="absolute top-2 right-2 w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { dashboardApi, advancedApi, reportsApi } from '../../services/api'
import { useAuthStore } from '../../stores/auth'
import { useTranslation } from '@/composables/useTranslation'
import LoadingSpinner from '../../components/LoadingSpinner.vue'

const { t } = useTranslation()

const authStore = useAuthStore()
const loading = ref(true)
const data = ref({ today_sales: 0, monthly_sales: 0, total_products: 0, low_stock_count: 0, recent_sales: [], categories_count: 0, total_customers: 0, total_suppliers: 0, total_sales: 0 })
const alertCounts = ref({ out_of_stock: 0, low_stock: 0, expiring_soon: 0, expired: 0, total: 0 })
const topProducts = ref([])
const currentTime = ref('')

// Update time every second
const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('en-ET', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true })
}

onMounted(() => {
  updateTime()
  setInterval(updateTime, 1000)
})

const userName = computed(() => authStore.user?.name?.split(' ')[0] || 'User')
const userRole = computed(() => authStore.user?.role || 'user')
const canAccessPOS = computed(() => ['admin', 'manager', 'cashier'].includes(userRole.value))

const getRoleLabel = computed(() => {
  const labels = { 
    admin: `👑 Admin`, 
    manager: `👔 Manager`, 
    cashier: `💵 Cashier`, 
    storekeeper: `📦 Storekeeper`, 
    customer: `🛍️ Customer` 
  }
  return labels[userRole.value] || 'User'
})

const currentDate = computed(() => {
  return new Date().toLocaleDateString('en-ET', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
})

const currentMonth = computed(() => new Date().toLocaleDateString('en-ET', { month: 'long' }))
const currentYear = computed(() => new Date().getFullYear())

const dailyProgress = computed(() => {
  const target = 50000 // Daily target in ETB
  const progress = Math.min(100, Math.round((data.value.today_sales / target) * 100))
  return progress || 0
})

const monthlyProgress = computed(() => {
  const target = 1000000 // Monthly target in ETB
  const progress = Math.min(100, Math.round((data.value.monthly_sales / target) * 100))
  return progress || 0
})

const stockHealth = computed(() => {
  const total = data.value.total_products || 1
  const problematic = alertCounts.value.total || 0
  return Math.max(0, Math.round(((total - problematic) / total) * 100))
})

const formatDate = (date) => new Date(date).toLocaleDateString('en-ET', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' })

const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const paymentBadgeClass = (method) => {
  const classes = { 
    cash: 'bg-green-100 text-green-700 border border-green-300', 
    mobile_banking: 'bg-blue-100 text-blue-700 border border-blue-300', 
    bank_transfer: 'bg-purple-100 text-purple-700 border border-purple-300', 
    credit: 'bg-amber-100 text-amber-700 border border-amber-300' 
  }
  return classes[method] || 'bg-gray-100 text-gray-700 border border-gray-300'
}

const paymentLabel = (method) => {
  const labels = { 
    cash: `💵 ${t('pos.cash')}`, 
    mobile_banking: `📱 ${t('pos.mobileMoney')}`, 
    bank_transfer: `🏦 ${t('pos.card')}`, 
    credit: '📝 Credit' 
  }
  return labels[method] || method
}

onMounted(async () => {
  try {
    const [dashboardRes, alertsRes, topRes] = await Promise.all([
      dashboardApi.get(),
      advancedApi.stockAlerts().catch(() => ({ data: { counts: { out_of_stock: 0, low_stock: 0, expiring_soon: 0, expired: 0, total: 0 } } })),
      reportsApi.topProducts({ limit: 5 }).catch(() => ({ data: [] }))
    ])
    data.value = dashboardRes.data
    alertCounts.value = alertsRes.data?.counts || { out_of_stock: 0, low_stock: 0, expiring_soon: 0, expired: 0, total: 0 }
    topProducts.value = topRes.data || []
  } catch (e) {
    console.error('Failed to load dashboard', e)
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.animate-shimmer {
  animation: shimmer 2s infinite;
}

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

/* Custom scrollbar for better aesthetics */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(135deg, #059669 0%, #047857 100%);
}
</style>
