<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Customers Header -->
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
              <!-- 3D Customers Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">👥</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart Customers / ደንበኞች
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📊</span>
                  <span>{{ customers.length }} Customers</span>
                  <span class="mx-2">•</span>
                  <span>🎯</span>
                  <span>Customer Relationship Management</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="exportCustomers" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📤</span>
                <span class="relative">Export Data</span>
              </button>
              
              <button @click="openModal()" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">➕</span>
                <span class="relative">Add Customer</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4 space-y-6">
      <!-- Revolutionary Customer Analytics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Card -->
          <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full blur-2xl opacity-50"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-4xl font-black text-blue-600 mb-1">{{ customers.length }}</p>
                <p class="text-sm text-gray-600 font-bold">Total Customers</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-blue-600 font-medium">Active Database</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-cyan-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">👥</div>
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
                <p class="text-4xl font-black text-green-600 mb-1">{{ activeCustomers }}</p>
                <p class="text-sm text-gray-600 font-bold">Active This Month</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-green-600 font-medium">Recent Activity</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">🎯</div>
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
                <p class="text-4xl font-black text-purple-600 mb-1">{{ newCustomers }}</p>
                <p class="text-sm text-gray-600 font-bold">New This Week</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-purple-600 font-medium">Growing Base</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-pink-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">⭐</div>
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
                <p class="text-3xl font-black text-orange-600 mb-1">{{ loyaltyScore }}%</p>
                <p class="text-sm text-gray-600 font-bold">Loyalty Score</p>
                <div class="flex items-center gap-1 mt-2">
                  <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                  <span class="text-xs text-orange-600 font-medium">Customer Retention</span>
                </div>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-red-200 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">💎</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Search & Filter Section -->
      <div class="group relative transform transition-all duration-500 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Enhanced Search -->
            <div class="md:col-span-2 relative group/search">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-blue-600 transition-colors">
                <span class="text-2xl">🔍</span>
              </div>
              <input 
                v-model="search" 
                @input="fetchCustomers"
                type="text" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Search customers by name, email, or phone..."
              />
            </div>
            
            <!-- Sort Options -->
            <div class="relative group/sort">
              <select 
                v-model="sortBy" 
                @change="sortCustomers"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="name">Sort by Name</option>
                <option value="email">Sort by Email</option>
                <option value="created_at">Sort by Date Added</option>
                <option value="last_order">Sort by Last Order</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/sort:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Customers Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="relative">
          <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
          <div class="relative w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center shadow-xl">
            <div class="loading-spinner w-10 h-10"></div>
          </div>
        </div>
      </div>

      <div v-else-if="customers.length === 0" class="relative group py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-3xl blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-6xl">👥</span>
            </div>
          </div>
          <h3 class="text-3xl font-black text-gray-700 mb-4">No Customers Found</h3>
          <p class="text-gray-500 text-lg mb-8">Start building your customer base by adding your first customer</p>
          <button @click="openModal()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1">
            <span class="text-2xl">➕</span>
            <span>Add Your First Customer</span>
          </button>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="customer in customers" 
          :key="customer.id" 
          class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Customer Card -->
          <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all flex flex-col" style="min-height: 320px;">
            <!-- Enhanced Customer Header -->
            <div class="relative bg-gradient-to-r from-green-50 to-emerald-50 p-6 text-center">
              <!-- Customer Avatar -->
              <div class="relative inline-block mb-4">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full blur-lg opacity-30 group-hover:opacity-50 transition-opacity"></div>
                <div class="relative w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-black text-2xl shadow-xl group-hover:scale-110 transition-transform">
                  {{ getCustomerInitials(customer.name) }}
                </div>
              </div>
              
              <!-- Customer Name -->
              <h3 class="font-black text-gray-900 text-xl mb-1 group-hover:text-green-600 transition-colors">
                {{ customer.name }}
              </h3>
              
              <!-- Customer Status -->
              <div class="flex items-center justify-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-sm text-green-600 font-bold">Active Customer</span>
              </div>
            </div>

            <!-- Enhanced Customer Details -->
            <div class="p-4 bg-gradient-to-br from-white to-gray-50 flex-1 flex flex-col space-y-3">
              <!-- Contact Info -->
              <div class="space-y-2">
                <div class="flex items-center gap-3 p-2 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg">
                  <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm">📧</span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 font-bold">Email</p>
                    <p class="text-sm text-gray-900 font-medium truncate">{{ customer.email || 'No email' }}</p>
                  </div>
                </div>
                
                <div class="flex items-center gap-3 p-2 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                  <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm">📞</span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 font-bold">Phone</p>
                    <p class="text-sm text-gray-900 font-medium truncate">{{ customer.phone || 'No phone' }}</p>
                  </div>
                </div>
                
                <div class="flex items-center gap-3 p-2 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg">
                  <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm">📍</span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 font-bold">Address</p>
                    <p class="text-sm text-gray-900 font-medium truncate">{{ customer.address || 'No address' }}</p>
                  </div>
                </div>
              </div>
              
              <!-- Customer Stats -->
              <div class="grid grid-cols-2 gap-2 pt-2">
                <div class="text-center p-2 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-100">
                  <p class="text-lg font-black text-green-600">{{ customer.orders_count || 0 }}</p>
                  <p class="text-xs text-green-700 font-bold">Orders</p>
                </div>
                <div class="text-center p-2 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg border border-blue-100">
                  <p class="text-sm font-black text-blue-600">ETB {{ formatCurrency(customer.total_spent || 0) }}</p>
                  <p class="text-xs text-blue-700 font-bold">Spent</p>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex gap-2 pt-3 mt-auto">
                <button @click="viewCustomer(customer)" class="flex-1 px-3 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                  <span>👁️</span>
                  <span>View</span>
                </button>
                <button @click="openModal(customer)" class="flex-1 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                  <span>✏️</span>
                  <span>Edit</span>
                </button>
                <button @click="deleteCustomer(customer.id)" class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105">
                  🗑️
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Revolutionary Customer Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="relative group max-w-2xl w-full">
        <!-- 3D Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <!-- Main Modal -->
        <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
          <!-- Modal Header -->
          <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-white">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                  <span class="text-2xl">{{ editing ? '✏️' : '➕' }}</span>
                </div>
                <div>
                  <h3 class="text-xl font-black">{{ editing ? 'Edit Customer' : 'Add New Customer' }}</h3>
                  <p class="text-green-100 text-sm">{{ editing ? 'Update customer information' : 'Create a new customer profile' }}</p>
                </div>
              </div>
              <button @click="showModal = false" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
                <span class="text-xl">✕</span>
              </button>
            </div>
          </div>
          
          <!-- Modal Body -->
          <form @submit.prevent="saveCustomer" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Customer Name -->
              <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                  <span class="text-lg">👤</span>
                  <span>Full Name / ሙሉ ስም</span>
                </label>
                <input 
                  v-model="form.name" 
                  type="text"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                  placeholder="Enter customer full name..."
                  required
                />
              </div>
              
              <!-- Email -->
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                  <span class="text-lg">📧</span>
                  <span>Email Address</span>
                </label>
                <input 
                  v-model="form.email" 
                  type="email"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                  placeholder="customer@example.com"
                />
              </div>
              
              <!-- Phone -->
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                  <span class="text-lg">📞</span>
                  <span>Phone Number</span>
                </label>
                <input 
                  v-model="form.phone" 
                  type="tel"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                  placeholder="+251 9XX XXX XXX"
                />
              </div>
              
              <!-- Address -->
              <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                  <span class="text-lg">📍</span>
                  <span>Address / አድራሻ</span>
                </label>
                <textarea 
                  v-model="form.address" 
                  rows="3"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm resize-none" 
                  placeholder="Enter customer address..."
                ></textarea>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
              <button 
                type="button" 
                @click="showModal = false" 
                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transition-all hover:scale-105 flex items-center gap-2"
              >
                <span>❌</span>
                <span>Cancel</span>
              </button>
              <button 
                type="submit" 
                :disabled="processing"
                class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 flex items-center gap-2"
              >
                <span v-if="processing" class="loading-spinner w-5 h-5"></span>
                <span v-else>{{ editing ? '💾' : '➕' }}</span>
                <span>{{ processing ? 'Saving...' : (editing ? 'Update Customer' : 'Add Customer') }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Revolutionary Customer Detail Modal -->
    <div v-if="selectedCustomer" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="relative group max-w-3xl w-full max-h-[90vh] overflow-hidden">
        <!-- 3D Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <!-- Main Modal -->
        <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
          <!-- Modal Header -->
          <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-6 text-white">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-2xl font-black">
                  {{ getCustomerInitials(selectedCustomer.name) }}
                </div>
                <div>
                  <h3 class="text-2xl font-black">{{ selectedCustomer.name }}</h3>
                  <p class="text-blue-100 text-sm">Customer Profile & Analytics</p>
                </div>
              </div>
              <button @click="selectedCustomer = null" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
                <span class="text-xl">✕</span>
              </button>
            </div>
          </div>
          
          <!-- Modal Body -->
          <div class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
            <!-- Customer Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Contact Information -->
              <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border-2 border-blue-100">
                <h4 class="font-bold text-blue-900 mb-3 flex items-center gap-2">
                  <span class="text-xl">📞</span>
                  <span>Contact Information</span>
                </h4>
                <div class="space-y-3">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">📧</span>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500 font-bold">Email</p>
                      <p class="text-sm text-gray-900">{{ selectedCustomer.email || 'No email provided' }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">📞</span>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500 font-bold">Phone</p>
                      <p class="text-sm text-gray-900">{{ selectedCustomer.phone || 'No phone provided' }}</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                      <span class="text-white text-sm">📍</span>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500 font-bold">Address</p>
                      <p class="text-sm text-gray-900">{{ selectedCustomer.address || 'No address provided' }}</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Customer Statistics -->
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-100">
                <h4 class="font-bold text-green-900 mb-3 flex items-center gap-2">
                  <span class="text-xl">📊</span>
                  <span>Customer Statistics</span>
                </h4>
                <div class="grid grid-cols-2 gap-3">
                  <div class="text-center p-3 bg-white rounded-lg border border-green-200">
                    <p class="text-2xl font-black text-green-600">{{ selectedCustomer.orders_count || 0 }}</p>
                    <p class="text-xs text-green-700 font-bold">Total Orders</p>
                  </div>
                  <div class="text-center p-3 bg-white rounded-lg border border-blue-200">
                    <p class="text-lg font-black text-blue-600">ETB {{ formatCurrency(selectedCustomer.total_spent || 0) }}</p>
                    <p class="text-xs text-blue-700 font-bold">Total Spent</p>
                  </div>
                  <div class="text-center p-3 bg-white rounded-lg border border-purple-200">
                    <p class="text-lg font-black text-purple-600">{{ selectedCustomer.avg_order_value || 0 }}</p>
                    <p class="text-xs text-purple-700 font-bold">Avg Order</p>
                  </div>
                  <div class="text-center p-3 bg-white rounded-lg border border-orange-200">
                    <p class="text-lg font-black text-orange-600">{{ selectedCustomer.loyalty_points || 0 }}</p>
                    <p class="text-xs text-orange-700 font-bold">Loyalty Points</p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 border-2 border-gray-200">
              <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="text-xl">🛍️</span>
                <span>Recent Orders</span>
              </h4>
              <div class="space-y-2">
                <div v-for="order in selectedCustomer.recent_orders || []" :key="order.id" class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                  <div>
                    <p class="font-bold text-gray-900">#{{ order.order_number }}</p>
                    <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-bold text-green-600">ETB {{ formatCurrency(order.total) }}</p>
                    <p class="text-xs text-gray-500">{{ order.status }}</p>
                  </div>
                </div>
                <div v-if="!selectedCustomer.recent_orders || selectedCustomer.recent_orders.length === 0" class="text-center py-8 text-gray-500">
                  <span class="text-4xl block mb-2">📦</span>
                  <p>No orders yet</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="bg-gray-50 p-6 flex gap-4">
            <button 
              @click="openModal(selectedCustomer)" 
              class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2"
            >
              <span>✏️</span>
              <span>Edit Customer</span>
            </button>
            <button 
              @click="selectedCustomer = null" 
              class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2"
            >
              <span>✅</span>
              <span>Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { customersApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'

const toast = useToastStore()
const { t } = useTranslation()

// Reactive Data
const loading = ref(true)
const processing = ref(false)
const customers = ref([])
const search = ref('')
const sortBy = ref('name')
const showModal = ref(false)
const selectedCustomer = ref(null)
const editing = ref(null)

const form = reactive({
  name: '',
  email: '',
  phone: '',
  address: ''
})

// Computed Properties for Analytics
const activeCustomers = computed(() => {
  // Customers with orders in the last 30 days
  return customers.value.filter(customer => {
    if (!customer.last_order_date) return false
    const lastOrder = new Date(customer.last_order_date)
    const thirtyDaysAgo = new Date()
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30)
    return lastOrder >= thirtyDaysAgo
  }).length
})

const newCustomers = computed(() => {
  // Customers added in the last 7 days
  return customers.value.filter(customer => {
    const createdDate = new Date(customer.created_at)
    const sevenDaysAgo = new Date()
    sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7)
    return createdDate >= sevenDaysAgo
  }).length
})

const loyaltyScore = computed(() => {
  // Calculate average loyalty score based on repeat customers
  const repeatCustomers = customers.value.filter(customer => (customer.orders_count || 0) > 1)
  return customers.value.length > 0 ? Math.round((repeatCustomers.length / customers.value.length) * 100) : 0
})

// Utility Functions
const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const formatDate = (date) => {
  if (!date) return 'Unknown'
  return new Date(date).toLocaleDateString('en-ET', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric' 
  })
}

