<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Orders Header -->
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
              <!-- 3D Orders Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">📦</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart Orders / ትዕዛዞች
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📊</span>
                  <span>{{ orders.length }} Orders</span>
                  <span class="mx-2">•</span>
                  <span>💰</span>
                  <span>ETB {{ formatCurrency(stats.today_revenue) }} Today</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="exportOrders" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📤</span>
                <span class="relative">Export Orders</span>
              </button>
              
              <button @click="refreshData" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">🔄</span>
                <span class="relative">Refresh</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4 space-y-6">

      <!-- Revolutionary Order Flow Info -->
      <div class="group relative transform transition-all duration-500 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-2xl p-6 shadow-xl border-2 border-blue-100 group-hover:border-blue-300 transition-all">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
              <span class="text-2xl text-white">🔄</span>
            </div>
            <div>
              <h3 class="text-lg font-black text-blue-900 mb-2">Order Management Flow</h3>
              <p class="text-blue-800 font-medium leading-relaxed">
                <strong>Smart Order Processing:</strong> Orders flow from Pending → Processing → Completed with automatic sale generation and inventory updates. Advanced payment integration with Chapa gateway for seamless transactions.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Statistics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-yellow-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-4xl font-black text-yellow-600 mb-1">{{ stats.pending_orders }}</p>
                <p class="text-sm text-gray-600 font-bold">Pending Orders</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-yellow-600 font-medium">Awaiting Processing</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">⏳</div>
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
                <p class="text-4xl font-black text-blue-600 mb-1">{{ stats.processing_orders }}</p>
                <p class="text-sm text-gray-600 font-bold">Processing</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-blue-600 font-medium">In Progress</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-cyan-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">⚙️</div>
            </div>
          </div>
        </div>

        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-4xl font-black text-green-600 mb-1">{{ stats.completed_orders }}</p>
                <p class="text-sm text-gray-600 font-bold">Completed</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-green-600 font-medium">Successfully Done</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">✅</div>
            </div>
          </div>
        </div>

        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-emerald-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-3xl font-black text-emerald-600 mb-1">ETB {{ formatCurrency(stats.today_revenue) }}</p>
                <p class="text-sm text-gray-600 font-bold">Today's Revenue</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-emerald-600 font-medium">Daily Earnings</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-teal-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">💰</div>
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
                v-model="filters.search" 
                @input="debouncedFetch"
                type="text" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Search orders by number, customer, or email..."
              />
            </div>
            
            <!-- Status Filter -->
            <div class="relative group/status">
              <select 
                v-model="filters.status" 
                @change="fetchOrders"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/status:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            
            <!-- Date Range Filters -->
            <div class="relative group/date">
              <input 
                v-model="filters.start_date" 
                @change="fetchOrders"
                type="date" 
                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Start Date"
              />
            </div>
            
            <div class="relative group/date">
              <input 
                v-model="filters.end_date" 
                @change="fetchOrders"
                type="date" 
                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="End Date"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Orders Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="relative">
          <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
          <div class="relative w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center shadow-xl">
            <div class="loading-spinner w-10 h-10"></div>
          </div>
        </div>
      </div>

      <div v-else-if="orders.length === 0" class="relative group py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-3xl blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-6xl">📦</span>
            </div>
          </div>
          <h3 class="text-3xl font-black text-gray-700 mb-4">No Orders Found</h3>
          <p class="text-gray-500 text-lg mb-8">Orders will appear here when customers place them through the storefront</p>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <div 
          v-for="order in orders" 
          :key="order.id" 
          class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Order Card -->
          <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all">
            <!-- Enhanced Order Header -->
            <div class="relative bg-gradient-to-r from-green-50 to-emerald-50 p-4 border-b border-gray-100">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                    #{{ order.id }}
                  </div>
                  <div>
                    <h3 class="font-black text-gray-900 text-lg">{{ order.order_number }}</h3>
                    <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                  </div>
                </div>
                
                <!-- Enhanced Status Badge -->
                <div class="relative">
                  <span v-if="order.status === 'completed'" class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full text-sm font-bold shadow-lg">
                    ✅ Completed
                  </span>
                  <span v-else-if="order.status === 'processing'" class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-full text-sm font-bold shadow-lg animate-pulse">
                    ⚙️ Processing
                  </span>
                  <span v-else-if="order.status === 'pending'" class="px-3 py-1.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-full text-sm font-bold shadow-lg animate-pulse">
                    ⏳ Pending
                  </span>
                  <span v-else class="px-3 py-1.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full text-sm font-bold shadow-lg">
                    {{ order.status }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Enhanced Order Details -->
            <div class="p-4 space-y-4">
              <!-- Customer Info -->
              <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-cyan-200 rounded-full flex items-center justify-center">
                  <span class="text-xl">👤</span>
                </div>
                <div class="flex-1">
                  <p class="font-bold text-gray-900">{{ order.customer?.name || 'Guest Customer' }}</p>
                  <p class="text-sm text-gray-600">{{ order.customer?.email || 'No email' }}</p>
                </div>
              </div>
              
              <!-- Order Summary -->
              <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                  <p class="text-2xl font-black text-purple-600">{{ order.order_items?.length || 0 }}</p>
                  <p class="text-xs text-purple-700 font-bold">Items</p>
                </div>
                <div class="text-center p-3 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100">
                  <p class="text-lg font-black text-green-600">ETB {{ formatCurrency(order.total) }}</p>
                  <p class="text-xs text-green-700 font-bold">Total</p>
                </div>
              </div>
              
              <!-- Sale Invoice Info -->
              <div v-if="order.sale" class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                <div class="flex items-center gap-2">
                  <span class="text-lg">🧾</span>
                  <div>
                    <p class="text-sm font-bold text-green-800">Sale Invoice Generated</p>
                    <p class="text-xs text-green-600">{{ order.sale.invoice_number }}</p>
                  </div>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex gap-2 pt-2">
                <button @click="viewOrder(order)" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white rounded-xl font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                  <span>👁️</span>
                  <span>View Details</span>
                </button>
                
                <div v-if="order.status !== 'completed'" class="flex-1">
                  <select 
                    :value="order.status" 
                    @change="handleStatusChange(order, $event.target.value)"
                    class="w-full px-3 py-3 text-sm rounded-xl border-2 font-bold transition-all outline-none cursor-pointer"
                    :class="getStatusSelectClass(order.status)"
                  >
                    <option value="pending">⏳ Pending</option>
                    <option value="pending_payment">💳 Pending Payment</option>
                    <option value="processing">⚙️ Processing</option>
                    <option value="completed">✅ Complete Order</option>
                    <option value="cancelled">❌ Cancel</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Complete Order Modal -->
      <div v-if="completingOrder" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="relative group max-w-md w-full">
          <!-- 3D Background -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Modal -->
          <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-white">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                  </div>
                  <div>
                    <h3 class="text-xl font-black">Complete Order</h3>
                    <p class="text-green-100 text-sm">#{{ completingOrder.order_number }}</p>
                  </div>
                </div>
                <button @click="completingOrder = null" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
                  <span class="text-xl">✕</span>
                </button>
              </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6">
              <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-200 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span class="text-3xl">💰</span>
                </div>
                <p class="text-gray-600 leading-relaxed">
                  Complete this order and generate a sale invoice. Choose the payment method used by the customer.
                </p>
              </div>
              
              <!-- Payment Method Selection -->
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                  <span class="text-lg">💳</span>
                  <span>Payment Method</span>
                </label>
                <select 
                  v-model="paymentMethod" 
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm cursor-pointer"
                >
                  <option value="cash">💵 Cash Payment</option>
                  <option value="credit">💳 Credit Card</option>
                  <option value="bank_transfer">🏦 Bank Transfer</option>
                  <option value="mobile_money">📱 Mobile Money</option>
                  <option value="chapa">🌟 Chapa Payment Gateway</option>
                </select>
              </div>
              
              <!-- Chapa Payment Info -->
              <div v-if="paymentMethod === 'chapa'" class="bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                    <span class="text-xl text-white">💳</span>
                  </div>
                  <div class="flex-1">
                    <p class="font-bold text-blue-900 mb-2">Chapa Payment Gateway</p>
                    <p class="text-sm text-blue-700 leading-relaxed mb-3">
                      Customer will be redirected to secure Chapa checkout page to complete payment using their preferred method.
                    </p>
                    <p class="text-xs text-blue-600 font-medium">
                      Supports: CBE Birr, Telebirr, M-Birr, Awash Birr, Bank Cards, and more
                    </p>
                  </div>
                </div>
              </div>
              
              <!-- Order Total -->
              <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border-2 border-gray-200">
                <div class="text-center">
                  <p class="text-sm text-gray-600 mb-1">Order Total</p>
                  <p class="text-3xl font-black text-green-600">ETB {{ formatCurrency(completingOrder.total) }}</p>
                </div>
              </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 p-6 flex gap-4">
              <button 
                @click="completingOrder = null" 
                class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transition-all hover:scale-105 flex items-center justify-center gap-2"
              >
                <span>❌</span>
                <span>Cancel</span>
              </button>
              <button 
                @click="completeOrder" 
                :disabled="completing"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 flex items-center justify-center gap-2"
              >
                <span v-if="completing" class="loading-spinner w-5 h-5"></span>
                <span v-else>✅</span>
                <span>{{ completing ? 'Processing...' : 'Complete Order' }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Order Detail Modal -->
      <div v-if="selectedOrder" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="relative group max-w-4xl w-full max-h-[90vh] overflow-hidden">
          <!-- 3D Background -->
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Modal -->
          <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-6 text-white">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <span class="text-2xl">📋</span>
                  </div>
                  <div>
                    <h3 class="text-xl font-black">Order Details</h3>
                    <p class="text-blue-100 text-sm">#{{ selectedOrder.order_number }}</p>
                  </div>
                </div>
                <button @click="selectedOrder = null" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
                  <span class="text-xl">✕</span>
                </button>
              </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
              <!-- Customer & Order Info -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Info -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border-2 border-blue-100">
                  <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                      <span class="text-xl text-white">👤</span>
                    </div>
                    <h4 class="font-bold text-blue-900">Customer Information</h4>
                  </div>
                  <div class="space-y-2">
                    <p class="font-bold text-gray-900">{{ selectedOrder.customer?.name || 'Guest Customer' }}</p>
                    <p class="text-sm text-gray-600">📧 {{ selectedOrder.customer?.email || 'No email provided' }}</p>
                    <p class="text-sm text-gray-600">📞 {{ selectedOrder.customer?.phone || 'No phone provided' }}</p>
                  </div>
                </div>
                
                <!-- Order Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-100">
                  <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                      <span class="text-xl text-white">📦</span>
                    </div>
                    <h4 class="font-bold text-green-900">Order Information</h4>
                  </div>
                  <div class="space-y-2">
                    <p class="text-sm"><span class="font-bold">Status:</span> <span :class="getStatusTextClass(selectedOrder.status)" class="font-bold">{{ selectedOrder.status.toUpperCase() }}</span></p>
                    <p class="text-sm"><span class="font-bold">Date:</span> {{ formatDate(selectedOrder.created_at) }}</p>
                    <p v-if="selectedOrder.sale" class="text-sm text-green-600">
                      <span class="font-bold">Invoice:</span> {{ selectedOrder.sale.invoice_number }}
                    </p>
                  </div>
                </div>
              </div>
              
              <!-- Order Items -->
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 border-2 border-gray-200">
                <div class="flex items-center gap-3 mb-4">
                  <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <span class="text-xl text-white">🛍️</span>
                  </div>
                  <h4 class="font-bold text-gray-900">Order Items</h4>
                </div>
                <div class="space-y-3">
                  <div v-for="item in selectedOrder.order_items" :key="item.id" class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                    <div class="flex-1">
                      <p class="font-bold text-gray-900">{{ item.product?.name || 'Unknown Product' }}</p>
                      <p class="text-sm text-gray-600">{{ item.quantity }} × ETB {{ formatCurrency(item.unit_price) }}</p>
                    </div>
                    <p class="font-bold text-green-600 text-lg">ETB {{ formatCurrency(item.total) }}</p>
                  </div>
                </div>
              </div>
              
              <!-- Order Summary -->
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                <h4 class="font-bold text-green-900 mb-4 flex items-center gap-2">
                  <span class="text-xl">💰</span>
                  <span>Order Summary</span>
                </h4>
                <div class="space-y-3">
                  <div class="flex justify-between text-gray-700">
                    <span>Subtotal</span>
                    <span>ETB {{ formatCurrency(selectedOrder.subtotal) }}</span>
                  </div>
                  <div class="flex justify-between text-gray-700">
                    <span>Tax</span>
                    <span>ETB {{ formatCurrency(selectedOrder.tax) }}</span>
                  </div>
                  <div class="flex justify-between text-gray-700">
                    <span>Discount</span>
                    <span>-ETB {{ formatCurrency(selectedOrder.discount) }}</span>
                  </div>
                  <div class="flex justify-between text-xl font-black text-green-600 border-t border-green-300 pt-3">
                    <span>Total</span>
                    <span>ETB {{ formatCurrency(selectedOrder.total) }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Notes -->
              <div v-if="selectedOrder.notes" class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-4 border-2 border-yellow-200">
                <h4 class="font-bold text-yellow-900 mb-2 flex items-center gap-2">
                  <span class="text-xl">📝</span>
                  <span>Order Notes</span>
                </h4>
                <p class="text-gray-700">{{ selectedOrder.notes }}</p>
              </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 p-6">
              <button 
                @click="selectedOrder = null" 
                class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2"
              >
                <span>✅</span>
                <span>Close Details</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { ordersApi, paymentsApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '@/composables/useTranslation'

const toast = useToastStore()
const { t } = useTranslation()

const orders = ref([])
const stats = ref({
  pending_orders: 0,
  processing_orders: 0,
  completed_orders: 0,
  today_revenue: 0
})
const loading = ref(true)
const selectedOrder = ref(null)
const completingOrder = ref(null)
const paymentMethod = ref('cash')
const completing = ref(false)
const filters = ref({
  search: '',
  status: 'all',
  start_date: '',
  end_date: ''
})

let debounceTimer = null
const debouncedFetch = () => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchOrders, 300)
}

const formatCurrency = (amount) => Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2 })
const formatDate = (date) => date ? new Date(date).toLocaleDateString('en-ET', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''

const getStatusTextClass = (status) => {
  const classes = {
    pending: 'text-yellow-600',
    pending_payment: 'text-orange-600',
    processing: 'text-blue-600',
    completed: 'text-green-600',
    cancelled: 'text-red-600'
  }
  return classes[status] || 'text-gray-600'
}

const getStatusSelectClass = (status) => {
  const classes = {
    pending: 'bg-yellow-50 border-yellow-300 text-yellow-700 hover:border-yellow-400',
    pending_payment: 'bg-orange-50 border-orange-300 text-orange-700 hover:border-orange-400',
    processing: 'bg-blue-50 border-blue-300 text-blue-700 hover:border-blue-400',
    completed: 'bg-green-50 border-green-300 text-green-700 hover:border-green-400',
    cancelled: 'bg-red-50 border-red-300 text-red-700 hover:border-red-400'
  }
  return classes[status] || 'bg-gray-50 border-gray-300'
}

const fetchOrders = async () => {
  loading.value = true
  try {
    const params = { ...filters.value }
    if (params.status === 'all') delete params.status
    if (!params.search) delete params.search
    if (!params.start_date) delete params.start_date
    if (!params.end_date) delete params.end_date
    
    const response = await ordersApi.getAll(params)
    orders.value = response.data || []
  } catch (e) {
    orders.value = []
  } finally {
    loading.value = false
  }
}

const fetchStats = async () => {
  try {
    const response = await ordersApi.statistics()
    stats.value = response.data || stats.value
  } catch (e) {}
}

const handleStatusChange = (order, newStatus) => {
  if (newStatus === 'completed') {
    // Show payment method modal
    completingOrder.value = order
    paymentMethod.value = 'cash'
  } else {
    updateStatus(order.id, newStatus)
  }
}

const completeOrder = async () => {
  if (!completingOrder.value) return
  
  completing.value = true
  try {
    // If Chapa payment selected, initialize payment first
    if (paymentMethod.value === 'chapa') {
      const paymentResponse = await paymentsApi.initializePayment(completingOrder.value.id)
      
      if (paymentResponse.success && paymentResponse.data.checkout_url) {
        // Show success message
        toast.success(t('orders.chapaRedirecting'))
        
        // Store order ID for verification after payment
        localStorage.setItem('pending_payment_order_id', completingOrder.value.id)
        
        // Redirect to Chapa checkout
        window.location.href = paymentResponse.data.checkout_url
        return
      } else {
        throw new Error(paymentResponse.message || t('orders.failedToInitializePayment'))
      }
    }
    
    // For other payment methods, complete order directly
    await ordersApi.updateStatus(completingOrder.value.id, 'completed', paymentMethod.value)
    toast.success(t('orders.orderCompletedSuccess'))
    completingOrder.value = null
    await Promise.all([fetchOrders(), fetchStats()])
  } catch (e) {
    console.error('Error completing order:', e)
    toast.error(e.message || t('orders.failedToCompleteOrder'))
  } finally {
    completing.value = false
  }
}

const updateStatus = async (orderId, status) => {
  try {
    await ordersApi.updateStatus(orderId, status)
    await Promise.all([fetchOrders(), fetchStats()])
  } catch (e) {
    alert(e.message || t('orders.failedToUpdateStatus'))
    fetchOrders()
  }
}

const viewOrder = (order) => {
  selectedOrder.value = order
}

const exportOrders = () => {
  // Export functionality - could export to CSV/Excel
  const csvContent = "data:text/csv;charset=utf-8," 
    + "Order Number,Customer,Items,Total,Status,Date\n"
    + orders.value.map(order => 
        `${order.order_number},${order.customer?.name || 'Guest'},${order.order_items?.length || 0},${order.total},${order.status},${formatDate(order.created_at)}`
      ).join("\n")
  
  const encodedUri = encodeURI(csvContent)
  const link = document.createElement("a")
  link.setAttribute("href", encodedUri)
  link.setAttribute("download", `orders_${new Date().toISOString().split('T')[0]}.csv`)
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
  
  toast.success('📤 Orders exported successfully!')
}

const refreshData = async () => {
  await Promise.all([fetchOrders(), fetchStats()])
  toast.success('🔄 Data refreshed successfully!')
}

onMounted(() => {
  fetchOrders()
  fetchStats()
})
</script>

<style scoped>
/* Revolutionary Orders Styles */
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
