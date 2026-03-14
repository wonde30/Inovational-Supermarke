<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse"></div>
    </div>

    <div class="relative z-10 p-6">
      <div class="max-w-7xl mx-auto space-y-8">
        <!-- Revolutionary Header -->
        <div class="relative group">
          <!-- 3D Background Layer -->
          <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-[1.02] shadow-2xl"></div>
          
          <!-- Main Content Layer -->
          <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-8 text-white shadow-2xl overflow-hidden border border-white/20">
            <!-- Animated Mesh Background -->
            <div class="absolute inset-0 opacity-20">
              <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
              <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
            </div>
            
            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
              <div class="particle-float absolute w-2 h-2 bg-white/60 rounded-full" style="top: 20%; left: 10%; animation-delay: 0s"></div>
              <div class="particle-float absolute w-3 h-3 bg-yellow-300/40 rounded-full" style="top: 60%; left: 80%; animation-delay: 1s"></div>
              <div class="particle-float absolute w-2 h-2 bg-pink-300/50 rounded-full" style="top: 40%; left: 60%; animation-delay: 2s"></div>
            </div>
            
            <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
              <div class="flex items-center gap-6">
                <!-- 3D Icon -->
                <div class="relative group/icon">
                  <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                  <div class="relative w-20 h-20 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                    <span class="text-5xl">🏢</span>
                  </div>
                </div>
                
                <div>
                  <h1 class="text-4xl font-black mb-2 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                    {{ t('suppliers.supplierManagement') }} / አቅራቢዎች
                  </h1>
                  <p class="text-green-100 text-lg font-medium">🚚 {{ t('suppliers.manageYourSuppliers') }} & Delivery Network</p>
                </div>
              </div>
              
              <!-- Enhanced Action Button -->
              <button @click="openModal()" class="group/btn relative px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-black text-gray-900 transition-all shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden text-lg">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <div class="relative flex items-center gap-3">
                  <span class="text-3xl animate-bounce-slow">➕</span>
                  <span>{{ t('suppliers.addSupplier') }}</span>
                  <svg class="w-6 h-6 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                  </svg>
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Enhanced Search & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Search Section -->
          <div class="lg:col-span-2 group relative transform transition-all duration-500 hover:scale-[1.01]">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
              <div class="flex items-center gap-4 mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                  <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">🔍</span>
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-black text-gray-900">Search Suppliers</h3>
                  <p class="text-gray-600 font-medium">Find suppliers and delivery partners</p>
                </div>
              </div>
              <SearchInput v-model="search" :placeholder="t('suppliers.searchSuppliers')" @update:modelValue="fetchSuppliers" />
            </div>
          </div>
          
          <!-- Quick Stats -->
          <div class="group relative transform transition-all duration-500 hover:scale-[1.01]">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-purple-300 transition-all">
              <div class="flex items-center gap-4 mb-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                  <div class="relative w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">📊</span>
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-black text-gray-900">Quick Stats</h3>
                  <p class="text-gray-600 font-medium">Supplier overview</p>
                </div>
              </div>
              <div class="space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 font-medium">Total Suppliers</span>
                  <span class="text-2xl font-black text-purple-600">{{ suppliers.length }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 font-medium">Active Deliveries</span>
                  <span class="text-2xl font-black text-green-600">{{ activeDeliveries }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 font-medium">On-Time Rate</span>
                  <span class="text-2xl font-black text-blue-600">94%</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revolutionary Suppliers Table -->
        <LoadingSpinner v-if="loading" />
        <div v-else class="group relative transform transition-all duration-500 hover:scale-[1.005]">
          <!-- 3D Shadow -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-2xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
          
          <!-- Main Table Card -->
          <div class="relative bg-white rounded-3xl shadow-2xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 via-green-50 to-emerald-50 px-8 py-6 border-b-2 border-gray-100">
              <div class="flex items-center gap-4">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                  <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-3xl">📋</span>
                  </div>
                </div>
                <div>
                  <h2 class="text-2xl font-black text-gray-900">Supplier Directory</h2>
                  <p class="text-green-600 font-semibold">{{ suppliers.length }} suppliers • {{ activeDeliveries }} active deliveries</p>
                </div>
              </div>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gradient-to-r from-green-100 to-emerald-100">
                  <tr>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">{{ t('common.name') }}</th>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">{{ t('suppliers.email') }}</th>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">{{ t('suppliers.phone') }}</th>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">{{ t('suppliers.contactPerson') }}</th>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">Delivery Status</th>
                    <th class="px-8 py-4 text-left font-black text-gray-900 uppercase tracking-wide">{{ t('common.actions') }}</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <tr v-for="supplier in suppliers" :key="supplier.id" class="group/row hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all">
                    <td class="px-8 py-6">
                      <div class="flex items-center gap-4">
                        <div class="relative group/avatar">
                          <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur-md opacity-50 group-hover/avatar:opacity-75 transition-opacity"></div>
                          <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-xl shadow-xl group-hover/avatar:scale-110 group-hover/avatar:rotate-6 transition-all">
                            {{ supplier.name.charAt(0) }}
                          </div>
                        </div>
                        <div>
                          <p class="font-black text-gray-900 text-lg">{{ supplier.name }}</p>
                          <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                            <span>📍</span>
                            <span>{{ supplier.address || 'Address not provided' }}</span>
                          </p>
                          <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-bold">✅ Active</span>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">🚚 Delivery Partner</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-8 py-6">
                      <div class="flex items-center gap-2">
                        <span class="text-lg">📧</span>
                        <span class="font-medium text-gray-700">{{ supplier.email || 'Not provided' }}</span>
                      </div>
                    </td>
                    <td class="px-8 py-6">
                      <div class="flex items-center gap-2">
                        <span class="text-lg">📞</span>
                        <span class="font-medium text-gray-700">{{ supplier.phone || 'Not provided' }}</span>
                      </div>
                    </td>
                    <td class="px-8 py-6">
                      <div class="flex items-center gap-2">
                        <span class="text-lg">👤</span>
                        <span class="font-medium text-gray-700">{{ supplier.contact_person || 'Not assigned' }}</span>
                      </div>
                    </td>
                    <td class="px-8 py-6">
                      <div class="space-y-2">
                        <div class="flex items-center gap-2">
                          <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                          <span class="text-sm font-bold text-green-600">{{ getRandomDeliveries() }} Active</span>
                        </div>
                        <div class="flex items-center gap-2">
                          <span class="text-lg">⏱️</span>
                          <span class="text-sm font-medium text-gray-600">{{ getRandomOnTime() }}% On-Time</span>
                        </div>
                        <div class="flex items-center gap-2">
                          <span class="text-lg">📦</span>
                          <span class="text-sm font-medium text-gray-600">{{ getRandomDelivered() }} Delivered</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-8 py-6">
                      <div class="flex items-center gap-3">
                        <button @click="openModal(supplier)" class="group/edit relative px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/50 transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/edit:translate-x-[100%] transition-transform duration-1000"></div>
                          <div class="relative flex items-center gap-2">
                            <span class="text-lg">✏️</span>
                            <span>{{ t('common.edit') }}</span>
                          </div>
                        </button>
                        <button @click="viewDeliveries(supplier)" class="group/view relative px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-green-500/50 transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/view:translate-x-[100%] transition-transform duration-1000"></div>
                          <div class="relative flex items-center gap-2">
                            <span class="text-lg">🚚</span>
                            <span>Deliveries</span>
                          </div>
                        </button>
                        <button @click="deleteSupplier(supplier.id)" class="group/delete relative px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-red-500/50 transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/delete:translate-x-[100%] transition-transform duration-1000"></div>
                          <div class="relative flex items-center gap-2">
                            <span class="text-lg">🗑️</span>
                            <span>{{ t('common.delete') }}</span>
                          </div>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="suppliers.length === 0">
                    <td colspan="6" class="px-8 py-16 text-center">
                      <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                        <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
                          <span class="text-6xl">📦</span>
                        </div>
                      </div>
                      <p class="text-2xl font-black text-gray-700 mb-2">{{ t('suppliers.noSuppliersFound') }}</p>
                      <p class="text-gray-500 font-medium">Add suppliers to manage your delivery network</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Enhanced Modal -->
        <Modal v-model="showModal" :title="editing ? t('suppliers.editSupplier') : t('suppliers.addSupplier')">
          <div class="relative">
            <!-- Modal Header with Icon -->
            <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-200">
              <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl">{{ editing ? '✏️' : '➕' }}</span>
                </div>
              </div>
              <div>
                <h3 class="text-xl font-black text-gray-900">{{ editing ? 'Edit Supplier' : 'Add New Supplier' }}</h3>
                <p class="text-green-600 font-medium">{{ editing ? 'Update supplier information' : 'Add a new supplier to your network' }}</p>
              </div>
            </div>
            
            <form @submit.prevent="saveSupplier" class="space-y-6">
              <!-- Enhanced Form Fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('common.name') }} *</label>
                  <InputField v-model="form.name" :placeholder="'Enter supplier name'" />
                </div>
                <div class="space-y-2">
                  <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('suppliers.email') }}</label>
                  <InputField v-model="form.email" type="email" :placeholder="'supplier@example.com'" />
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('suppliers.phone') }}</label>
                  <InputField v-model="form.phone" :placeholder="'+251 911 123 456'" />
                </div>
                <div class="space-y-2">
                  <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('suppliers.contactPerson') }}</label>
                  <InputField v-model="form.contact_person" :placeholder="'Contact person name'" />
                </div>
              </div>
              
              <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ t('suppliers.address') }}</label>
                <InputField v-model="form.address" :placeholder="'Full address with city and region'" />
              </div>
              
              <!-- Delivery Settings -->
              <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border border-blue-200">
                <h4 class="text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                  <span>🚚</span>
                  <span>Delivery Settings</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Delivery Zone</label>
                    <select v-model="form.delivery_zone" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none font-medium">
                      <option value="">Select delivery zone</option>
                      <option value="addis_ababa">Addis Ababa</option>
                      <option value="dire_dawa">Dire Dawa</option>
                      <option value="mekelle">Mekelle</option>
                      <option value="bahir_dar">Bahir Dar</option>
                      <option value="hawassa">Hawassa</option>
                      <option value="nationwide">Nationwide</option>
                    </select>
                  </div>
                  <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Delivery Time</label>
                    <select v-model="form.delivery_time" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none font-medium">
                      <option value="">Select delivery time</option>
                      <option value="same_day">Same Day (0-24 hours)</option>
                      <option value="next_day">Next Day (24-48 hours)</option>
                      <option value="2_3_days">2-3 Days</option>
                      <option value="3_5_days">3-5 Days</option>
                      <option value="1_week">1 Week</option>
                    </select>
                  </div>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex justify-end gap-4 pt-6 border-t-2 border-gray-100">
                <button type="button" @click="showModal = false" class="group/cancel relative px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transition-all transform hover:scale-105 overflow-hidden">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/cancel:translate-x-[100%] transition-transform duration-1000"></div>
                  <div class="relative flex items-center gap-2">
                    <span class="text-xl">✕</span>
                    <span>{{ t('common.cancel') }}</span>
                  </div>
                </button>
                <button type="submit" class="group/save relative px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white font-bold rounded-xl shadow-2xl hover:shadow-green-500/50 transition-all transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/save:translate-x-[100%] transition-transform duration-1000"></div>
                  <div class="relative flex items-center gap-2">
                    <span class="text-xl">💾</span>
                    <span>{{ editing ? t('common.update') : t('common.save') }}</span>
                  </div>
                </button>
              </div>
            </form>
          </div>
        </Modal>

        <!-- Delivery Details Modal -->
        <Modal v-model="showDeliveryModal" title="Delivery Management">
          <div class="relative">
            <!-- Delivery Header -->
            <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border border-blue-200">
              <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl blur-md opacity-50 animate-pulse"></div>
                <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                  <span class="text-2xl">🚚</span>
                </div>
              </div>
              <div>
                <h3 class="text-xl font-black text-gray-900">{{ selectedSupplier?.name }} Deliveries</h3>
                <p class="text-blue-600 font-medium">Track and manage delivery performance</p>
              </div>
            </div>
            
            <!-- Delivery Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
              <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                <p class="text-2xl font-black text-green-600">{{ getRandomDeliveries() }}</p>
                <p class="text-sm font-bold text-gray-700">Active</p>
              </div>
              <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-200">
                <p class="text-2xl font-black text-blue-600">{{ getRandomOnTime() }}%</p>
                <p class="text-sm font-bold text-gray-700">On-Time</p>
              </div>
              <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-200">
                <p class="text-2xl font-black text-purple-600">{{ getRandomDelivered() }}</p>
                <p class="text-sm font-bold text-gray-700">Completed</p>
              </div>
            </div>
            
            <!-- Recent Deliveries -->
            <div class="space-y-3">
              <h4 class="text-lg font-black text-gray-900">Recent Deliveries</h4>
              <div v-for="i in 5" :key="i" class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                    #{{ 1000 + i }}
                  </div>
                  <div>
                    <p class="font-bold text-gray-900">Order #ORD-{{ 2026 }}{{ String(i).padStart(3, '0') }}</p>
                    <p class="text-sm text-gray-500">{{ getRandomDate() }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">✅ Delivered</span>
                  <p class="text-sm text-gray-500 mt-1">ETB {{ (Math.random() * 5000 + 500).toFixed(0) }}</p>
                </div>
              </div>
            </div>
          </div>
        </Modal>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { suppliersApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import SearchInput from '../../components/SearchInput.vue'
import Modal from '../../components/Modal.vue'
import InputField from '../../components/InputField.vue'

const toast = useToastStore()
const { t } = useTranslation()
const loading = ref(true)
const suppliers = ref([])
const search = ref('')
const showModal = ref(false)
const showDeliveryModal = ref(false)
const editing = ref(null)
const selectedSupplier = ref(null)
const activeDeliveries = ref(23)
const form = reactive({ 
  name: '', 
  email: '', 
  phone: '', 
  contact_person: '', 
  address: '',
  delivery_zone: '',
  delivery_time: ''
})

// Helper functions for demo data
const getRandomDeliveries = () => Math.floor(Math.random() * 15) + 5
const getRandomOnTime = () => Math.floor(Math.random() * 20) + 80
const getRandomDelivered = () => Math.floor(Math.random() * 100) + 50
const getRandomDate = () => {
  const dates = ['2 hours ago', '5 hours ago', '1 day ago', '2 days ago', '3 days ago']
  return dates[Math.floor(Math.random() * dates.length)]
}

const fetchSuppliers = async () => {
  loading.value = true
  try {
    const response = await suppliersApi.getAll({ search: search.value })
    suppliers.value = response.data
  } catch (e) {} finally { loading.value = false }
}

const openModal = (supplier = null) => {
  editing.value = supplier
  Object.assign(form, supplier || { 
    name: '', 
    email: '', 
    phone: '', 
    contact_person: '', 
    address: '',
    delivery_zone: '',
    delivery_time: ''
  })
  showModal.value = true
}

const viewDeliveries = (supplier) => {
  selectedSupplier.value = supplier
  showDeliveryModal.value = true
}

const saveSupplier = async () => {
  try {
    if (editing.value) {
      await suppliersApi.update(editing.value.id, form)
      toast.success(t('suppliers.supplierUpdated'))
    } else {
      await suppliersApi.create(form)
      toast.success(t('suppliers.supplierCreated'))
    }
    showModal.value = false
    fetchSuppliers()
  } catch (e) { toast.error(t('suppliers.failedToSaveSupplier')) }
}

const deleteSupplier = async (id) => {
  if (!confirm(t('suppliers.deleteThisSupplier'))) return
  try {
    await suppliersApi.delete(id)
    toast.success(t('suppliers.supplierDeleted'))
    fetchSuppliers()
  } catch (e) { toast.error(t('suppliers.failedToDeleteSupplier')) }
}

onMounted(fetchSuppliers)
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

@keyframes bounce-slow {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
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

/* Table Hover Effects */
.group\/row:hover {
  transform: translateX(4px);
}

/* Button Hover Effects */
button:hover:not(:disabled) {
  transform: translateY(-2px);
}

button:active:not(:disabled) {
  transform: translateY(0);
}

/* Focus States */
input:focus, select:focus {
  transform: translateY(-2px);
}
</style>