const getCustomerInitials = (name) => {
  if (!name) return '?'
  return name.split(' ').map(n => n.charAt(0)).join('').substring(0, 2).toUpperCase()
}

// API Functions
const fetchCustomers = async () => {
  loading.value = true
  try {
    const params = { search: search.value }
    const response = await customersApi.getAll(params)
    customers.value = response.data || []
    
    // Sort customers
    sortCustomers()
  } catch (e) {
    customers.value = []
    toast.error('Failed to load customers')
  } finally {
    loading.value = false
  }
}

const sortCustomers = () => {
  customers.value.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.name.localeCompare(b.name)
      case 'email':
        return (a.email || '').localeCompare(b.email || '')
      case 'created_at':
        return new Date(b.created_at) - new Date(a.created_at)
      case 'last_order':
        return new Date(b.last_order_date || 0) - new Date(a.last_order_date || 0)
      default:
        return 0
    }
  })
}

const openModal = (customer = null) => {
  editing.value = customer
  selectedCustomer.value = null // Close detail modal if open
  
  if (customer) {
    Object.assign(form, {
      name: customer.name || '',
      email: customer.email || '',
      phone: customer.phone || '',
      address: customer.address || ''
    })
  } else {
    Object.assign(form, {
      name: '',
      email: '',
      phone: '',
      address: ''
    })
  }
  showModal.value = true
}

