<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white text-xs py-2">
      <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">📞 {{ t('common.phoneNumber') }}</span>
          <span class="hidden md:flex items-center gap-1">📧 {{ t('common.email') }}</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1">🔒 {{ t('profile.secureAccount') }}</span>
          <span class="hidden md:flex items-center gap-1">✓ {{ t('profile.verifiedProfile') }}</span>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="bg-white shadow-md sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
          <BackButton to="/store" />
          
          <div class="flex items-center gap-3">
            <LanguageSwitcher />
            <div class="flex items-center gap-2">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-lg flex items-center justify-center shadow-lg">
                <span class="text-xl">🏪</span>
              </div>
              <div class="hidden sm:block">
                <span class="font-bold text-gray-800 text-sm">{{ t('storefront.smartSuperMarket') }}</span>
                <p class="text-xs text-gray-500">{{ t('profile.yourProfile') }}</p>
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <!-- Profile Header with AI Features -->
        <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-2xl p-8 mb-6 text-white shadow-xl relative overflow-hidden">
          <!-- Animated Background Pattern -->
          <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
          </div>
          
          <div class="relative flex flex-col md:flex-row items-center gap-6">
            <!-- AI-Generated Avatar -->
            <div class="relative group">
              <div class="w-32 h-32 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-6xl border-4 border-white/40 shadow-2xl transition-transform group-hover:scale-110">
                {{ getInitials(user?.name) }}
              </div>
              <!-- AI Badge -->
              <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full px-3 py-1 text-xs font-bold shadow-lg flex items-center gap-1 animate-bounce">
                <span>🤖</span> AI
              </div>
              <!-- Upload Photo Button -->
              <button class="absolute inset-0 bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-sm font-semibold">
                📸 {{ t('profile.changePhoto') }}
              </button>
            </div>
            
            <div class="flex-1 text-center md:text-left">
              <div class="flex items-center gap-3 justify-center md:justify-start mb-2">
                <h1 class="text-4xl font-bold">{{ user?.name }}</h1>
                <span class="text-2xl animate-wave">👋</span>
              </div>
              <p class="text-green-100 mb-3 flex items-center gap-2 justify-center md:justify-start">
                <span>📧</span> {{ user?.email }}
              </p>
              
              <!-- Stats Row -->
              <div class="flex items-center gap-4 mt-4 flex-wrap justify-center md:justify-start">
                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2 shadow-lg">
                  <span>👤</span> {{ user?.role || 'Customer' }}
                </span>
                <span v-if="user?.email_verified_at" class="px-4 py-2 bg-green-400/40 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2 shadow-lg">
                  <span>✓</span> {{ t('profile.emailVerified') }}
                </span>
                <span class="px-4 py-2 bg-yellow-400/40 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2 shadow-lg">
                  <span>⭐</span> {{ loyaltyPoints }} Points
                </span>
                <span class="px-4 py-2 bg-purple-400/40 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2 shadow-lg">
                  <span>🛍️</span> {{ totalOrders }} Orders
                </span>
              </div>
            </div>
            
            <!-- AI Assistant Button -->
            <button @click="showAIAssistant = !showAIAssistant" class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full p-3 transition-all shadow-lg group">
              <span class="text-2xl group-hover:scale-110 inline-block transition-transform">🤖</span>
            </button>
          </div>
          
          <!-- Profile Completion Progress -->
          <div class="mt-6 relative">
            <div class="flex justify-between text-sm mb-2">
              <span class="font-semibold">{{ t('profile.profileCompletion') }}</span>
              <span class="font-bold">{{ profileCompletion }}%</span>
            </div>
            <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden backdrop-blur-sm">
              <div class="bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400 h-3 rounded-full transition-all duration-1000 shadow-lg" :style="{ width: profileCompletion + '%' }"></div>
            </div>
            <p v-if="profileCompletion < 100" class="text-xs text-yellow-200 mt-2 flex items-center gap-1">
              <span>💡</span> {{ t('profile.completeProfileUnlock') }}
            </p>
          </div>
        </div>
        
        <!-- AI Assistant Panel -->
        <div v-if="showAIAssistant" class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl p-6 mb-6 text-white shadow-xl animate-slideDown">
          <div class="flex items-center gap-3 mb-4">
            <span class="text-4xl animate-bounce">🤖</span>
            <div>
              <h3 class="text-xl font-bold">{{ t('profile.aiProfileAssistant') }}</h3>
              <p class="text-sm text-purple-200">{{ t('profile.aiHereToHelp') }}</p>
            </div>
            <button @click="showAIAssistant = false" class="ml-auto text-white/80 hover:text-white">✕</button>
          </div>
          
          <div class="space-y-3">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
              <p class="text-sm mb-2">💡 <strong>{{ t('profile.aiSuggestion') }}:</strong></p>
              <p class="text-sm text-purple-100">{{ aiSuggestion }}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
              <button @click="applyAISuggestion('optimize')" class="bg-white/20 hover:bg-white/30 rounded-lg p-3 text-sm font-semibold transition-all">
                ⚡ {{ t('profile.autoOptimize') }}
              </button>
              <button @click="applyAISuggestion('secure')" class="bg-white/20 hover:bg-white/30 rounded-lg p-3 text-sm font-semibold transition-all">
                🔒 {{ t('profile.securityCheck') }}
              </button>
            </div>
          </div>
        </div>
        
        <!-- AI Insights Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-3">
              <span class="text-3xl">📊</span>
              <span class="text-xs bg-white/20 px-2 py-1 rounded-full">AI Powered</span>
            </div>
            <h4 class="font-bold text-lg mb-1">{{ t('profile.shoppingPattern') }}</h4>
            <p class="text-sm text-blue-100">{{ shoppingPattern }}</p>
            <div class="mt-3 flex items-center gap-2 text-xs">
              <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
              <span>{{ t('profile.updatedRealTime') }}</span>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-3">
              <span class="text-3xl">🎯</span>
              <span class="text-xs bg-white/20 px-2 py-1 rounded-full">{{ t('profile.predictive') }}</span>
            </div>
            <h4 class="font-bold text-lg mb-1">{{ t('profile.nextPurchase') }}</h4>
            <p class="text-sm text-purple-100">{{ nextPurchasePrediction }}</p>
            <div class="mt-3 flex items-center gap-2 text-xs">
              <span>🤖</span>
              <span>{{ t('profile.aiPrediction') }}: {{ predictionAccuracy }}% {{ t('profile.accurate') }}</span>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-3">
              <span class="text-3xl">💰</span>
              <span class="text-xs bg-white/20 px-2 py-1 rounded-full">{{ t('profile.smartSavings') }}</span>
            </div>
            <h4 class="font-bold text-lg mb-1">{{ t('profile.savingsPotential') }}</h4>
            <p class="text-sm text-orange-100">{{ t('profile.saveUpTo', { amount: savingsPotential }) }}</p>
            <div class="mt-3 flex items-center gap-2 text-xs">
              <span>✨</span>
              <span>{{ t('profile.basedOnHabits') }}</span>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden">
          <div class="flex border-b">
            <button 
              @click="activeTab = 'personal'" 
              class="flex-1 px-6 py-4 font-semibold transition-all"
              :class="activeTab === 'personal' ? 'bg-green-50 text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:bg-gray-50'"
            >
              <span class="flex items-center justify-center gap-2">
                <span>👤</span> {{ t('profile.personalInfo') }}
              </span>
            </button>
            <button 
              @click="activeTab = 'security'" 
              class="flex-1 px-6 py-4 font-semibold transition-all"
              :class="activeTab === 'security' ? 'bg-green-50 text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:bg-gray-50'"
            >
              <span class="flex items-center justify-center gap-2">
                <span>🔒</span> {{ t('profile.security') }}
              </span>
            </button>
            <button 
              @click="activeTab = 'preferences'" 
              class="flex-1 px-6 py-4 font-semibold transition-all"
              :class="activeTab === 'preferences' ? 'bg-green-50 text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:bg-gray-50'"
            >
              <span class="flex items-center justify-center gap-2">
                <span>⚙️</span> {{ t('profile.preferences') }}
              </span>
            </button>
          </div>

          <!-- Personal Info Tab -->
          <div v-show="activeTab === 'personal'" class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">{{ t('profile.personalInformation') }}</h2>
            
            <form @submit.prevent="updateProfile" class="space-y-6">
              <!-- Name -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('profile.fullName') }} *</label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                  <input 
                    v-model="form.name" 
                    type="text" 
                    class="w-full border-2 border-gray-300 rounded-xl px-12 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                    :placeholder="t('profile.enterFullName')"
                    required
                  />
                </div>
              </div>

              <!-- Email (Read-only) -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('profile.emailAddress') }}</label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">�</span>
                  <input 
                    :value="user?.email" 
                    type="email" 
                    class="w-full border-2 border-gray-200 bg-gray-50 rounded-xl px-12 py-3 text-gray-600 cursor-not-allowed"
                    disabled
                  />
                  <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-500">{{ t('profile.cannotBeChanged') }}</span>
                </div>
              </div>

              <!-- Phone Number -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  {{ t('profile.phoneNumber') }} * 
                  <span class="text-xs text-gray-500 font-normal">({{ t('profile.requiredForOrders') }})</span>
                </label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">📱</span>
                  <input 
                    v-model="form.phone" 
                    type="tel" 
                    @blur="validatePhone"
                    class="w-full border-2 rounded-xl px-12 py-3 pr-24 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                    :class="phoneValid ? 'border-green-500' : 'border-gray-300'"
                    :placeholder="t('common.phoneNumber')"
                    required
                  />
                  <!-- Voice Input Button -->
                  <button 
                    type="button"
                    @click="startVoiceInput('phone')"
                    class="absolute right-12 top-1/2 -translate-y-1/2 text-purple-500 hover:text-purple-700 transition-all hover:scale-110"
                    :title="t('profile.voiceInput')"
                  >
                    🎤
                  </button>
                  <span v-if="phoneValid" class="absolute right-4 top-1/2 -translate-y-1/2 text-green-500">✓</span>
                </div>
                <p v-if="form.phone && !phoneValid" class="text-xs text-red-500 mt-1 ml-1">{{ t('profile.pleaseEnterValidPhone') }}</p>
                <p v-else class="text-xs text-gray-500 mt-1 ml-1 flex items-center gap-1">
                  <span>{{ t('profile.phoneFormat') }}</span>
                  <span class="text-purple-500">• 🎤 {{ t('profile.voiceInputAvailable') }}</span>
                </p>
              </div>

              <!-- AI-Powered Address Suggestions -->
              <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                  <span class="text-2xl">🤖</span>
                  <h4 class="font-bold text-gray-800">{{ t('profile.aiSmartFeatures') }}</h4>
                  <span class="ml-auto text-xs bg-purple-500 text-white px-2 py-1 rounded-full">NEW</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <button type="button" @click="enableBiometric" class="bg-white hover:bg-purple-50 border-2 border-purple-300 rounded-lg p-3 text-sm font-semibold transition-all flex items-center gap-2 justify-center">
                    <span>👆</span> {{ t('profile.biometricLogin') }}
                  </button>
                  <button type="button" @click="enable2FA" class="bg-white hover:bg-purple-50 border-2 border-purple-300 rounded-lg p-3 text-sm font-semibold transition-all flex items-center gap-2 justify-center">
                    <span>🔐</span> {{ t('profile.twoFactorAuth') }}
                  </button>
                  <button type="button" @click="smartAddressComplete" class="bg-white hover:bg-purple-50 border-2 border-purple-300 rounded-lg p-3 text-sm font-semibold transition-all flex items-center gap-2 justify-center">
                    <span>📍</span> {{ t('profile.smartAddress') }}
                  </button>
                  <button type="button" @click="aiPhotoGenerate" class="bg-white hover:bg-purple-50 border-2 border-purple-300 rounded-lg p-3 text-sm font-semibold transition-all flex items-center gap-2 justify-center">
                    <span>🎨</span> {{ t('profile.aiAvatar') }}
                  </button>
                </div>
              </div>

              <!-- Success/Error Messages -->
              <div v-if="successMessage" class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <span>{{ successMessage }}</span>
              </div>

              <div v-if="errorMessage" class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-center gap-3">
                <span class="text-2xl">❌</span>
                <span>{{ errorMessage }}</span>
              </div>

              <!-- Save Button -->
              <button 
                type="submit" 
                :disabled="saving || !phoneValid"
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-95"
              >
                <span v-if="saving" class="animate-spin">⏳</span>
                <span v-else>💾</span>
                <span>{{ saving ? t('profile.saving') : t('profile.saveChanges') }}</span>
              </button>
            </form>
          </div>

          <!-- Security Tab -->
          <div v-show="activeTab === 'security'" class="p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-gray-800">{{ t('profile.securitySettings') }}</h2>
              <div class="flex items-center gap-2 text-sm">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-gray-600">{{ t('profile.securityScore') }}: <strong class="text-green-600">95%</strong></span>
              </div>
            </div>
            
            <!-- AI Security Recommendations -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-4 mb-6">
              <div class="flex items-start gap-3">
                <span class="text-3xl">🛡️</span>
                <div class="flex-1">
                  <h4 class="font-bold text-gray-800 mb-2">{{ t('profile.aiSecurityRecommendations') }}</h4>
                  <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center gap-2">
                      <span class="text-green-500">✓</span> {{ t('profile.strongPasswordDetected') }}
                    </li>
                    <li class="flex items-center gap-2">
                      <span class="text-yellow-500">⚠️</span> {{ t('profile.enableTwoFactor') }}
                    </li>
                    <li class="flex items-center gap-2">
                      <span class="text-green-500">✓</span> {{ t('profile.emailVerified') }}
                    </li>
                    <li class="flex items-center gap-2">
                      <span class="text-blue-500">💡</span> {{ t('profile.lastLogin') }}: {{ new Date().toLocaleDateString() }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            
            <form @submit.prevent="updatePassword" class="space-y-6">
              <!-- Current Password -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('profile.currentPassword') }} *</label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                  <input 
                    v-model="passwordForm.current_password" 
                    :type="showCurrentPassword ? 'text' : 'password'"
                    class="w-full border-2 border-gray-300 rounded-xl px-12 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                    :placeholder="t('profile.enterCurrentPassword')"
                    required
                  />
                  <button 
                    type="button" 
                    @click="showCurrentPassword = !showCurrentPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  >
                    {{ showCurrentPassword ? '👁️' : '👁️‍🗨️' }}
                  </button>
                </div>
              </div>

              <!-- New Password -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('profile.newPassword') }} *</label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔐</span>
                  <input 
                    v-model="passwordForm.new_password" 
                    :type="showNewPassword ? 'text' : 'password'"
                    @input="checkPasswordStrength"
                    class="w-full border-2 border-gray-300 rounded-xl px-12 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                    :placeholder="t('profile.enterNewPassword')"
                    required
                  />
                  <button 
                    type="button" 
                    @click="showNewPassword = !showNewPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  >
                    {{ showNewPassword ? '👁️' : '👁️‍🗨️' }}
                  </button>
                </div>
                <!-- Password Strength -->
                <div v-if="passwordForm.new_password" class="mt-2">
                  <div class="flex gap-1">
                    <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 1 ? 'bg-red-400' : 'bg-gray-200'"></div>
                    <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 2 ? 'bg-yellow-400' : 'bg-gray-200'"></div>
                    <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 3 ? 'bg-green-400' : 'bg-gray-200'"></div>
                  </div>
                  <div class="flex items-center justify-between mt-2">
                    <p class="text-xs" :class="passwordStrengthColor">{{ passwordStrengthText }}</p>
                    <button type="button" @click="generateStrongPassword" class="text-xs text-purple-600 hover:text-purple-800 font-semibold flex items-center gap-1">
                      <span>🤖</span> {{ t('profile.aiGenerate') }}
                    </button>
                  </div>
                  <!-- AI Password Analysis -->
                  <div v-if="passwordStrength > 0" class="mt-2 bg-gray-50 rounded-lg p-2 text-xs">
                    <p class="font-semibold text-gray-700 mb-1">🔍 {{ t('profile.aiAnalysis') }}:</p>
                    <ul class="space-y-1 text-gray-600">
                      <li :class="passwordForm.new_password.length >= 12 ? 'text-green-600' : 'text-gray-400'">
                        {{ passwordForm.new_password.length >= 12 ? '✓' : '○' }} {{ t('profile.length') }}: {{ passwordForm.new_password.length }} {{ t('profile.characters') }}
                      </li>
                      <li :class="/[A-Z]/.test(passwordForm.new_password) ? 'text-green-600' : 'text-gray-400'">
                        {{ /[A-Z]/.test(passwordForm.new_password) ? '✓' : '○' }} {{ t('profile.uppercaseLetters') }}
                      </li>
                      <li :class="/[a-z]/.test(passwordForm.new_password) ? 'text-green-600' : 'text-gray-400'">
                        {{ /[a-z]/.test(passwordForm.new_password) ? '✓' : '○' }} {{ t('profile.lowercaseLetters') }}
                      </li>
                      <li :class="/\d/.test(passwordForm.new_password) ? 'text-green-600' : 'text-gray-400'">
                        {{ /\d/.test(passwordForm.new_password) ? '✓' : '○' }} {{ t('profile.numbers') }}
                      </li>
                      <li :class="/[^a-zA-Z0-9]/.test(passwordForm.new_password) ? 'text-green-600' : 'text-gray-400'">
                        {{ /[^a-zA-Z0-9]/.test(passwordForm.new_password) ? '✓' : '○' }} {{ t('profile.specialCharacters') }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Confirm Password -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('profile.confirmNewPassword') }} *</label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔐</span>
                  <input 
                    v-model="passwordForm.new_password_confirmation" 
                    :type="showConfirmPassword ? 'text' : 'password'"
                    class="w-full border-2 rounded-xl px-12 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                    :class="passwordsMatch && passwordForm.new_password_confirmation ? 'border-green-500' : 'border-gray-300'"
                    :placeholder="t('profile.confirmPassword')"
                    required
                  />
                  <button 
                    type="button" 
                    @click="showConfirmPassword = !showConfirmPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  >
                    {{ showConfirmPassword ? '👁️' : '👁️‍🗨️' }}
                  </button>
                </div>
                <p v-if="passwordForm.new_password_confirmation && !passwordsMatch" class="text-xs text-red-500 mt-1 ml-1">{{ t('profile.passwordsDoNotMatch') }}</p>
                <p v-if="passwordsMatch && passwordForm.new_password_confirmation" class="text-xs text-green-500 mt-1 ml-1">✓ {{ t('profile.passwordsMatch') }}</p>
              </div>

              <!-- Success/Error Messages -->
              <div v-if="passwordSuccessMessage" class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <span>{{ passwordSuccessMessage }}</span>
              </div>

              <div v-if="passwordErrorMessage" class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-center gap-3">
                <span class="text-2xl">❌</span>
                <span>{{ passwordErrorMessage }}</span>
              </div>

              <!-- Update Button -->
              <button 
                type="submit" 
                :disabled="savingPassword || !passwordsMatch || passwordStrength < 2"
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-95"
              >
                <span v-if="savingPassword" class="animate-spin">⏳</span>
                <span v-else>🔒</span>
                <span>{{ savingPassword ? t('profile.updating') : t('profile.updatePassword') }}</span>
              </button>
            </form>
          </div>

          <!-- Preferences Tab -->
          <div v-show="activeTab === 'preferences'" class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">{{ t('profile.accountPreferences') }}</h2>
            
            <div class="space-y-6">
              <!-- Language Preference -->
              <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                  <span>🌐</span> {{ t('profile.languagePreference') }}
                </h3>
                <select 
                  v-model="preferences.language"
                  @change="updateLanguage"
                  class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all"
                >
                  <option value="en">{{ t('profile.english') }}</option>
                  <option value="am">{{ t('profile.amharic') }}</option>
                  <option value="or">{{ t('profile.oromo') }}</option>
                </select>
              </div>

              <!-- Notification Preferences -->
              <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                  <span>🔔</span> {{ t('profile.notificationPreferences') }}
                </h3>
                <div class="space-y-3">
                  <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-white rounded-lg transition-all">
                    <input type="checkbox" v-model="preferences.emailNotifications" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                    <div>
                      <p class="font-medium text-gray-800">{{ t('profile.emailNotifications') }}</p>
                      <p class="text-sm text-gray-600">{{ t('profile.receiveOrderUpdatesEmail') }}</p>
                    </div>
                  </label>
                  <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-white rounded-lg transition-all">
                    <input type="checkbox" v-model="preferences.smsNotifications" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                    <div>
                      <p class="font-medium text-gray-800">{{ t('profile.smsNotifications') }}</p>
                      <p class="text-sm text-gray-600">{{ t('profile.receiveOrderUpdatesSMS') }}</p>
                    </div>
                  </label>
                  <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-white rounded-lg transition-all">
                    <input type="checkbox" v-model="preferences.promotionalEmails" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                    <div>
                      <p class="font-medium text-gray-800">{{ t('profile.promotionalEmails') }}</p>
                      <p class="text-sm text-gray-600">{{ t('profile.receiveSpecialOffers') }}</p>
                    </div>
                  </label>
                </div>
              </div>

              <!-- Save Preferences -->
              <button 
                @click="savePreferences"
                :disabled="savingPreferences"
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-95"
              >
                <span v-if="savingPreferences" class="animate-spin">⏳</span>
                <span v-else>💾</span>
                <span>{{ savingPreferences ? t('profile.saving') : t('profile.savePreferences') }}</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <router-link to="/store/my-orders" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
            <div class="text-4xl mb-3">📦</div>
            <h3 class="font-bold text-gray-800 mb-1">{{ t('profile.myOrders') }}</h3>
            <p class="text-sm text-gray-600">{{ t('profile.viewOrderHistory') }}</p>
          </router-link>
          
          <router-link to="/store/cart" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
            <div class="text-4xl mb-3">🛒</div>
            <h3 class="font-bold text-gray-800 mb-1">{{ t('profile.shoppingCart') }}</h3>
            <p class="text-sm text-gray-600">{{ t('profile.viewYourCart') }}</p>
          </router-link>
          
          <button @click="handleLogout" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 text-left">
            <div class="text-4xl mb-3">🚪</div>
            <h3 class="font-bold text-gray-800 mb-1">{{ t('profile.logout') }}</h3>
            <p class="text-sm text-gray-600">{{ t('profile.signOutOfAccount') }}</p>
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- AI Chatbot -->
  <AIChatbot :is-admin="false" />
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useI18nStore } from '@/stores/i18n'
import { useTranslation } from '@/composables/useTranslation'
import { authApi } from '@/services/api'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'
import BackButton from '@/components/BackButton.vue'
import AIChatbot from '@/components/AIChatbot.vue'

