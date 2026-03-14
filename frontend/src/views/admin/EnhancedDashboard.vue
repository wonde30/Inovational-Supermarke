<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 lg:p-6">
    <div class="max-w-[1600px] mx-auto">
      <!-- Revolutionary 3D Header with Glassmorphism -->
      <div class="mb-6 relative group">
        <!-- 3D Background Layer -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-[1.02] shadow-2xl"></div>
        
        <!-- Main Content Layer -->
        <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-6 lg:p-8 text-white shadow-2xl overflow-hidden border border-white/20">
          <!-- Animated Mesh Background -->
          <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full blur-3xl animate-pulse"></div>
          </div>
          
          <!-- Floating Particles -->
          <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle-float absolute w-2 h-2 bg-white/60 rounded-full" style="top: 20%; left: 10%; animation-delay: 0s"></div>
            <div class="particle-float absolute w-3 h-3 bg-yellow-300/40 rounded-full" style="top: 60%; left: 80%; animation-delay: 1s"></div>
            <div class="particle-float absolute w-2 h-2 bg-pink-300/50 rounded-full" style="top: 40%; left: 60%; animation-delay: 2s"></div>
            <div class="particle-float absolute w-4 h-4 bg-cyan-300/30 rounded-full" style="top: 70%; left: 30%; animation-delay: 1.5s"></div>
          </div>
          
          <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex-1">
              <div class="flex items-center gap-4 mb-3">
                <!-- 3D Avatar with Glow -->
                <div class="relative group/avatar">
                  <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/avatar:opacity-100 transition-opacity animate-pulse"></div>
                  <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/avatar:scale-110 group-hover/avatar:rotate-6 transition-all">
                    <span class="text-4xl animate-wave">👋</span>
                  </div>
                </div>
                
                <div>
                  <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                    {{ t('common.welcome') }}, {{ userName }}!
                  </h1>
                  <div class="flex items-center gap-3 text-sm">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20">
                      <div class="w-2 h-2 bg-green-400 rounded-full animate-ping"></div>
                      <span class="text-green-100 font-semibold">{{ currentDate }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20">
                      <span class="text-yellow-300">⏰</span>
                      <span class="text-green-100 font-semibold font-mono">{{ currentTime }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <p class="text-green-50 text-base lg:text-lg font-medium">🚀 {{ t('dashboard.subtitle') || 'Your business command center' }}</p>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="openAIAssistant" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative animate-bounce-slow">🤖</span>
                <span class="relative">AI Assistant</span>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></div>
              </button>
              
              <router-link to="/admin/pos" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">🛒</span>
                <span class="relative">New Sale</span>
                <svg class="w-5 h-5 relative group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary 3D Stats Grid with Glassmorphism -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <!-- Today's Sales - 3D Card -->
        <div class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border-2 border-transparent group-hover:border-green-500 cursor-pointer overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 animate-gradient-xy"></div>
            </div>
            
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                  <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-3xl">💰</span>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                  <span class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-black rounded-full shadow-lg animate-pulse">+12%</span>
                  <div class="flex items-center gap-1 text-xs text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span class="font-bold">Trending</span>
                  </div>
                </div>
              </div>
              
              <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">{{ t('dashboard.todaySales') }}</p>
              <p class="text-4xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-1">
                ETB {{ formatCurrency(stats.todaySales) }}
              </p>
              <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="font-medium">{{ stats.todayTransactions }} transactions</span>
              </div>
              
              <!-- Progress Bar -->
              <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-green-500 to-emerald-600 rounded-full animate-progress" style="width: 75%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Orders - 3D Card with Pulse -->
        <div class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2">
          <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
          
          <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border-2 border-transparent group-hover:border-orange-500 cursor-pointer overflow-hidden">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity">
              <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 animate-gradient-xy"></div>
            </div>
            
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity animate-pulse"></div>
                  <div class="relative w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-3xl animate-bounce-slow">📦</span>
                  </div>
                </div>
                <span v-if="stats.pendingOrders > 0" class="px-3 py-1.5 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-black rounded-full shadow-lg animate-bounce">
                  {{ stats.pendingOrders }}
                </span>
              </div>
              
              <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">Pending Orders</p>
              <p class="text-4xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-1">
                {{ stats.pendingOrders }}
              </p>
              <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-orange-500 rounded-full animate-ping"></span>
                <span class="font-medium">Awaiting processing</span>
              </div>
              
              <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-orange-500 to-red-500 rounded-full animate-progress" style="width: 45%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Stock Alerts - 3D Card with Warning -->
        <div class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2">
          <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-pink-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
          
          <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border-2 border-transparent group-hover:border-red-500 cursor-pointer overflow-hidden">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity">
              <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-pink-500 animate-gradient-xy"></div>
            </div>
            
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity animate-pulse"></div>
                  <div class="relative w-14 h-14 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-3xl animate-shake">⚠️</span>
                  </div>
                </div>
                <span v-if="stats.stockAlerts > 0" class="px-3 py-1.5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-black rounded-full shadow-lg animate-bounce">!</span>
              </div>
              
              <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">{{ t('dashboard.stockAlerts') }}</p>
              <p class="text-4xl font-black bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-1">
                {{ stats.stockAlerts }}
              </p>
              <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                <span class="font-medium">Items need restock</span>
              </div>
              
              <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-red-500 to-pink-500 rounded-full animate-progress" style="width: 15%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Products - 3D Card -->
        <div class="group relative transform transition-all duration-500 hover:scale-105 hover:-translate-y-2">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
          
          <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border-2 border-transparent group-hover:border-blue-500 cursor-pointer overflow-hidden">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 animate-gradient-xy"></div>
            </div>
            
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                  <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-3xl">📊</span>
                  </div>
                </div>
                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-black rounded-full shadow-lg">Active</span>
              </div>
              
              <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">{{ t('dashboard.totalProducts') }}</p>
              <p class="text-4xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-1">
                {{ stats.totalProducts }}
              </p>
              <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span class="font-medium">In inventory</span>
              </div>
              
              <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full animate-progress" style="width: 90%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Sales Chart & AI Insights -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Revolutionary 3D Sales Chart -->
          <div class="group relative transform transition-all duration-500 hover:scale-[1.01]">
            <!-- 3D Shadow Layer -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
            
            <!-- Main Card -->
            <div class="relative bg-white/95 backdrop-blur-xl rounded-3xl p-6 lg:p-8 shadow-2xl border-2 border-gray-100 group-hover:border-green-300 transition-all overflow-hidden">
              <!-- Animated Background Grid -->
              <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(34, 197, 94, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(34, 197, 94, 0.3) 1px, transparent 1px); background-size: 50px 50px;"></div>
              </div>
              
              <div class="relative">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-8 gap-4">
                  <div>
                    <div class="flex items-center gap-3 mb-2">
                      <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                          <span class="text-2xl">📈</span>
                        </div>
                      </div>
                      <div>
                        <h2 class="text-2xl font-black text-gray-900">Sales Trend</h2>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                          <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                          <span>Last 7 days performance</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Period Selector with 3D Effect -->
                  <div class="flex gap-2 bg-gray-100 p-1.5 rounded-xl shadow-inner">
                    <button @click="chartPeriod = '7d'" :class="chartPeriod === '7d' ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg scale-105' : 'bg-transparent text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all transform">
                      7D
                    </button>
                    <button @click="chartPeriod = '30d'" :class="chartPeriod === '30d' ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg scale-105' : 'bg-transparent text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all transform">
                      30D
                    </button>
                    <button @click="chartPeriod = '90d'" :class="chartPeriod === '90d' ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg scale-105' : 'bg-transparent text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all transform">
                      90D
                    </button>
                  </div>
                </div>
                
                <!-- 3D Interactive Bar Chart -->
                <div class="relative h-80 flex items-end justify-between gap-3 px-4">
                  <!-- Y-axis Labels -->
                  <div class="absolute left-0 top-0 bottom-0 flex flex-col justify-between text-xs text-gray-400 font-semibold pr-2">
                    <span>{{ formatCurrency(maxSales) }}</span>
                    <span>{{ formatCurrency(maxSales * 0.75) }}</span>
                    <span>{{ formatCurrency(maxSales * 0.5) }}</span>
                    <span>{{ formatCurrency(maxSales * 0.25) }}</span>
                    <span>0</span>
                  </div>
                  
                  <!-- Horizontal Grid Lines -->
                  <div class="absolute inset-0 flex flex-col justify-between pointer-events-none ml-12">
                    <div class="border-t border-dashed border-gray-200"></div>
                    <div class="border-t border-dashed border-gray-200"></div>
                    <div class="border-t border-dashed border-gray-200"></div>
                    <div class="border-t border-dashed border-gray-200"></div>
                    <div class="border-t border-gray-300"></div>
                  </div>
                  
                  <!-- 3D Bars -->
                  <div class="flex-1 flex items-end justify-between gap-2 ml-12">
                    <div v-for="(day, index) in salesData" :key="index" class="flex-1 flex flex-col items-center gap-3 group/bar">
                      <!-- 3D Bar with Gradient -->
                      <div class="relative w-full transform-3d transition-all duration-500 hover:scale-110" :style="{ height: (day.amount / maxSales * 100) + '%' }">
                        <!-- Shadow Layer -->
                        <div class="absolute inset-0 bg-gradient-to-t from-green-600 to-emerald-500 rounded-t-xl blur-sm opacity-50"></div>
                        
                        <!-- Main Bar -->
                        <div class="relative w-full h-full bg-gradient-to-t from-green-600 via-emerald-500 to-green-400 rounded-t-xl hover:from-green-500 hover:via-emerald-400 hover:to-green-300 transition-all cursor-pointer shadow-xl border-t-4 border-white/50 overflow-hidden">
                          <!-- Shine Effect -->
                          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent translate-x-[-100%] group-hover/bar:translate-x-[100%] transition-transform duration-1000"></div>
                          
                          <!-- Value Tooltip -->
                          <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-3 py-2 rounded-lg text-xs font-bold opacity-0 group-hover/bar:opacity-100 transition-opacity whitespace-nowrap shadow-xl z-10">
                            <div class="text-center">
                              <div class="text-green-300">ETB {{ formatCurrency(day.amount) }}</div>
                              <div class="text-gray-400 text-[10px]">{{ day.transactions }} sales</div>
                            </div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                          </div>
                          
                          <!-- Animated Particles -->
                          <div class="absolute inset-0 overflow-hidden opacity-0 group-hover/bar:opacity-100 transition-opacity">
                            <div class="particle-rise absolute w-1 h-1 bg-white rounded-full" style="left: 20%; animation-delay: 0s"></div>
                            <div class="particle-rise absolute w-1 h-1 bg-white rounded-full" style="left: 50%; animation-delay: 0.2s"></div>
                            <div class="particle-rise absolute w-1 h-1 bg-white rounded-full" style="left: 80%; animation-delay: 0.4s"></div>
                          </div>
                        </div>
                        
                        <!-- 3D Side Panel -->
                        <div class="absolute -right-1 top-0 w-1 h-full bg-gradient-to-b from-green-700 to-green-800 transform skew-y-[-45deg] origin-top"></div>
                      </div>
                      
                      <!-- Day Label with Icon -->
                      <div class="text-center">
                        <span class="text-xs font-bold text-gray-700 group-hover/bar:text-green-600 transition-colors">{{ day.label }}</span>
                        <div v-if="index === salesData.length - 1" class="mt-1">
                          <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-black rounded-full">Today</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Chart Summary Stats -->
                <div class="grid grid-cols-3 gap-4 mt-8 pt-6 border-t border-gray-200">
                  <div class="text-center">
                    <p class="text-2xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                      ETB {{ formatCurrency(salesData.reduce((sum, d) => sum + d.amount, 0)) }}
                    </p>
                    <p class="text-xs text-gray-500 font-semibold mt-1">Total Revenue</p>
                  </div>
                  <div class="text-center">
                    <p class="text-2xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                      ETB {{ formatCurrency(salesData.reduce((sum, d) => sum + d.amount, 0) / salesData.length) }}
                    </p>
                    <p class="text-xs text-gray-500 font-semibold mt-1">Daily Average</p>
                  </div>
                  <div class="text-center">
                    <p class="text-2xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                      +{{ Math.round(((salesData[salesData.length - 1].amount - salesData[0].amount) / salesData[0].amount) * 100) }}%
                    </p>
                    <p class="text-xs text-gray-500 font-semibold mt-1">Growth Rate</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- AI Recommendations with Holographic Effect -->
          <div class="group relative transform transition-all duration-500 hover:scale-[1.01]">
            <!-- Holographic Glow -->
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 rounded-3xl blur-2xl opacity-50 group-hover:opacity-75 transition-opacity animate-gradient-x"></div>
            
            <div class="relative bg-gradient-to-br from-purple-600 via-pink-600 to-red-600 rounded-3xl p-6 lg:p-8 text-white shadow-2xl overflow-hidden border-2 border-white/20">
              <!-- Animated Mesh Background -->
              <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-300 rounded-full blur-3xl animate-float-delayed"></div>
              </div>
              
              <!-- Holographic Scan Line -->
              <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="scan-line absolute w-full h-1 bg-gradient-to-r from-transparent via-white to-transparent opacity-50"></div>
              </div>
              
              <div class="relative">
                <div class="flex items-center gap-4 mb-6">
                  <div class="relative">
                    <div class="absolute inset-0 bg-white rounded-2xl blur-xl opacity-50 animate-pulse"></div>
                    <div class="relative w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border-2 border-white/30 shadow-2xl">
                      <span class="text-4xl animate-bounce-slow">🤖</span>
                    </div>
                  </div>
                  <div class="flex-1">
                    <h3 class="text-2xl font-black mb-1">AI Recommendations</h3>
                    <p class="text-sm text-purple-100 flex items-center gap-2">
                      <span class="w-2 h-2 bg-green-400 rounded-full animate-ping"></span>
                      <span>Smart insights powered by machine learning</span>
                    </p>
                  </div>
                  <div class="hidden lg:block px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 text-sm font-bold">
                    Live
                  </div>
                </div>
                
                <div class="space-y-4">
                  <div class="group/card relative bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/20 transition-all cursor-pointer transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative flex items-start gap-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0 group-hover/card:scale-110 group-hover/card:rotate-12 transition-all">
                        <span class="text-2xl">💡</span>
                      </div>
                      <div class="flex-1">
                        <p class="font-bold text-lg mb-2">Stock Optimization Alert</p>
                        <p class="text-sm text-purple-100 mb-3">AI predicts 30% demand increase for "Teff" this week based on historical patterns</p>
                        <div class="flex items-center gap-2">
                          <span class="px-3 py-1 bg-yellow-500/20 text-yellow-200 rounded-full text-xs font-bold border border-yellow-400/30">High Priority</span>
                          <span class="px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold">Confidence: 87%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="group/card relative bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/20 transition-all cursor-pointer transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative flex items-start gap-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0 group-hover/card:scale-110 group-hover/card:rotate-12 transition-all">
                        <span class="text-2xl">🎯</span>
                      </div>
                      <div class="flex-1">
                        <p class="font-bold text-lg mb-2">Bundle Opportunity Detected</p>
                        <p class="text-sm text-purple-100 mb-3">85% of customers buying "Coffee" also purchase "Sugar" - create a combo offer</p>
                        <div class="flex items-center gap-2">
                          <span class="px-3 py-1 bg-green-500/20 text-green-200 rounded-full text-xs font-bold border border-green-400/30">Revenue Boost</span>
                          <span class="px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold">+15% Sales</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="group/card relative bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/20 transition-all cursor-pointer transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover/card:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative flex items-start gap-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0 group-hover/card:scale-110 group-hover/card:rotate-12 transition-all">
                        <span class="text-2xl">📱</span>
                      </div>
                      <div class="flex-1">
                        <p class="font-bold text-lg mb-2">Mobile Experience Insight</p>
                        <p class="text-sm text-purple-100 mb-3">68% of orders from mobile devices - optimize checkout for faster conversions</p>
                        <div class="flex items-center gap-2">
                          <span class="px-3 py-1 bg-blue-500/20 text-blue-200 rounded-full text-xs font-bold border border-blue-400/30">UX Improvement</span>
                          <span class="px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold">Impact: High</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <button class="w-full mt-6 px-6 py-4 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 hover:border-white/50 flex items-center justify-center gap-3 group/btn shadow-xl">
                  <span class="text-lg">🔮</span>
                  <span>View All AI Insights</span>
                  <svg class="w-5 h-5 group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
          <!-- Local Payment Methods -->
          <div class="bg-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
              <span>💳</span>
              <span>Payment Methods</span>
            </h3>
            
            <div class="space-y-3">
              <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white font-bold">Ch</div>
                  <div>
                    <p class="font-semibold text-gray-900">Chapa</p>
                    <p class="text-xs text-gray-500">Active</p>
                  </div>
                </div>
                <span class="text-green-600 font-bold">45%</span>
              </div>
              
              <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                  <div>
                    <p class="font-semibold text-gray-900">Telebirr</p>
                    <p class="text-xs text-gray-500">Coming Soon</p>
                  </div>
                </div>
                <span class="text-gray-400 text-xs">Soon</span>
              </div>
              
              <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white font-bold">CB</div>
                  <div>
                    <p class="font-semibold text-gray-900">CBE Birr</p>
                    <p class="text-xs text-gray-500">Coming Soon</p>
                  </div>
                </div>
                <span class="text-gray-400 text-xs">Soon</span>
              </div>
              
              <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border border-yellow-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center text-white font-bold">💵</div>
                  <div>
                    <p class="font-semibold text-gray-900">Cash</p>
                    <p class="text-xs text-gray-500">Active</p>
                  </div>
                </div>
                <span class="text-yellow-600 font-bold">55%</span>
              </div>
            </div>
          </div>

          <!-- Smart Delivery System -->
          <div class="bg-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
              <span>🚚</span>
              <span>Delivery Status</span>
            </h3>
            
            <div class="space-y-3">
              <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                <div>
                  <p class="font-semibold text-gray-900">On Time</p>
                  <p class="text-xs text-gray-500">12 deliveries</p>
                </div>
                <div class="text-right">
                  <p class="text-2xl font-bold text-green-600">92%</p>
                  <p class="text-xs text-green-600">↑ 5%</p>
                </div>
              </div>
              
              <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                <div>
                  <p class="font-semibold text-gray-900">In Transit</p>
                  <p class="text-xs text-gray-500">8 deliveries</p>
                </div>
                <div class="text-right">
                  <p class="text-2xl font-bold text-orange-600">8</p>
                </div>
              </div>
              
              <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                <div>
                  <p class="font-semibold text-gray-900">Scheduled</p>
                  <p class="text-xs text-gray-500">15 deliveries</p>
                </div>
                <div class="text-right">
                  <p class="text-2xl font-bold text-blue-600">15</p>
                </div>
              </div>
            </div>
            
            <button class="w-full mt-4 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-xl font-semibold transition-all shadow-lg">
              View All Deliveries
            </button>
          </div>

          <!-- Quick Stats -->
          <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl p-6 text-white shadow-xl">
            <h3 class="text-lg font-bold mb-4">Quick Stats</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-blue-100">Avg Order Value</span>
                <span class="font-bold">ETB 450</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-blue-100">Customer Retention</span>
                <span class="font-bold">78%</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-blue-100">Mobile Orders</span>
                <span class="font-bold">68%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Products -->
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>🏆</span>
            <span>Top Selling Products</span>
          </h3>
          
          <div class="space-y-3">
            <div v-for="(product, index) in topProducts" :key="index" class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all cursor-pointer">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center text-white font-bold">
                {{ index + 1 }}
              </div>
              <div class="flex-1">
                <p class="font-semibold text-gray-900">{{ product.name }}</p>
                <p class="text-xs text-gray-500">{{ product.sold }} units sold</p>
              </div>
              <div class="text-right">
                <p class="font-bold text-green-600">ETB {{ formatCurrency(product.revenue) }}</p>
                <p class="text-xs text-gray-500">Revenue</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl p-6 shadow-lg">
          <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>⚡</span>
            <span>Recent Activities</span>
          </h3>
          
          <div class="space-y-3">
            <div v-for="(activity, index) in recentActivities" :key="index" class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
              <div class="w-8 h-8 rounded-full flex items-center justify-center text-lg" :class="activity.bgColor">
                {{ activity.icon }}
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ activity.title }}</p>
                <p class="text-xs text-gray-500">{{ activity.description }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ activity.time }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Promo/Discount Engine -->
      <div class="mt-6 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
          <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
        </div>
        
        <div class="relative">
          <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border-2 border-white/30">
                  <span class="text-2xl">🎁</span>
                </div>
                <div>
                  <h3 class="text-xl font-bold">Active Promotions</h3>
                  <p class="text-sm text-yellow-100">Boost your sales with smart discounts</p>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                  <p class="text-2xl font-bold mb-1">3</p>
                  <p class="text-sm text-yellow-100">Active Promos</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                  <p class="text-2xl font-bold mb-1">ETB 12,450</p>
                  <p class="text-sm text-yellow-100">Discount Given</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                  <p class="text-2xl font-bold mb-1">156</p>
                  <p class="text-sm text-yellow-100">Customers Saved</p>
                </div>
              </div>
            </div>
            
            <button class="px-6 py-3 bg-white text-orange-600 rounded-xl font-bold hover:bg-yellow-50 transition-all shadow-lg flex items-center gap-2">
              <span>➕</span>
              <span>Create Promotion</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { useTranslation } from '@/composables/useTranslation'
