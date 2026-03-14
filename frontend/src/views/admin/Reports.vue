<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Reports Header -->
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
              <!-- 3D Reports Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">📊</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Advanced Analytics & Reports / የላቀ ትንታኔ እና ሪፖርቶች
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📈</span>
                  <span>Real-time Business Intelligence</span>
                  <span class="mx-2">•</span>
                  <span>💰</span>
                  <span>ETB {{ formatCurrency(profit.total_revenue) }} Revenue</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="printReport" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">🖨️</span>
                <span class="relative">Print Report</span>
              </button>
              
              <button @click="exportReport" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📤</span>
                <span class="relative">Export Data</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4 space-y-6">
      <!-- Revolutionary Date Filter Dashboard -->
      <div class="group relative transform transition-all duration-500 hover:scale-[1.02]">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-xl border-2 border-white/50 group-hover:border-blue-300 transition-all">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-white">📅</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900">Date Range & Quick Filters</h3>
          </div>
          
          <div class="flex flex-wrap gap-4 items-end">
            <div class="group/input relative">
              <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('reports.startDate') }}</label>
              <input v-model="startDate" type="date" class="w-48 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all font-medium group-hover/input:border-gray-300" />
            </div>
            
            <div class="group/input relative">
              <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('reports.endDate') }}</label>
              <input v-model="endDate" type="date" class="w-48 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all font-medium group-hover/input:border-gray-300" />
            </div>
            
            <div class="flex gap-2">
              <button @click="setToday" class="group/btn relative px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105 overflow-hidden">
                <span class="relative">Today</span>
              </button>
              <button @click="setThisWeek" class="group/btn relative px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105 overflow-hidden">
                <span class="relative">This Week</span>
              </button>
              <button @click="setThisMonth" class="group/btn relative px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105 overflow-hidden">
                <span class="relative">This Month</span>
              </button>
            </div>
            
            <button @click="fetchReports" class="group/btn relative px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
              <span class="relative flex items-center gap-2">
                <span>📊</span>
                <span>Generate Report</span>
              </span>
            </button>
          </div>
        </div>
      </div>

      <LoadingSpinner v-if="loading" />

      <div v-else class="space-y-6">
        <!-- Revolutionary 3D Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Total Revenue Card -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border-2 border-blue-200 group-hover:border-blue-400 transition-all shadow-xl">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">💰</span>
                </div>
                <div class="text-right">
                  <div class="text-xs text-blue-600 font-medium uppercase tracking-wide">Total Revenue</div>
                  <div class="text-2xl font-black text-blue-700">ETB {{ formatCurrency(profit.total_revenue) }}</div>
                </div>
              </div>
              <div class="w-full bg-blue-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: 85%"></div>
              </div>
            </div>
          </div>

          <!-- Total Cost Card -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-2xl border-2 border-red-200 group-hover:border-red-400 transition-all shadow-xl">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">📉</span>
                </div>
                <div class="text-right">
                  <div class="text-xs text-red-600 font-medium uppercase tracking-wide">Total Cost</div>
                  <div class="text-2xl font-black text-red-700">ETB {{ formatCurrency(profit.total_cost) }}</div>
                </div>
              </div>
              <div class="w-full bg-red-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-red-500 to-red-600 h-2 rounded-full" style="width: 65%"></div>
              </div>
            </div>
          </div>

          <!-- Gross Profit Card -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border-2 border-green-200 group-hover:border-green-400 transition-all shadow-xl">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">📈</span>
                </div>
                <div class="text-right">
                  <div class="text-xs text-green-600 font-medium uppercase tracking-wide">Gross Profit</div>
                  <div class="text-2xl font-black text-green-700">ETB {{ formatCurrency(profit.gross_profit) }}</div>
                </div>
              </div>
              <div class="w-full bg-green-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: 90%"></div>
              </div>
            </div>
          </div>

          <!-- Profit Margin Card -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl border-2 border-orange-200 group-hover:border-orange-400 transition-all shadow-xl">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">📊</span>
                </div>
                <div class="text-right">
                  <div class="text-xs text-orange-600 font-medium uppercase tracking-wide">Profit Margin</div>
                  <div class="text-2xl font-black text-orange-700">{{ profitMargin }}%</div>
                </div>
              </div>
              <div class="w-full bg-orange-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-2 rounded-full" :style="`width: ${Math.min(profitMargin, 100)}%`"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revolutionary Analytics Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Sales Summary -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-xl border-2 border-white/50 group-hover:border-green-300 transition-all">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">📈</span>
                </div>
                <h3 class="text-xl font-black text-gray-900">Sales Summary / የሽያጭ ማጠቃለያ</h3>
              </div>
              
              <div class="space-y-4">
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 group-hover/item:border-green-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">🛒</span>
                    </div>
                    <span class="text-gray-700 font-medium">Total Sales Count</span>
                  </div>
                  <span class="font-black text-green-700 text-lg">{{ salesSummary.total_count || 0 }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 group-hover/item:border-blue-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">💵</span>
                    </div>
                    <span class="text-gray-700 font-medium">Cash Sales</span>
                  </div>
                  <span class="font-black text-blue-700 text-lg">ETB {{ formatCurrency(salesSummary.cash_total) }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 group-hover/item:border-purple-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">💳</span>
                    </div>
                    <span class="text-gray-700 font-medium">Credit Sales</span>
                  </div>
                  <span class="font-black text-purple-700 text-lg">ETB {{ formatCurrency(salesSummary.credit_total) }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 group-hover/item:border-orange-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">📊</span>
                    </div>
                    <span class="text-gray-700 font-medium">Average Sale Value</span>
                  </div>
                  <span class="font-black text-orange-700 text-lg">ETB {{ formatCurrency(salesSummary.average_sale) }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Inventory Status -->
          <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl blur-lg opacity-0 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-xl border-2 border-white/50 group-hover:border-purple-300 transition-all">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl text-white">📦</span>
                </div>
                <h3 class="text-xl font-black text-gray-900">Inventory Status / የእቃ ሁኔታ</h3>
              </div>
              
              <div class="space-y-4">
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 group-hover/item:border-blue-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">📋</span>
                    </div>
                    <span class="text-gray-700 font-medium">Total Products</span>
                  </div>
                  <span class="font-black text-blue-700 text-lg">{{ inventoryStatus.total_products || 0 }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 group-hover/item:border-red-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">⚠️</span>
                    </div>
                    <span class="text-gray-700 font-medium">Low Stock Items</span>
                  </div>
                  <span class="font-black text-red-700 text-lg">{{ inventoryStatus.low_stock || 0 }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 group-hover/item:border-gray-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-500 to-gray-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">❌</span>
                    </div>
                    <span class="text-gray-700 font-medium">Out of Stock</span>
                  </div>
                  <span class="font-black text-gray-700 text-lg">{{ inventoryStatus.out_of_stock || 0 }}</span>
                </div>
                
                <div class="group/item flex justify-between items-center p-3 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 group-hover/item:border-green-300 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">💰</span>
                    </div>
                    <span class="text-gray-700 font-medium">Inventory Value</span>
                  </div>
                  <span class="font-black text-green-700 text-lg">ETB {{ formatCurrency(inventoryStatus.total_value) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revolutionary Top Products Table -->
        <div class="group relative transform transition-all duration-300 hover:scale-[1.01]">
          <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-10 transition-opacity"></div>
          <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-xl border-2 border-white/50 group-hover:border-yellow-300 transition-all">
            <div class="flex items-center gap-3 mb-6">
              <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl text-white">🏆</span>
              </div>
              <h3 class="text-xl font-black text-gray-900">Top Selling Products / ምርጥ የሚሸጡ ምርቶች</h3>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="text-left border-b-2 border-gray-200">
                    <th class="pb-4 px-4 text-sm font-black text-gray-600 uppercase tracking-wide">#</th>
                    <th class="pb-4 px-4 text-sm font-black text-gray-600 uppercase tracking-wide">Product Name</th>
                    <th class="pb-4 px-4 text-sm font-black text-gray-600 uppercase tracking-wide">Quantity Sold</th>
                    <th class="pb-4 px-4 text-sm font-black text-gray-600 uppercase tracking-wide">Revenue (ETB)</th>
                    <th class="pb-4 px-4 text-sm font-black text-gray-600 uppercase tracking-wide">Profit (ETB)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(product, index) in topProducts" :key="product.id" class="group/row border-b border-gray-100 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 transition-all">
                    <td class="py-4 px-4">
                      <div class="w-8 h-8 rounded-full flex items-center justify-center font-black text-white" :class="index === 0 ? 'bg-gradient-to-br from-yellow-500 to-yellow-600' : index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-500' : index === 2 ? 'bg-gradient-to-br from-orange-600 to-orange-700' : 'bg-gradient-to-br from-blue-500 to-blue-600'">
                        {{ index + 1 }}
                      </div>
                    </td>
                    <td class="py-4 px-4">
                      <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                          <span class="text-white text-sm">📦</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ product.name }}</span>
                      </div>
                    </td>
                    <td class="py-4 px-4">
                      <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-bold">{{ product.total_quantity }}</span>
                    </td>
                    <td class="py-4 px-4">
                      <span class="font-black text-green-700">{{ formatCurrency(product.total_revenue) }}</span>
                    </td>
                    <td class="py-4 px-4">
                      <span class="font-black text-emerald-700">{{ formatCurrency(product.total_profit || 0) }}</span>
                    </td>
                  </tr>
                  <tr v-if="topProducts.length === 0">
                    <td colspan="5" class="py-12 text-center">
                      <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                          <span class="text-3xl text-gray-400">📊</span>
                        </div>
                        <p class="text-gray-500 font-medium">No sales data available for the selected period</p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { reportsApi, dashboardApi } from '../../services/api'
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import { useTranslation } from '../../composables/useTranslation'
import { useToastStore } from '../../stores/toast'

const { t } = useTranslation()
const toast = useToastStore()

const loading = ref(false)
const startDate = ref('')
const endDate = ref('')
const profit = ref({ total_revenue: 0, total_cost: 0, gross_profit: 0 })
const topProducts = ref([])
const salesSummary = ref({ total_count: 0, cash_total: 0, credit_total: 0, average_sale: 0 })
const inventoryStatus = ref({ total_products: 0, low_stock: 0, out_of_stock: 0, total_value: 0 })

const profitMargin = computed(() => {
  if (!profit.value.total_revenue) return 0
  return ((profit.value.gross_profit / profit.value.total_revenue) * 100).toFixed(1)
})

const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const setToday = () => {
  const today = new Date().toISOString().split('T')[0]
  startDate.value = today
  endDate.value = today
  fetchReports()
}

const setThisWeek = () => {
  const today = new Date()
  const firstDay = new Date(today.setDate(today.getDate() - today.getDay()))
  startDate.value = firstDay.toISOString().split('T')[0]
  endDate.value = new Date().toISOString().split('T')[0]
  fetchReports()
}

const setThisMonth = () => {
  const today = new Date()
  startDate.value = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0]
  endDate.value = new Date().toISOString().split('T')[0]
  fetchReports()
}

const fetchReports = async () => {
  loading.value = true
  const params = {}
  if (startDate.value) params.start_date = startDate.value
  if (endDate.value) params.end_date = endDate.value
  
  try {
    const [profitRes, topRes, dashRes] = await Promise.all([
      reportsApi.profit(params),
      reportsApi.topProducts(params),
      dashboardApi.get()
    ])
    profit.value = profitRes.data
    topProducts.value = topRes.data
    inventoryStatus.value = {
      total_products: dashRes.data.total_products,
      low_stock: dashRes.data.low_stock_count,
      out_of_stock: 0,
      total_value: dashRes.data.inventory_value || 0
    }
  } catch (e) {
    console.error('Failed to fetch reports', e)
    toast.error('Failed to load reports data')
  } finally {
    loading.value = false
  }
}

const printReport = () => {
  window.print()
}

const exportReport = () => {
  const reportData = {
    period: `${startDate.value} to ${endDate.value}`,
    summary: {
      totalRevenue: profit.value.total_revenue,
      totalCost: profit.value.total_cost,
      grossProfit: profit.value.gross_profit,
      profitMargin: profitMargin.value
    },
    sales: salesSummary.value,
    inventory: inventoryStatus.value,
    topProducts: topProducts.value
  }
  
  const csvContent = [
    ['Report Period', reportData.period],
    [''],
    ['Financial Summary'],
    ['Total Revenue (ETB)', formatCurrency(reportData.summary.totalRevenue)],
    ['Total Cost (ETB)', formatCurrency(reportData.summary.totalCost)],
    ['Gross Profit (ETB)', formatCurrency(reportData.summary.grossProfit)],
    ['Profit Margin (%)', reportData.summary.profitMargin],
    [''],
    ['Top Products'],
    ['Rank', 'Product Name', 'Quantity Sold', 'Revenue (ETB)', 'Profit (ETB)'],
    ...topProducts.value.map((product, index) => [
      index + 1,
      product.name,
      product.total_quantity,
      formatCurrency(product.total_revenue),
      formatCurrency(product.total_profit || 0)
    ])
  ].map(row => row.join(',')).join('\n')
  
  const blob = new Blob([csvContent], { type: 'text/csv' })
  const url = window.URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `business-report-${startDate.value}-to-${endDate.value}.csv`
  a.click()
  window.URL.revokeObjectURL(url)
  toast.success('Report exported successfully!')
}

onMounted(() => {
  setThisMonth()
})
</script>

<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(3deg); }
}

@keyframes float-delayed {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-15px) rotate(-2deg); }
}

@keyframes particle-float {
  0%, 100% { transform: translateY(0px) translateX(0px) scale(1); opacity: 0.6; }
  25% { transform: translateY(-10px) translateX(5px) scale(1.1); opacity: 0.8; }
  50% { transform: translateY(-20px) translateX(-5px) scale(0.9); opacity: 1; }
  75% { transform: translateY(-15px) translateX(8px) scale(1.05); opacity: 0.7; }
}

@keyframes gradient-x {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 8s ease-in-out infinite;
}

.particle-float {
  animation: particle-float 4s ease-in-out infinite;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

@media print {
  .no-print {
    display: none !important;
  }
}
</style>