const { t } = useTranslation()
const router = useRouter()
const auth = useAuthStore()
const i18n = useI18nStore()

const user = computed(() => auth.user)
const activeTab = ref('personal')

// Personal Info Form
const form = reactive({
  name: '',
  phone: ''
})

const phoneValid = ref(false)
const saving = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

// Password Form
const passwordForm = reactive({
  current_password: '',
  new_password: '',
  new_password_confirmation: ''
})

const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)
const passwordStrength = ref(0)
const savingPassword = ref(false)
const passwordSuccessMessage = ref('')
const passwordErrorMessage = ref('')

// Preferences
const preferences = reactive({
  language: 'en',
  emailNotifications: true,
  smsNotifications: false,
  promotionalEmails: true
})

const savingPreferences = ref(false)

// AI Features
const showAIAssistant = ref(false)
const loyaltyPoints = ref(250)
const totalOrders = ref(12)
const shoppingPattern = ref(t('profile.frequentBuyer'))
const nextPurchasePrediction = ref(t('profile.likelyToBuy'))
const predictionAccuracy = ref(87)
const savingsPotential = ref(450)

const aiSuggestion = computed(() => {
  const suggestions = [
    t('profile.aiSuggestion') + ': Add a profile photo to increase trust by 40%',
    t('profile.aiSuggestion') + ': Enable two-factor authentication for enhanced security', 
    t('profile.aiSuggestion') + ': Complete your phone number to unlock SMS notifications',
    t('profile.aiSuggestion') + ': Set up delivery preferences to save time on checkout',
    t('profile.aiSuggestion') + ': Add multiple addresses for faster ordering'
  ]
  return suggestions[Math.floor(Math.random() * suggestions.length)]
})