import { dashboardApi } from '../../services/api'

const { t } = useTranslation()
const authStore = useAuthStore()

// Reactive Data
const stats = ref({
  todaySales: 8602.00,
  todayTransactions: 13,
  pendingOrders: 13,
  stockAlerts: 1,
  totalProducts: 150
})

const chartPeriod = ref('7d')
const currentTime = ref('')
const timeInterval = ref(null)

// Computed Properties
const userName = computed(() => authStore.user?.name?.split(' ')[0] || 'User')

const currentDate = computed(() => {
  return new Date().toLocaleDateString('en-ET', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
})

// Sales Data for Chart
const salesData = ref([
  { label: 'Mon', amount: 5200 },
  { label: 'Tue', amount: 6800 },
  { label: 'Wed', amount: 4500 },
  { label: 'Thu', amount: 7200 },
  { label: 'Fri', amount: 8600 },
  { label: 'Sat', amount: 9500 },
  { label: 'Sun', amount: 8602 }
])

const maxSales = computed(() => {
  return Math.max(...salesData.value.map(d => d.amount))
})

// Top Products
const topProducts = ref([
  { name: 'Teff (White)', sold: 245, revenue: 36750 },
  { name: 'Ethiopian Coffee', sold: 189, revenue: 28350 },
  { name: 'Berbere Spice', sold: 156, revenue: 15600 },
  { name: 'Injera', sold: 134, revenue: 13400 },
  { name: 'Shiro Powder', sold: 98, revenue: 9800 }
])

// Recent Activities
const recentActivities = ref([
  { icon: '🛒', title: 'New Order #1234', description: 'Customer purchased 5 items', time: '2 minutes ago', bgColor: 'bg-green-100' },
  { icon: '📦', title: 'Stock Updated', description: 'Teff inventory restocked', time: '15 minutes ago', bgColor: 'bg-blue-100' },
  { icon: '💰', title: 'Payment Received', description: 'ETB 1,250 via Chapa', time: '23 minutes ago', bgColor: 'bg-yellow-100' },
  { icon: '🚚', title: 'Delivery Completed', description: 'Order #1230 delivered', time: '45 minutes ago', bgColor: 'bg-purple-100' },
  { icon: '⚠️', title: 'Low Stock Alert', description: 'Sugar below minimum level', time: '1 hour ago', bgColor: 'bg-red-100' }
])

// Methods
const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { 
    minimumFractionDigits: 2, 
    maximumFractionDigits: 2 
  })
}

