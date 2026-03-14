<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Sales Header -->
    <div class="relative z-10 mb-6">
      <div class="relative group">
        <!-- 3D Background Layer -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-105 shadow-2xl"></div>
        
        <!-- Main Content Layer -->
        <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-6 lg:p-8 text-white shadow-2xl overflow-hidden border border-white/20 mx-4 mt-4">
          <!-- Animated Mesh Background -->
          <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
          </div>
          
          <!-- Floating Particles -->
          <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle-float absolute w-2 h-2 bg-white/60 rounded-full" style="top: 20%; left: 10%; animation-delay: 0s"></div>
            <div class="particle-float absolute w-3 h-3 bg-yellow-300/40 rounded-full" style="top: 60%; left: 80%; animation-delay: 1s"></div>
            <div class="particle-float absolute w-2 h-2 bg-pink-300/50 rounded-full" style="top: 40%; left: 60%; animation-delay: 2s"></div>
          </div>
          
          <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
              <!-- 3D Sales Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">💰</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart Sales Analytics / የሽያጭ ትንተና
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📊</span>
                  <span>{{ sales.length }} Sales Today</span>
                  <span class="mx-2">•</span>
                  <span>💵</span>
                  <span>ETB {{ formatCurrency(stats.todayRevenue) }} Revenue</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="exportSales" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📤</span>
                <span class="relative">Export Data</span>
              </button>
              
              <router-link to="/admin/pos" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">➕</span>
                <span class="relative">New Sale</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4 space-y-6">
      <!-- Revolutionary Sales Analytics Dashboard -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-emerald-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-100 to-green-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-4xl font-black text-emerald-600 mb-1">{{ stats.todayCount }}</p>
                <p class="text-sm text-gray-600 font-bold">Today's Sales</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-emerald-600 font-medium">Active Transactions</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-green-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">📊</div>
            </div>
          </div>
        </div>

        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-3xl font-black text-blue-600 mb-1">ETB {{ formatCurrency(stats.todayRevenue) }}</p>
                <p class="text-sm text-gray-600 font-bold">Today's Revenue</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-blue-600 font-medium">Daily Earnings</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-cyan-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">💵</div>
            </div>
          </div>
        </div>

        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-purple-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-3xl font-black text-purple-600 mb-1">ETB {{ formatCurrency(stats.monthRevenue) }}</p>
                <p class="text-sm text-gray-600 font-bold">Monthly Revenue</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-purple-600 font-medium">Month Progress</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-pink-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">📅</div>
            </div>
          </div>
        </div>

        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-orange-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-100 to-red-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-3xl font-black text-orange-600 mb-1">ETB {{ formatCurrency(stats.avgSale) }}</p>
                <p class="text-sm text-gray-600 font-bold">Average Sale</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-orange-600 font-medium">Per Transaction</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-red-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">📈</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Search & Filter Section -->
      <div class="group relative transform transition-all duration-500 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
          <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Enhanced Search -->
            <div class="md:col-span-2 relative group/search">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-blue-600 transition-colors">
                <span class="text-2xl">🔍</span>
              </div>
              <input 
                v-model="search" 
                @input="debouncedFetch"
                type="text" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Search by invoice number or cashier..."
              />
            </div>
            
            <!-- Payment Filter -->
            <div class="relative group/payment">
              <select 
                v-model="paymentFilter" 
                @change="fetchSales()"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="">All Payments</option>
                <option value="cash">💵 Cash</option>
                <option value="mobile_banking">📱 Mobile Banking</option>
                <option value="bank_transfer">🏦 Bank Transfer</option>
                <option value="credit">📝 Credit</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/payment:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            
            <!-- Status Filter -->
            <div class="relative group/status">
              <select 
                v-model="statusFilter" 
                @change="fetchSales()"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="">All Status</option>
                <option value="completed">✅ Completed</option>
                <option value="pending">⏳ Pending</option>
                <option value="cancelled">❌ Cancelled</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/status:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            
            <!-- Date Filter -->
            <div class="relative group/date">
              <input 
                v-model="dateFilter" 
                @change="fetchSales()"
                type="date" 
                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Sales Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="relative">
          <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
          <div class="relative w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center shadow-xl">
            <div class="loading-spinner w-10 h-10"></div>
          </div>
        </div>
      </div>

      <div v-else-if="sales.length === 0" class="relative group py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-3xl blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-6xl">🧾</span>
            </div>
          </div>
          <h3 class="text-3xl font-black text-gray-700 mb-4">No Sales Found</h3>
          <p class="text-gray-500 text-lg mb-8">Sales transactions will appear here when customers make purchases</p>
          <router-link to="/admin/pos" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1">
            <span class="text-2xl">➕</span>
            <span>Make Your First Sale</span>
          </router-link>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <div 
          v-for="sale in sales" 
          :key="sale.id" 
          class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
          @click="viewSale(sale)"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Sale Card -->
          <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all">
            <!-- Enhanced Sale Header -->
            <div class="relative bg-gradient-to-r from-indigo-50 to-purple-50 p-4 border-b border-gray-100">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                    🧾
                  </div>
                  <div>
                    <h3 class="font-black text-gray-900 text-lg">{{ sale.invoice_number }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(sale.created_at) }} • {{ formatTime(sale.created_at) }}</p>
                  </div>
                </div>
                
                <!-- Enhanced Status Badge -->
                <div class="relative">
                  <span v-if="sale.payment_status === 'completed' || sale.status === 'completed'" class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full text-sm font-bold shadow-lg">
                    ✅ Completed
                  </span>
                  <span v-else-if="sale.payment_status === 'pending' || sale.status === 'pending'" class="px-3 py-1.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-full text-sm font-bold shadow-lg animate-pulse">
                    ⏳ Pending
                  </span>
                  <span v-else class="px-3 py-1.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full text-sm font-bold shadow-lg">
                    {{ sale.payment_status || sale.status || 'Completed' }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Enhanced Sale Details -->
            <div class="p-4 space-y-4">
              <!-- Cashier Info -->
              <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-cyan-200 rounded-full flex items-center justify-center">
                  <span class="text-xl">👤</span>
                </div>
                <div class="flex-1">
                  <p class="font-bold text-gray-900">{{ sale.user?.name || 'System' }}</p>
                  <p class="text-sm text-gray-600">Cashier</p>
                </div>
              </div>
              
              <!-- Sale Summary -->
              <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                  <p class="text-2xl font-black text-purple-600">{{ sale.items_count || sale.sale_items?.length || 0 }}</p>
                  <p class="text-xs text-purple-700 font-bold">Items</p>
                </div>
                <div class="text-center p-3 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100">
                  <p class="text-lg font-black text-green-600">ETB {{ formatCurrency(sale.total) }}</p>
                  <p class="text-xs text-green-700 font-bold">Total</p>
                </div>
              </div>
              
              <!-- Payment Method -->
              <div class="p-3 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
                <div class="flex items-center gap-2">
                  <span class="text-lg">{{ getPaymentIcon(sale.payment_method) }}</span>
                  <div>
                    <p class="text-sm font-bold text-blue-800">Payment Method</p>
                    <p class="text-xs text-blue-600">{{ formatPaymentMethod(sale.payment_method) }}</p>
                  </div>
                </div>
              </div>
              
              <!-- Financial Breakdown -->
              <div class="space-y-2 pt-2 border-t border-gray-200">
                <div class="flex justify-between text-sm text-gray-600">
                  <span>Subtotal:</span>
                  <span>ETB {{ formatCurrency(sale.subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                  <span>VAT (15%):</span>
                  <span>ETB {{ formatCurrency(sale.tax) }}</span>
                </div>
                <div class="flex justify-between text-lg font-black text-green-600 border-t border-gray-300 pt-2">
                  <span>Total:</span>
                  <span>ETB {{ formatCurrency(sale.total) }}</span>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex gap-2 pt-2">
                <button @click.stop="viewSale(sale)" class="flex-1 px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 text-white rounded-xl font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                  <span>👁️</span>
                  <span>View Details</span>
                </button>
                
                <button @click.stop="printReceipt(sale)" class="px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-400 hover:to-pink-500 text-white rounded-xl font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                  <span>🖨️</span>
                  <span>Print</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Pagination -->
      <div v-if="meta.last_page > 1" class="group relative transform transition-all duration-500 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-gray-300 transition-all">
          <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600 font-medium">
              Showing {{ (meta.current_page - 1) * meta.per_page + 1 }} to {{ Math.min(meta.current_page * meta.per_page, meta.total) }} of {{ meta.total }} sales
            </p>
            <div class="flex gap-2">
              <button 
                @click="fetchSales(meta.current_page - 1)" 
                :disabled="meta.current_page === 1"
                class="px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-400 hover:to-gray-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                ← Previous
              </button>
              <template v-for="page in visiblePages" :key="page">
                <button 
                  v-if="page !== '...'"
                  @click="fetchSales(page)"
                  class="px-4 py-2 rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105"
                  :class="page === meta.current_page 
                    ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' 
                    : 'bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700'"
                >
                  {{ page }}
                </button>
                <span v-else class="px-2 text-gray-400">...</span>
              </template>
              <button 
                @click="fetchSales(meta.current_page + 1)" 
                :disabled="meta.current_page === meta.last_page"
                class="px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-400 hover:to-gray-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Next →
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Revolutionary Sale Details Modal -->
  <div v-if="showModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="relative group max-w-4xl w-full max-h-[90vh] overflow-hidden">
      <!-- 3D Background -->
      <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
      
      <!-- Main Modal -->
      <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl font-black">
                🧾
              </div>
              <div>
                <h3 class="text-2xl font-black">Sale Details</h3>
                <p class="text-indigo-100 text-sm">{{ selectedSale?.invoice_number }}</p>
              </div>
            </div>
            <button @click="showModal = false" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
              <span class="text-xl">✕</span>
            </button>
          </div>
        </div>
        
        <!-- Modal Body -->
        <div v-if="selectedSale" class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
          <!-- Sale Header Info -->
          <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border-2 border-indigo-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                  <span class="text-2xl text-white">📋</span>
                </div>
                <p class="text-sm text-gray-500 font-bold">Invoice Number</p>
                <p class="text-xl font-black text-indigo-600">{{ selectedSale.invoice_number }}</p>
              </div>
              <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                  <span class="text-2xl text-white">📅</span>
                </div>
                <p class="text-sm text-gray-500 font-bold">Date & Time</p>
                <p class="text-lg font-black text-blue-600">{{ formatDateTime(selectedSale.created_at) }}</p>
              </div>
              <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                  <span class="text-2xl text-white">👤</span>
                </div>
                <p class="text-sm text-gray-500 font-bold">Cashier</p>
                <p class="text-lg font-black text-green-600">{{ selectedSale.user?.name || 'System' }}</p>
              </div>
            </div>
          </div>

          <!-- Payment Method Info -->
          <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border-2 border-blue-100">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                <span class="text-xl text-white">{{ getPaymentIcon(selectedSale.payment_method) }}</span>
              </div>
              <div>
                <p class="text-sm font-bold text-blue-900">Payment Method</p>
                <p class="text-lg font-black text-blue-700">{{ formatPaymentMethod(selectedSale.payment_method) }}</p>
              </div>
            </div>
          </div>

          <!-- Items List -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border-2 border-gray-200">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                <span class="text-xl text-white">🛍️</span>
              </div>
              <h4 class="font-bold text-gray-900 text-lg">Items Purchased</h4>
            </div>
            <div class="space-y-3">
              <div v-for="item in selectedSale.sale_items" :key="item.id" class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex-1">
                  <p class="font-bold text-gray-900 text-lg">{{ item.product?.name || 'Product' }}</p>
                  <p class="text-sm text-gray-600">Unit Price: ETB {{ formatCurrency(item.unit_price || item.price) }}</p>
                </div>
                <div class="text-center mx-4">
                  <span class="bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg font-bold text-lg">{{ item.quantity }}</span>
                  <p class="text-xs text-gray-500 mt-1">Quantity</p>
                </div>
                <div class="text-right">
                  <p class="font-black text-green-600 text-xl">ETB {{ formatCurrency(item.total || (item.quantity * (item.unit_price || item.price))) }}</p>
                  <p class="text-xs text-gray-500">Total</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Financial Summary -->
          <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border-2 border-emerald-200">
            <h4 class="font-bold text-emerald-900 mb-4 flex items-center gap-2 text-lg">
              <span class="text-xl">💰</span>
              <span>Financial Summary</span>
            </h4>
            <div class="space-y-4">
              <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                <span class="text-gray-700 font-medium">Subtotal</span>
                <span class="font-bold text-gray-900 text-lg">ETB {{ formatCurrency(selectedSale.subtotal) }}</span>
              </div>
              <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                <span class="text-gray-700 font-medium">VAT (15%)</span>
                <span class="font-bold text-gray-900 text-lg">ETB {{ formatCurrency(selectedSale.tax) }}</span>
              </div>
              <div v-if="selectedSale.discount > 0" class="flex justify-between items-center p-3 bg-red-50 rounded-lg border border-red-200">
                <span class="text-red-700 font-medium">Discount</span>
                <span class="font-bold text-red-600 text-lg">- ETB {{ formatCurrency(selectedSale.discount) }}</span>
              </div>
              <div class="flex justify-between items-center p-4 bg-gradient-to-r from-emerald-500 to-green-600 rounded-lg text-white">
                <span class="font-bold text-xl">Grand Total</span>
                <span class="font-black text-2xl">ETB {{ formatCurrency(selectedSale.total) }}</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="bg-gray-50 p-6 flex gap-4">
          <button 
            @click="printReceipt(selectedSale)" 
            class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2"
          >
            <span>🖨️</span>
            <span>Print Receipt</span>
          </button>
          <button 
            @click="showModal = false" 
            class="flex-1 px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-500 hover:to-gray-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2"
          >
            <span>✅</span>
            <span>Close</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { salesApi, dashboardApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'

const toast = useToastStore()
const loading = ref(true)
const sales = ref([])
const meta = ref({ current_page: 1, last_page: 1, per_page: 15, total: 0 })
const search = ref('')
const paymentFilter = ref('')
const statusFilter = ref('')
const dateFilter = ref('')
const showModal = ref(false)
const selectedSale = ref(null)
const stats = ref({ todayCount: 0, todayRevenue: 0, monthRevenue: 0, avgSale: 0 })

let debounceTimer = null
const debouncedFetch = () => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => fetchSales(), 300)
}

const visiblePages = computed(() => {
  const pages = []
  const total = meta.value.last_page
  const current = meta.value.current_page
  
  if (total <= 7) {
    for (let i = 1; i <= total; i++) pages.push(i)
  } else {
    pages.push(1)
    if (current > 3) pages.push('...')
    for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
      pages.push(i)
    }
    if (current < total - 2) pages.push('...')
    pages.push(total)
  }
  return pages
})

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
const formatDate = (date) => date ? new Date(date).toLocaleDateString('en-ET', { day: '2-digit', month: 'short', year: 'numeric' }) : ''
const formatTime = (date) => date ? new Date(date).toLocaleTimeString('en-ET', { hour: '2-digit', minute: '2-digit' }) : ''
const formatDateTime = (date) => date ? new Date(date).toLocaleString('en-ET', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''

const formatPaymentMethod = (method) => {
  const methods = {
    cash: 'Cash',
    mobile_banking: 'Mobile Banking',
    bank_transfer: 'Bank Transfer',
    credit: 'Credit'
  }
  return methods[method] || method
}

const getPaymentIcon = (method) => {
  const icons = { cash: '💵', mobile_banking: '📱', bank_transfer: '🏦', credit: '📝' }
  return icons[method] || '💳'
}

const getPaymentBadgeClass = (method) => {
  const classes = { cash: 'badge-success', mobile_banking: 'badge-info', bank_transfer: 'badge-purple', credit: 'badge-warning' }
  return classes[method] || 'badge-gray'
}

const getStatusIcon = (status) => {
  const icons = { completed: '✅', pending: '⏳', cancelled: '❌', paid: '✅' }
  return icons[status] || '📋'
}

const getStatusBadgeClass = (status) => {
  const classes = { completed: 'badge-success', pending: 'badge-warning', cancelled: 'badge-danger', paid: 'badge-success' }
  return classes[status] || 'badge-gray'
}

const fetchSales = async (page = 1) => {
  loading.value = true
  try {
    const params = { page, per_page: 15 }
    if (search.value) params.search = search.value
    if (paymentFilter.value) params.payment_method = paymentFilter.value
    if (statusFilter.value) params.status = statusFilter.value
    if (dateFilter.value) params.date = dateFilter.value
    
    const response = await salesApi.getAll(params)
    sales.value = response.data
    meta.value = response.meta || { current_page: 1, last_page: 1, per_page: 15, total: response.data.length }
  } catch (e) {
    toast.error('Failed to load sales')
  } finally {
    loading.value = false
  }
}

const fetchStats = async () => {
  try {
    const response = await dashboardApi.get()
    const data = response.data
    stats.value = {
      todayCount: data.today_sales || 0,
      todayRevenue: data.today_revenue || 0,
      monthRevenue: data.monthly_revenue || 0,
      avgSale: data.today_sales > 0 ? (data.today_revenue / data.today_sales) : 0
    }
  } catch (e) {}
}

const viewSale = async (sale) => {
  try {
    const response = await salesApi.get(sale.id)
    selectedSale.value = response.data
    showModal.value = true
  } catch (e) {
    toast.error('Failed to load sale details')
  }
}

const printReceipt = (sale) => {
  if (!sale) return
  const content = `
    <div style="font-family: monospace; width: 80mm; margin: 0 auto; padding: 10px;">
      <div style="text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px;">
        <h2 style="margin: 0;">🏪 IBMS Store</h2>
        <p style="margin: 5px 0; color: #666;">Your City</p>
        <p style="margin: 5px 0; color: #666;">Tel: +251-XXX-XXXXXX</p>
      </div>
      <div style="padding: 10px 0; border-bottom: 1px dashed #333;">
        <p><strong>Invoice:</strong> ${sale.invoice_number}</p>
        <p><strong>Date:</strong> ${formatDateTime(sale.created_at)}</p>
        <p><strong>Cashier:</strong> ${sale.user?.name || 'Admin'}</p>
      </div>
      <div style="padding: 10px 0; border-bottom: 2px dashed #333;">
        ${(sale.sale_items || []).map(item => `
          <div style="display: flex; justify-content: space-between; padding: 5px 0;">
            <span>${item.product?.name || 'Product'} x${item.quantity}</span>
            <span>ETB ${formatCurrency(item.total || (item.quantity * (item.unit_price || item.price)))}</span>
          </div>
        `).join('')}
      </div>
      <div style="padding: 10px 0;">
        <div style="display: flex; justify-content: space-between;"><span>Subtotal:</span><span>ETB ${formatCurrency(sale.subtotal)}</span></div>
        <div style="display: flex; justify-content: space-between;"><span>VAT (15%):</span><span>ETB ${formatCurrency(sale.tax)}</span></div>
        <div style="display: flex; justify-content: space-between; font-size: 1.2em; font-weight: bold; border-top: 2px solid #333; padding-top: 10px; margin-top: 10px;">
          <span>Total:</span><span>ETB ${formatCurrency(sale.total)}</span>
        </div>
      </div>
      <div style="text-align: center; padding-top: 10px; border-top: 2px dashed #333; color: #666;">
        <p>Thank you! / ስለገዙ እናመሰግናለን! 🙏</p>
      </div>
    </div>
  `
  const win = window.open('', '_blank')
  win.document.write(`<html><head><title>Receipt - ${sale.invoice_number}</title></head><body>${content}</body></html>`)
  win.document.close()
  win.print()
}

const exportSales = () => {
  const csv = [
    ['Invoice', 'Date', 'Subtotal', 'Tax', 'Total', 'Payment', 'Status'].join(','),
    ...sales.value.map(s => [
      s.invoice_number,
      formatDateTime(s.created_at),
      s.subtotal,
      s.tax,
      s.total,
      s.payment_method,
      s.payment_status || 'completed'
    ].join(','))
  ].join('\n')
  
  const blob = new Blob([csv], { type: 'text/csv' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `sales-${new Date().toISOString().split('T')[0]}.csv`
  a.click()
  toast.success('Sales exported successfully!')
}

onMounted(() => {
  fetchSales()
  fetchStats()
})
</script>

<style scoped>
/* Revolutionary Sales Styles */
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

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 6s ease-in-out infinite 2s;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

.particle-float {
  animation: float 4s ease-in-out infinite;
}

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

/* Enhanced Card Hover Effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

.group:hover .group-hover\:rotate-12 {
  transform: rotate(12deg);
}

/* Status Badge Animations */
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .5;
  }
}

/* Modal Backdrop Blur */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

/* Responsive Grid Adjustments */
@media (max-width: 768px) {
  .grid-cols-1.lg\:grid-cols-2.xl\:grid-cols-3 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}

@media (min-width: 1024px) {
  .grid-cols-1.lg\:grid-cols-2.xl\:grid-cols-3 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (min-width: 1280px) {
  .grid-cols-1.lg\:grid-cols-2.xl\:grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}
</style>