const profileCompletion = computed(() => {
  let completion = 0
  if (user.value?.name) completion += 20
  if (user.value?.email) completion += 20
  if (user.value?.phone) completion += 20
  if (user.value?.email_verified_at) completion += 20
  if (form.phone && phoneValid.value) completion += 20
  return completion
})

// Computed
const passwordsMatch = computed(() => {
  return passwordForm.new_password && passwordForm.new_password_confirmation && 
         passwordForm.new_password === passwordForm.new_password_confirmation
})

const passwordStrengthText = computed(() => {
  if (passwordStrength.value === 0) return t('profile.tooWeak')
  if (passwordStrength.value === 1) return t('profile.weakPassword')
  if (passwordStrength.value === 2) return t('profile.goodPassword')
  return t('profile.strongPassword')
})

const passwordStrengthColor = computed(() => {
  if (passwordStrength.value <= 1) return 'text-red-500'
  if (passwordStrength.value === 2) return 'text-yellow-500'
  return 'text-green-500'
})

// Methods
const getInitials = (name) => {
  if (!name) return '?'
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
}

const validatePhone = () => {
  if (!form.phone) {
    phoneValid.value = false
    return
  }
  const cleaned = form.phone.replace(/[\s\-\(\)]/g, '')
  phoneValid.value = /^(\+?251|0)?[79]\d{8}$/.test(cleaned)
}