const updateTime = () => {
  currentTime.value = new Date().toLocaleTimeString('en-ET', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

const openAIAssistant = () => {
  alert('AI Assistant feature coming soon! This will provide intelligent insights and recommendations.')
}

const fetchDashboardData = async () => {
  try {
    const response = await dashboardApi.get()
    if (response.data) {
      stats.value = {
        todaySales: response.data.today_sales || 0,
        todayTransactions: response.data.today_transactions || 0,
        pendingOrders: response.data.pending_orders || 0,
        stockAlerts: response.data.stock_alerts || 0,
        totalProducts: response.data.total_products || 0
      }
    }
  } catch (error) {
    console.error('Error fetching dashboard data:', error)
  }
}

// Lifecycle Hooks
onMounted(() => {
  updateTime()
  timeInterval.value = setInterval(updateTime, 1000)
  fetchDashboardData()
})

onUnmounted(() => {
  if (timeInterval.value) {
    clearInterval(timeInterval.value)
  }
})
</script>

<style scoped>
/* Advanced Animations */
@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

@keyframes gradient-xy {
  0%, 100% {
    background-position: 0% 0%;
  }
  25% {
    background-position: 100% 0%;
  }
  50% {
    background-position: 100% 100%;
  }
  75% {
    background-position: 0% 100%;
  }
}

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
    transform: translateY(20px) translateX(-10px);
  }
  66% {
    transform: translateY(10px) translateX(10px);
  }
}

