<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Users Header -->
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
              <!-- 3D Users Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">👥</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  {{ t('users.title') }} / {{ t('users.userManagement') }}
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>👤</span>
                  <span>{{ users?.length || 0 }} {{ t('users.title') }}</span>
                  <span class="mx-2">•</span>
                  <span>🔐</span>
                  <span>{{ t('users.rolePermissions') }}</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="exportUsers" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📤</span>
                <span class="relative">{{ t('common.export') }}</span>
              </button>
              
              <button @click="openModal()" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">➕</span>
                <span class="relative">{{ t('users.addUser') }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4 space-y-6">
      <!-- Revolutionary Role Permissions Dashboard -->
      <div class="group relative transform transition-all duration-500 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-purple-300 transition-all">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-white">🔐</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900">{{ t('users.rolePermissions') }}</h3>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border-2 border-purple-200 group-hover/role:border-purple-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">👑</span>
                  </div>
                  <span class="font-black text-purple-700 text-lg">{{ t('users.admin') }}</span>
                </div>
                <p class="text-sm text-purple-600 font-medium">{{ t('users.adminFullAccess') }}</p>
              </div>
            </div>
            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-2 border-blue-200 group-hover/role:border-blue-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">👔</span>
                  </div>
                  <span class="font-black text-blue-700 text-lg">{{ t('users.manager') }}</span>
                </div>
                <p class="text-sm text-blue-600 font-medium">{{ t('users.managerAccess') }}</p>
              </div>
            </div>

            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border-2 border-green-200 group-hover/role:border-green-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">💵</span>
                  </div>
                  <span class="font-black text-green-700 text-lg">{{ t('users.cashier') }}</span>
                </div>
                <p class="text-sm text-green-600 font-medium">{{ t('users.cashierAccess') }}</p>
              </div>
            </div>

            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border-2 border-yellow-200 group-hover/role:border-yellow-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">🚚</span>
                  </div>
                  <span class="font-black text-yellow-700 text-lg">{{ t('users.delivery_staff') }}</span>
                </div>
                <p class="text-sm text-yellow-600 font-medium">{{ t('users.deliveryStaffAccess') }}</p>
              </div>
            </div>

            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border-2 border-indigo-200 group-hover/role:border-indigo-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">🏭</span>
                  </div>
                  <span class="font-black text-indigo-700 text-lg">{{ t('users.supplier') }}</span>
                </div>
                <p class="text-sm text-indigo-600 font-medium">{{ t('users.supplierAccess') }}</p>
              </div>
            </div>

            <div class="group/role relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl blur-lg opacity-0 group-hover/role:opacity-20 transition-opacity"></div>
              <div class="relative p-4 bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border-2 border-pink-200 group-hover/role:border-pink-400 transition-all">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-xl text-white">🛍️</span>
                  </div>
                  <span class="font-black text-pink-700 text-lg">{{ t('users.customer') }}</span>
                </div>
                <p class="text-sm text-pink-600 font-medium">{{ t('users.customerAccess') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Revolutionary Users Grid -->
      <div class="group relative transform transition-all duration-500 hover:scale-[1.02]">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-10 transition-opacity"></div>
        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-6 shadow-2xl border-2 border-white/50 group-hover:border-green-300 transition-all">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl text-white">👥</span>
              </div>
              <h3 class="text-2xl font-black text-gray-900">{{ t('users.title') }}</h3>
            </div>
            <div class="text-sm text-gray-500 font-medium">{{ users?.length || 0 }} {{ t('users.title') }}</div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div v-for="user in users" :key="user.id" class="group/card relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
              <!-- 3D Card Background -->
              <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl group-hover/card:shadow-2xl transition-all"></div>
              <div class="absolute inset-0 bg-gradient-to-br rounded-2xl group-hover/card:opacity-10 transition-opacity" :class="getRoleGradient(user.role)" style="opacity: 0.05"></div>
              
              <!-- Card Content -->
              <div class="relative p-6 rounded-2xl border-2 border-gray-100 group-hover/card:border-green-300 transition-all bg-white/90 backdrop-blur-sm">
                <!-- User Avatar & Role Badge -->
                <div class="flex items-start justify-between mb-4">
                  <div class="relative">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg transform group-hover/card:scale-110 transition-transform" :class="getRoleColor(user.role)">
                      {{ user.name.charAt(0) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center text-lg shadow-lg" :class="getRoleColor(user.role)">
                      {{ getRoleIcon(user.role) }}
                    </div>
                  </div>
                  <div class="flex flex-col items-end gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold" :class="getRoleBadge(user.role)">
                      {{ user.role.toUpperCase() }}
                    </span>
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                      ✅ {{ t('common.active') }}
                    </span>
                  </div>
                </div>
                
                <!-- User Info -->
                <div class="space-y-3 mb-6">
                  <div>
                    <h4 class="font-black text-lg text-gray-900 mb-1">{{ user.name }}</h4>
                    <p class="text-gray-600 text-sm font-medium">{{ user.email }}</p>
                  </div>
                  
                  <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>📅</span>
                    <span>{{ t('users.created') }} {{ formatDate(user.created_at) }}</span>
                  </div>
                  
                  <!-- Role Description -->
                  <div class="p-3 rounded-xl" :class="getRoleBackground(user.role)">
                    <p class="text-xs font-medium" :class="getRoleTextColor(user.role)">
                      {{ getRoleDescription(user.role) }}
                    </p>
                  </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                  <button @click="openModal(user)" class="flex-1 group/btn relative px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                    <span class="relative flex items-center justify-center gap-2">
                      <span>✏️</span>
                      <span>{{ t('common.edit') }}</span>
                    </span>
                  </button>
                  
                  <button v-if="user.id !== currentUser?.id" @click="deleteUser(user.id)" class="group/btn relative px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                    <span class="relative flex items-center justify-center">
                      <span>🗑️</span>
                    </span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Revolutionary Add/Edit Modal -->
    <Modal v-model="showModal" title="User Management">
      <div class="relative">
        <!-- Modal Background Effects -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl opacity-50"></div>
        
        <form @submit.prevent="saveUser" class="relative space-y-6 p-6">
          <!-- User Avatar Section -->
          <div class="text-center mb-6">
            <div class="relative inline-block">
              <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-white font-black text-4xl shadow-2xl transform transition-all" :class="form.role ? getRoleColor(form.role) : 'bg-gray-400'">
                {{ form.name ? form.name.charAt(0).toUpperCase() : '👤' }}
              </div>
              <div v-if="form.role" class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full flex items-center justify-center text-2xl shadow-lg" :class="getRoleColor(form.role)">
                {{ getRoleIcon(form.role) }}
              </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mt-4">
              {{ editingUser ? t('users.editUser') : t('users.addUser') }}
            </h3>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div class="group relative">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span>👤</span>
                <span>{{ t('users.fullName') }}</span>
              </label>
              <div class="relative">
                <input v-model="form.name" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium group-hover:border-gray-300" :placeholder="t('users.enterFullName')" required />
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-500/5 to-green-500/0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
              </div>
            </div>

            <!-- Email -->
            <div class="group relative">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span>📧</span>
                <span>{{ t('auth.email') }}</span>
              </label>
              <div class="relative">
                <input v-model="form.email" type="email" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium group-hover:border-gray-300" :placeholder="t('common.enterEmailExample')" required />
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-500/5 to-green-500/0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
              </div>
            </div>
          </div>

          <!-- Role Selection -->
          <div class="group relative">
            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
              <span>🔐</span>
              <span>{{ t('users.role') }}</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
              <div v-for="role in ['admin', 'manager', 'cashier', 'customer', 'delivery_staff', 'supplier']" :key="role" class="group/role relative">
                <input :id="role" v-model="form.role" :value="role" type="radio" class="sr-only" required />
                <label :for="role" class="block p-4 rounded-xl border-2 cursor-pointer transition-all transform hover:scale-105" :class="form.role === role ? getRoleSelectedClass(role) : 'border-gray-200 hover:border-gray-300 bg-white'">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl shadow-md" :class="getRoleColor(role)">
                      {{ getRoleIcon(role) }}
                    </div>
                    <div>
                      <div class="font-bold text-sm capitalize">{{ t('users.' + role) }}</div>
                      <div class="text-xs text-gray-500">{{ getRoleDescription(role) }}</div>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Password -->
            <div class="group relative">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span>🔒</span>
                <span>{{ t('auth.password') }} {{ editingUser ? '(' + t('users.leaveBlankToKeep') + ')' : '' }}</span>
              </label>
              <div class="relative">
                <input v-model="form.password" type="password" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium group-hover:border-gray-300" :placeholder="editingUser ? '••••••••' : t('users.enterPassword')" :required="!editingUser" />
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-500/5 to-green-500/0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
              </div>
            </div>

            <!-- Confirm Password -->
            <div v-if="form.password" class="group relative">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span>🔐</span>
                <span>{{ t('users.confirmPassword') }}</span>
              </label>
              <div class="relative">
                <input v-model="form.password_confirmation" type="password" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium group-hover:border-gray-300" :placeholder="t('users.confirmPasswordPlaceholder')" required />
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-500/5 to-green-500/0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
              </div>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex justify-end gap-4 pt-6 border-t-2 border-gray-100">
            <button type="button" @click="showModal = false" class="group/btn relative px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl border-2 border-gray-200 transition-all duration-200 transform hover:scale-105 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/50 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
              <span class="relative flex items-center gap-2">
                <span>✕</span>
                <span>{{ t('common.cancel') }}</span>
              </span>
            </button>
            
            <button type="submit" class="group/btn relative px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none overflow-hidden" :disabled="saving">
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
              <span class="relative flex items-center gap-2">
                <span v-if="saving" class="loading-spinner w-5 h-5"></span>
                <span v-else>💾</span>
                <span>{{ editingUser ? t('common.update') : t('users.create') }}</span>
              </span>
            </button>
          </div>
        </form>
      </div>
    </Modal>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { usersApi } from '../../services/api'
import { useAuthStore } from '../../stores/auth'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'
import Modal from '../../components/Modal.vue'

const auth = useAuthStore()
const toast = useToastStore()
const { t } = useTranslation()
const users = ref([])
const showModal = ref(false)
const editingUser = ref(null)
const saving = ref(false)
const form = reactive({ name: '', email: '', role: '', password: '', password_confirmation: '' })

const currentUser = computed(() => auth.user)

const getRoleIcon = (role) => {
  const icons = { admin: '👑', manager: '👔', cashier: '💵', customer: '🛍️', delivery_staff: '🚚', supplier: '🏭' }
  return icons[role] || '👤'
}

const getRoleColor = (role) => {
  const colors = { admin: 'bg-purple-600', manager: 'bg-blue-600', cashier: 'bg-green-600', customer: 'bg-pink-600', delivery_staff: 'bg-yellow-600', supplier: 'bg-indigo-600' }
  return colors[role] || 'bg-gray-600'
}

const getRoleBadge = (role) => {
  const badges = { admin: 'bg-purple-100 text-purple-700', manager: 'bg-blue-100 text-blue-700', cashier: 'bg-green-100 text-green-700', customer: 'bg-pink-100 text-pink-700', delivery_staff: 'bg-yellow-100 text-yellow-700', supplier: 'bg-indigo-100 text-indigo-700' }
  return badges[role] || 'bg-gray-100 text-gray-700'
}

const formatDate = (date) => date ? new Date(date).toLocaleDateString('en-ET', { day: '2-digit', month: 'short', year: 'numeric' }) : ''

const fetchUsers = async () => {
  try {
    const response = await usersApi.getAll()
    users.value = response.data || []
  } catch (e) {
    console.error('Failed to fetch users:', e)
    toast.error(t('users.failedToLoadUsers'))
  }
}

const openModal = (user = null) => {
  editingUser.value = user
  if (user) {
    Object.assign(form, { name: user.name, email: user.email, role: user.role, password: '', password_confirmation: '' })
  } else {
    Object.assign(form, { name: '', email: '', role: '', password: '', password_confirmation: '' })
  }
  showModal.value = true
}
const saveUser = async () => {
  if (form.password && form.password !== form.password_confirmation) {
    toast.error(t('users.passwordsDoNotMatch'))
    return
  }
  
  saving.value = true
  try {
    const data = { name: form.name, email: form.email, role: form.role }
    if (form.password) {
      data.password = form.password
      data.password_confirmation = form.password_confirmation
    }
    
    if (editingUser.value) {
      await usersApi.update(editingUser.value.id, data)
      toast.success(t('users.userUpdatedSuccess'))
    } else {
      await usersApi.create(data)
      toast.success(t('users.userCreatedSuccess'))
    }
    showModal.value = false
    fetchUsers()
  } catch (e) {
    console.error('Failed to save user:', e)
    toast.error(e.message || t('users.failedToSaveUser'))
  } finally {
    saving.value = false
  }
}

const getRoleGradient = (role) => {
  const gradients = {
    admin: 'from-purple-500 to-purple-600',
    manager: 'from-blue-500 to-blue-600',
    cashier: 'from-green-500 to-green-600',
    customer: 'from-pink-500 to-pink-600',
    delivery_staff: 'from-yellow-500 to-yellow-600',
    supplier: 'from-indigo-500 to-indigo-600'
  }
  return gradients[role] || 'from-gray-500 to-gray-600'
}

const getRoleBackground = (role) => {
  const backgrounds = {
    admin: 'bg-purple-50 border border-purple-200',
    manager: 'bg-blue-50 border border-blue-200',
    cashier: 'bg-green-50 border border-green-200',
    customer: 'bg-pink-50 border border-pink-200',
    delivery_staff: 'bg-yellow-50 border border-yellow-200',
    supplier: 'bg-indigo-50 border border-indigo-200'
  }
  return backgrounds[role] || 'bg-gray-50 border border-gray-200'
}

const getRoleTextColor = (role) => {
  const colors = {
    admin: 'text-purple-700',
    manager: 'text-blue-700',
    cashier: 'text-green-700',
    customer: 'text-pink-700',
    delivery_staff: 'text-yellow-700',
    supplier: 'text-indigo-700'
  }
  return colors[role] || 'text-gray-700'
}
const getRoleDescription = (role) => {
  const descriptions = {
    admin: t('users.fullSystemAccess'),
    manager: t('users.productsCustomers'),
    cashier: t('users.posAndSales'),
    customer: t('users.viewProducts'),
    delivery_staff: t('users.deliveryManagement'),
    supplier: t('users.purchaseOrders')
  }
  return descriptions[role] || t('users.viewProducts')
}

const getRoleSelectedClass = (role) => {
  const classes = {
    admin: 'border-purple-500 bg-purple-50',
    manager: 'border-blue-500 bg-blue-50',
    cashier: 'border-green-500 bg-green-50',
    customer: 'border-pink-500 bg-pink-50',
    delivery_staff: 'border-yellow-500 bg-yellow-50',
    supplier: 'border-indigo-500 bg-indigo-50'
  }
  return classes[role] || 'border-gray-500 bg-gray-50'
}

const exportUsers = () => {
  const csvContent = [
    [t('users.fullName'), t('auth.email'), t('users.role'), t('users.created')],
    ...users.value.map(user => [user.name, user.email, user.role, formatDate(user.created_at)])
  ].map(row => row.join(',')).join('\n')
  
  const blob = new Blob([csvContent], { type: 'text/csv' })
  const url = window.URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `users-${new Date().toISOString().split('T')[0]}.csv`
  a.click()
  window.URL.revokeObjectURL(url)
  toast.success(t('messages.exportSuccess'))
}

const deleteUser = async (id) => {
  if (!confirm(t('users.deleteUserConfirm'))) return
  try {
    await usersApi.delete(id)
    toast.success(t('users.userDeleted'))
    fetchUsers()
  } catch (e) {
    console.error('Failed to delete user:', e)
    toast.error(t('users.failedToDeleteUser'))
  }
}

onMounted(fetchUsers)
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

.loading-spinner {
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>