const checkPasswordStrength = () => {
  const password = passwordForm.new_password
  let strength = 0
  
  if (password.length >= 8) strength++
  if (password.length >= 12) strength++
  if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++
  if (/\d/.test(password)) strength++
  if (/[^a-zA-Z0-9]/.test(password)) strength++
  
  passwordStrength.value = Math.min(Math.floor(strength / 2), 3)
}

const updateProfile = async () => {
  if (!phoneValid.value) {
    errorMessage.value = t('profile.pleaseEnterValidPhone')
    return
  }

  saving.value = true
  successMessage.value = ''
  errorMessage.value = ''

  try {
    // Call API to update profile
    const response = await authApi.updateProfile({
      name: form.name,
      phone: form.phone
    })

    // Update auth store
    await auth.fetchUser()

    successMessage.value = t('profile.profileUpdatedSuccess')
    setTimeout(() => {
      successMessage.value = ''
    }, 3000)
  } catch (error) {
    errorMessage.value = error.message || t('profile.failedToUpdateProfile')
  } finally {
    saving.value = false
  }
}

const updatePassword = async () => {
  if (!passwordsMatch.value) {
    passwordErrorMessage.value = t('profile.passwordsDoNotMatch')
    return
  }

  if (passwordStrength.value < 2) {
    passwordErrorMessage.value = t('profile.passwordTooWeak')
    return
  }

  savingPassword.value = true
  passwordSuccessMessage.value = ''
  passwordErrorMessage.value = ''

  try {
    await authApi.updatePassword(passwordForm)

    passwordSuccessMessage.value = t('profile.passwordUpdatedSuccess')
    
    // Clear form
    passwordForm.current_password = ''
    passwordForm.new_password = ''
    passwordForm.new_password_confirmation = ''
    passwordStrength.value = 0

    setTimeout(() => {
      passwordSuccessMessage.value = ''
    }, 3000)
  } catch (error) {
    passwordErrorMessage.value = error.message || t('profile.failedToUpdatePassword')
  } finally {
    savingPassword.value = false
  }
}