@keyframes particle-float {
  0%, 100% {
    transform: translateY(0px) scale(1);
    opacity: 0.6;
  }
  50% {
    transform: translateY(-100px) scale(1.5);
    opacity: 0;
  }
}

@keyframes particle-rise {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateY(-100px) scale(0);
    opacity: 0;
  }
}

@keyframes wave {
  0%, 100% {
    transform: rotate(0deg);
  }
  25% {
    transform: rotate(20deg);
  }
  75% {
    transform: rotate(-20deg);
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

@keyframes shake {
  0%, 100% {
    transform: translateX(0) rotate(0deg);
  }
  25% {
    transform: translateX(-5px) rotate(-5deg);
  }
  75% {
    transform: translateX(5px) rotate(5deg);
  }
}

@keyframes progress {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(0);
  }
}

@keyframes scan-line {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(500%);
  }
}

.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
  background-size: 200% 200%;
}

.animate-gradient-xy {
  animation: gradient-xy 8s ease infinite;
  background-size: 200% 200%;
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

.particle-rise {
  animation: particle-rise 2s ease-out infinite;
}

.animate-wave {
  animation: wave 2s ease-in-out infinite;
}

.animate-bounce-slow {
  animation: bounce-slow 2s ease-in-out infinite;
}

.animate-shake {
  animation: shake 0.5s ease-in-out infinite;
}

.animate-progress {
  animation: progress 1.5s ease-out;
}

.scan-line {
  animation: scan-line 3s linear infinite;
}

/* 3D Transform Effects */
.transform-3d {
  transform-style: preserve-3d;
  perspective: 1000px;
}

/* Glassmorphism */
.glass {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
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