const viewCustomer = async (customer) => {
  try {
    // Fetch detailed customer data including recent orders
    const response = await customersApi.getById(customer.id)
    selectedCustomer.value = response.data
  } catch (e) {
    // Fallback to basic customer data
    selectedCustomer.value = customer
  }
}

const saveCustomer = async () => {
  processing.value = true
  try {
    if (editing.value) {
      await customersApi.update(editing.value.id, form)
      toast.success('✅ Customer updated successfully!')
    } else {
      await customersApi.create(form)
      toast.success('✅ Customer added successfully!')
    }
    showModal.value = false
    fetchCustomers()
  } catch (e) {
    toast.error(e.message || 'Failed to save customer')
  } finally {
    processing.value = false
  }
}

const deleteCustomer = async (id) => {
  if (!confirm('Are you sure you want to delete this customer? This action cannot be undone.')) return
  
  try {
    await customersApi.delete(id)
    toast.success('🗑️ Customer deleted successfully!')
    fetchCustomers()
  } catch (e) {
    toast.error('Failed to delete customer')
  }
}

const exportCustomers = () => {
  // Export functionality - could export to CSV/Excel
  const csvContent = "data:text/csv;charset=utf-8," 
    + "Name,Email,Phone,Address,Orders,Total Spent,Date Added\n"
    + customers.value.map(customer => 
        `"${customer.name}","${customer.email || ''}","${customer.phone || ''}","${customer.address || ''}",${customer.orders_count || 0},${customer.total_spent || 0},"${formatDate(customer.created_at)}"`
      ).join("\n")
  
  const encodedUri = encodeURI(csvContent)
  const link = document.createElement("a")
  link.setAttribute("href", encodedUri)
  link.setAttribute("download", `customers_${new Date().toISOString().split('T')[0]}.csv`)
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
  
  toast.success('📤 Customers exported successfully!')
}

// Lifecycle
onMounted(fetchCustomers)
</script>

<style scoped>
/* Revolutionary Customers Styles */
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

/* Text Truncation */
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Responsive Grid Adjustments */
@media (max-width: 768px) {
  .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}

@media (min-width: 768px) {
  .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (min-width: 1024px) {
  .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (min-width: 1280px) {
  .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
  }
}
</style>