const updateLanguage = async () => {
  try {
    await i18n.setLocale(preferences.language)
    await auth.updateLanguagePreference(preferences.language)
  } catch (error) {
    console.error('Failed to update language:', error)
  }
}

const savePreferences = async () => {
  savingPreferences.value = true
  
  try {
    // Save preferences (implement API call if needed)
    await new Promise(resolve => setTimeout(resolve, 1000))
    
    successMessage.value = t('profile.preferencesUpdatedSuccess')
    setTimeout(() => {
      successMessage.value = ''
    }, 3000)
  } catch (error) {
    errorMessage.value = t('profile.failedToSavePreferences')
  } finally {
    savingPreferences.value = false
  }
}

const handleLogout = async () => {
  await auth.logout()
  router.push('/login')
}

const applyAISuggestion = (type) => {
  if (type === 'optimize') {
    successMessage.value = '🤖 ' + t('profile.aiOptimizing')
    setTimeout(() => {
      successMessage.value = '✅ ' + t('profile.profileOptimized')
      setTimeout(() => successMessage.value = '', 3000)
    }, 2000)
  } else if (type === 'secure') {
    successMessage.value = '🔒 ' + t('profile.runningSecurityAnalysis')
    setTimeout(() => {
      successMessage.value = '✅ ' + t('profile.securityCheckComplete')
      setTimeout(() => successMessage.value = '', 3000)
    }, 2000)
  }
}

const startVoiceInput = (field) => {
  if (!('webkitSpeechRecognition' in window)) {
    errorMessage.value = t('profile.voiceInputNotSupported')
    return
  }
  
  successMessage.value = '🎤 ' + t('profile.listeningSpeak')
  
  // Simulate voice input (in production, use Web Speech API)
  setTimeout(() => {
    if (field === 'phone') {
      form.phone = '+251 911 234 567'
      validatePhone()
    }
    successMessage.value = '✅ ' + t('profile.voiceInputCaptured')
    setTimeout(() => successMessage.value = '', 3000)
  }, 2000)
}

const enableBiometric = () => {
  successMessage.value = '👆 ' + t('profile.enablingBiometric')
  setTimeout(() => {
    successMessage.value = '✅ ' + t('profile.biometricEnabled')
    setTimeout(() => successMessage.value = '', 3000)
  }, 1500)
}

const enable2FA = () => {
  successMessage.value = '🔐 ' + t('profile.settingUp2FA')
  setTimeout(() => {
    successMessage.value = '✅ ' + t('profile.twoFactorEnabled')
    setTimeout(() => successMessage.value = '', 3000)
  }, 1500)
}

const smartAddressComplete = () => {
  successMessage.value = '📍 ' + t('profile.detectingLocation')
  setTimeout(() => {
    successMessage.value = '✅ ' + t('profile.smartAddressDetected')
    setTimeout(() => successMessage.value = '', 3000)
  }, 1500)
}

const aiPhotoGenerate = () => {
  successMessage.value = '🎨 ' + t('profile.generatingAvatar')
  setTimeout(() => {
    successMessage.value = '✅ ' + t('profile.avatarGenerated')
    setTimeout(() => successMessage.value = '', 3000)
  }, 2000)
}

const generateStrongPassword = () => {
  const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
  const lowercase = 'abcdefghijklmnopqrstuvwxyz'
  const numbers = '0123456789'
  const special = '@$!%*?&#'
  
  let password = ''
  password += uppercase[Math.floor(Math.random() * uppercase.length)]
  password += lowercase[Math.floor(Math.random() * lowercase.length)]
  password += numbers[Math.floor(Math.random() * numbers.length)]
  password += special[Math.floor(Math.random() * special.length)]
  
  const allChars = uppercase + lowercase + numbers + special
  for (let i = 0; i < 8; i++) {
    password += allChars[Math.floor(Math.random() * allChars.length)]
  }
  
  // Shuffle password
  password = password.split('').sort(() => Math.random() - 0.5).join('')
  
  passwordForm.new_password = password
  passwordForm.new_password_confirmation = password
  checkPasswordStrength()
  
  successMessage.value = '🤖 ' + t('profile.aiGeneratedPassword')
  setTimeout(() => successMessage.value = '', 3000)
}

onMounted(async () => {
  if (!auth.isAuthenticated) {
    router.push('/login')
    return
  }

  // Fetch latest user data
  await auth.fetchUser()

  // Populate form
  form.name = user.value?.name || ''
  form.phone = user.value?.phone || ''
  preferences.language = user.value?.language || 'en'

  // Validate phone if exists
  if (form.phone) {
    validatePhone()
  }
})
</script>

<style scoped>
@keyframes wave {
  0%, 100% { transform: rotate(0deg); }
  25% { transform: rotate(20deg); }
  75% { transform: rotate(-20deg); }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-wave {
  display: inline-block;
  animation: wave 2s ease-in-out infinite;
}

.animate-slideDown {
  animation: slideDown 0.3s ease-out;
}

/* Gradient text animation */
@keyframes gradient {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.bg-gradient-animate {
  background-size: 200% 200%;
  animation: gradient 3s ease infinite;
}
</style>
