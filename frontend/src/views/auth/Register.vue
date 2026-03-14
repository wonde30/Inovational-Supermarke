<template>
  <div class="min-h-screen flex bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600 relative overflow-hidden">
    <!-- Theme and Language Controls - Top Right -->
    <div class="absolute top-4 right-4 z-50 flex items-center gap-2">
      <ThemeToggle />
      <LanguageSwitcher />
    </div>
    
    <!-- Beautiful Background Pattern -->
    <div class="absolute inset-0">
      <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.05%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-green-500/30 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
      <div class="absolute top-20 left-20 w-64 h-64 bg-green-400/20 rounded-full blur-2xl"></div>
      <div class="absolute bottom-20 right-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-2xl"></div>
    </div>

    <!-- Left Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative z-10">
      <div class="w-full max-w-lg">
        <div class="bg-white/10 backdrop-blur-xl p-7 rounded-3xl shadow-2xl border border-white/20">
          <!-- Mobile Logo -->
          <div class="lg:hidden text-center mb-4">
            <div class="relative w-16 h-16 mx-auto mb-2">
              <div class="absolute inset-0 bg-gradient-to-br from-green-400 via-emerald-400 to-teal-400 rounded-2xl blur-lg opacity-60"></div>
              <div class="relative w-full h-full bg-gradient-to-br from-green-400 via-emerald-400 to-teal-400 rounded-2xl flex items-center justify-center shadow-xl border-2 border-white/20">
                <span class="text-3xl">🏪</span>
              </div>
            </div>
            <h1 class="text-xl font-bold text-white drop-shadow-lg">Smart SuperMarket</h1>
          </div>

          <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-white mb-1">{{ t('auth.registerButton') }}</h2>
            <p class="text-green-200 text-sm">{{ t('auth.joinOurCommunity') }}</p>
          </div>

          <!-- Progress Indicator -->
          <div class="mb-4">
            <div class="flex justify-between mb-1">
              <span class="text-xs text-yellow-200 font-medium">Progress</span>
              <span class="text-xs text-yellow-200 font-bold">{{ registrationProgress }}%</span>
            </div>
            <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
              <div class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 h-1.5 rounded-full transition-all duration-500" :style="{ width: registrationProgress + '%' }"></div>
            </div>
          </div>

          <form @submit.prevent="handleRegister" class="space-y-3.5">
            <!-- Two Column Layout for Fields -->
            <div class="grid grid-cols-2 gap-3">
              <!-- Name -->
              <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-1.5">{{ t('auth.fullName') }} *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400">👤</span>
                  <input 
                    v-model="form.name" 
                    type="text" 
                    class="w-full bg-white/15 border-2 rounded-lg px-10 py-2.5 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all" 
                    :class="form.name ? 'border-green-400/50' : 'border-green-400/30'"
                    placeholder="Full Name" 
                    required 
                  />
                  <span v-if="form.name" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-400">✓</span>
                </div>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-1.5">{{ t('auth.email') }} *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400">📧</span>
                  <input 
                    v-model="form.email" 
                    type="email" 
                    @blur="validateEmail"
                    class="w-full bg-white/15 border-2 rounded-lg px-10 py-2.5 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all" 
                    :class="emailValid ? 'border-green-400/50' : 'border-green-400/30'"
                    placeholder="Email" 
                    required 
                  />
                  <span v-if="emailValid" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-400">✓</span>
                </div>
              </div>
            </div>

            <!-- Phone Number - Full Width -->
            <div>
              <label class="block text-sm font-semibold text-yellow-200 mb-1.5">📱 Phone Number *</label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400">📞</span>
                <input 
                  v-model="form.phone" 
                  type="tel" 
                  @blur="validatePhone"
                  class="w-full bg-white/15 border-2 rounded-lg px-10 py-2.5 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all" 
                  :class="phoneValid ? 'border-green-400/50' : 'border-green-400/30'"
                  placeholder="+251 911 123 456" 
                  required 
                />
                <span v-if="phoneValid" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-400">✓</span>
              </div>
              <p class="text-xs text-green-100 mt-1 ml-1">For order notifications & payment</p>
            </div>

            <!-- Password Fields in Two Columns -->
            <div class="grid grid-cols-2 gap-3">
              <!-- Password -->
              <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-1.5">{{ t('auth.password') }} *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400">🔒</span>
                  <input 
                    v-model="form.password" 
                    :type="showPassword ? 'text' : 'password'" 
                    @input="checkPasswordStrength"
                    class="w-full bg-white/15 border-2 rounded-lg px-10 py-2.5 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all" 
                    :class="passwordStrength > 0 ? 'border-green-400/50' : 'border-green-400/30'"
                    placeholder="Password" 
                    required 
                  />
                  <button 
                    type="button" 
                    @click="showPassword = !showPassword" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-yellow-400 hover:text-yellow-300 transition-colors"
                  >
                    {{ showPassword ? '👁️' : '👁️‍🗨️' }}
                  </button>
                </div>
              </div>

              <!-- Confirm Password -->
              <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-1.5">Confirm *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400">🔐</span>
                  <input 
                    v-model="form.password_confirmation" 
                    :type="showConfirmPassword ? 'text' : 'password'" 
                    class="w-full bg-white/15 border-2 rounded-lg px-10 py-2.5 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all" 
                    :class="passwordsMatch && form.password_confirmation ? 'border-green-400/50' : 'border-green-400/30'"
                    placeholder="Confirm" 
                    required 
                  />
                  <button 
                    type="button" 
                    @click="showConfirmPassword = !showConfirmPassword" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-yellow-400 hover:text-yellow-300 transition-colors"
                  >
                    {{ showConfirmPassword ? '👁️' : '👁️‍🗨️' }}
                  </button>
                </div>
              </div>
            </div>

            <!-- Password Strength Indicator -->
            <div v-if="form.password" class="flex gap-1">
              <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 1 ? 'bg-red-400' : 'bg-white/20'"></div>
              <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 2 ? 'bg-yellow-400' : 'bg-white/20'"></div>
              <div class="flex-1 h-1.5 rounded-full transition-all" :class="passwordStrength >= 3 ? 'bg-green-400' : 'bg-white/20'"></div>
            </div>

            <!-- Terms & Newsletter in Compact Style -->
            <div class="space-y-2">
              <label class="flex items-center gap-2 cursor-pointer group bg-white/10 rounded-lg p-2.5 border border-white/20 hover:bg-white/15 transition-all">
                <input 
                  v-model="acceptTerms" 
                  type="checkbox" 
                  class="w-4 h-4 text-green-600 border-2 border-white/30 rounded focus:ring-2 focus:ring-emerald-400 bg-white/20 flex-shrink-0" 
                  required 
                />
                <span class="text-sm text-yellow-100 group-hover:text-yellow-50 transition-colors">
                  I agree to <a href="#" class="text-green-300 hover:text-green-200 underline font-semibold">Terms</a> & <a href="#" class="text-green-300 hover:text-green-200 underline font-semibold">Privacy</a>
                </span>
              </label>

              <label class="flex items-center gap-2 cursor-pointer group bg-gradient-to-r from-green-500/20 to-emerald-500/20 rounded-lg p-2.5 border border-green-400/30 hover:from-green-500/30 hover:to-emerald-500/30 transition-all">
                <input 
                  v-model="subscribeNewsletter" 
                  type="checkbox" 
                  class="w-4 h-4 text-green-600 border-2 border-green-400/50 rounded focus:ring-2 focus:ring-emerald-400 bg-white/20 flex-shrink-0" 
                />
                <span class="text-sm text-white font-semibold group-hover:text-yellow-100 transition-colors">📬 Get exclusive deals & updates</span>
              </label>
            </div>

            <div v-if="error" class="bg-red-500/20 border border-red-500/50 rounded-lg p-2.5 text-red-300 flex items-center gap-2 text-sm animate-shake">
              <span>❌</span>
              <span>{{ error }}</span>
            </div>

            <button 
              type="submit" 
              :disabled="loading || !isFormValid" 
              class="group relative w-full bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-500 hover:via-emerald-500 hover:to-teal-500 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-xl shadow-green-500/30 transform hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none overflow-hidden"
            >
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
              <span v-if="loading" class="relative animate-spin">⏳</span>
              <span v-else class="relative">✓</span>
              <span class="relative">{{ loading ? t('auth.creating') : t('auth.register') }}</span>
            </button>

            <!-- Social Registration Divider -->
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/20"></div>
              </div>
              <div class="relative flex justify-center text-xs">
                <span class="px-3 bg-transparent text-yellow-200 font-medium">Or register with</span>
              </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-2 gap-3">
              <button 
                type="button" 
                @click="handleSocialLogin('facebook')"
                class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 border border-blue-500 text-white py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:scale-105 active:scale-95"
              >
                <span class="text-lg">📘</span>
                <span class="text-sm font-semibold">Facebook</span>
              </button>
              <button 
                type="button" 
                @click="handleSocialLogin('google')"
                class="flex items-center justify-center gap-2 bg-white hover:bg-gray-100 border border-gray-300 text-gray-800 py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:scale-105 active:scale-95"
              >
                <span class="text-lg">🔴</span>
                <span class="text-sm font-semibold">Google</span>
              </button>
            </div>
          </form>

          <div class="mt-4 text-center space-y-1.5">
            <p class="text-green-100 text-sm">
              {{ t('auth.alreadyHaveAccount') }} 
              <router-link to="/login" class="text-yellow-300 hover:text-yellow-200 font-semibold transition-colors">{{ t('auth.login') }}</router-link>
            </p>
            <router-link to="/store" class="block text-green-200 hover:text-green-100 text-sm font-medium transition-colors">
              ← {{ t('auth.backToStore') }}
            </router-link>
          </div>
        </div>
        
        <p class="text-center text-green-200 text-xs mt-3 font-medium">
          © {{ new Date().getFullYear() }} Smart SuperMarket
        </p>
      </div>
    </div>

    <!-- Right Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative z-10 flex-col justify-center items-center p-12">
      <div class="text-center">
        <div class="relative w-40 h-40 mx-auto mb-8">
          <div class="absolute inset-0 bg-gradient-to-br from-green-400 via-emerald-400 to-teal-400 rounded-3xl blur-xl opacity-60 animate-pulse"></div>
          <div class="relative w-full h-full bg-gradient-to-br from-green-400 via-emerald-400 to-teal-400 rounded-3xl flex items-center justify-center shadow-2xl shadow-green-500/40 transform hover:scale-105 transition-transform border-2 border-white/20">
            <span class="text-8xl">🏪</span>
          </div>
        </div>
        <h1 class="text-5xl font-black text-white mb-4 drop-shadow-lg">Smart SuperMarket</h1>
        <p class="text-xl text-green-100 mb-8">{{ t('auth.inventoryBilling') }}</p>
        
        <!-- Smart Flag Bar -->
        <div class="flex justify-center gap-2 mb-8">
          <div class="h-3 w-20 bg-green-400 rounded-l-full shadow-lg"></div>
          <div class="h-3 w-20 bg-yellow-400 shadow-lg"></div>
          <div class="h-3 w-20 bg-red-400 rounded-r-full shadow-lg"></div>
        </div>
        
        <!-- Benefits -->
        <div class="space-y-4 text-left max-w-md mx-auto">
          <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4">
            <span class="text-3xl">🎉</span>
            <div>
              <p class="text-white font-semibold">{{ t('auth.freeToJoin') }}</p>
              <p class="text-gray-300 text-sm">{{ t('auth.createAccountToday') }}</p>
            </div>
          </div>
          <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4">
            <span class="text-3xl">🛒</span>
            <div>
              <p class="text-white font-semibold">{{ t('auth.shopOnline') }}</p>
              <p class="text-gray-300 text-sm">{{ t('auth.browseProducts') }}</p>
            </div>
          </div>
          <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4">
            <span class="text-3xl">🚚</span>
            <div>
              <p class="text-white font-semibold">{{ t('auth.trackOrders') }}</p>
              <p class="text-gray-300 text-sm">{{ t('auth.realTimeUpdates') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { useRouter } from 'vue-router'
import { authApi } from '../../services/api'
import { useAuthStore } from '../../stores/auth'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'
import { useTranslation } from '@/composables/useTranslation'

const router = useRouter()
const auth = useAuthStore()
const { t } = useTranslation()

const form = reactive({ 
  name: '', 
  email: '', 
  phone: '',
  password: '', 
  password_confirmation: '' 
})

const error = ref('')
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const acceptTerms = ref(false)
const subscribeNewsletter = ref(true)

// Validation states
const emailValid = ref(false)
const phoneValid = ref(false)
const passwordStrength = ref(0)

// Computed properties
const passwordsMatch = computed(() => {
  return form.password && form.password_confirmation && form.password === form.password_confirmation
})

const registrationProgress = computed(() => {
  let progress = 0
  if (form.name) progress += 14
  if (emailValid.value) progress += 14
  if (phoneValid.value) progress += 14
  if (passwordStrength.value > 0) progress += 14
  if (passwordsMatch.value) progress += 14
  if (acceptTerms.value) progress += 15
  if (subscribeNewsletter.value) progress += 15
  return Math.min(progress, 100)
})

const passwordStrengthText = computed(() => {
  if (passwordStrength.value === 0) return 'Too weak'
  if (passwordStrength.value === 1) return 'Weak password'
  if (passwordStrength.value === 2) return 'Good password'
  return 'Strong password'
})

const passwordStrengthColor = computed(() => {
  if (passwordStrength.value === 0) return 'text-red-300'
  if (passwordStrength.value === 1) return 'text-red-300'
  if (passwordStrength.value === 2) return 'text-yellow-300'
  return 'text-green-300'
})

const isFormValid = computed(() => {
  return form.name && 
         emailValid.value && 
         phoneValid.value &&
         form.password.length >= 8 && 
         passwordsMatch.value && 
         acceptTerms.value
})

// Validation functions
const validateEmail = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  emailValid.value = emailRegex.test(form.email)
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
  const password = form.password
  let strength = 0
  
  if (password.length >= 8) strength++
  if (password.length >= 12) strength++
  if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++
  if (/\d/.test(password)) strength++
  if (/[^a-zA-Z0-9]/.test(password)) strength++
  
  passwordStrength.value = Math.min(Math.floor(strength / 2), 3)
}

const handleSocialLogin = async (provider) => {
  if (provider === 'google') {
    try {
      // Open Google OAuth in popup window
      const width = 500
      const height = 600
      const left = window.screen.width / 2 - width / 2
      const top = window.screen.height / 2 - height / 2
      
      const popup = window.open(
        `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}/api/v1/auth/google`,
        'Google Login',
        `width=${width},height=${height},left=${left},top=${top}`
      )
      
      // Listen for message from popup
      const messageHandler = async (event) => {
        // Only accept messages from our domain
        if (event.origin !== window.location.origin) return
        
        if (event.data.type === 'google-auth-success') {
          popup?.close()
          
          // Store token and user data
          const { token, user } = event.data
          auth.setToken(token)
          auth.setUser(user)
          
          // Remove event listener
          window.removeEventListener('message', messageHandler)
          
          // Redirect to store
          router.push('/store')
        } else if (event.data.type === 'google-auth-error') {
          popup?.close()
          error.value = event.data.message || 'Google authentication failed'
          
          // Remove event listener
          window.removeEventListener('message', messageHandler)
        }
      }
      
      window.addEventListener('message', messageHandler)
      
    } catch (e) {
      error.value = 'Failed to open Google login window'
    }
  } else if (provider === 'facebook') {
    error.value = 'Facebook login coming soon! Please use email registration for now.'
    setTimeout(() => {
      error.value = ''
    }, 3000)
  }
}

const handleRegister = async () => {
  error.value = ''
  
  if (!emailValid.value) {
    error.value = 'Please enter a valid email address'
    return
  }
  
  if (!phoneValid.value) {
    error.value = 'Please enter a valid Ethiopian phone number'
    return
  }
  
  if (form.password !== form.password_confirmation) {
    error.value = t('messages.passwordMismatch')
    return
  }
  
  if (form.password.length < 8) {
    error.value = t('messages.passwordTooShort')
    return
  }
  
  if (!acceptTerms.value) {
    error.value = 'Please accept the Terms & Conditions to continue'
    return
  }

  loading.value = true
  try {
    const registrationData = {
      ...form,
      subscribe_newsletter: subscribeNewsletter.value
    }
    
    const response = await authApi.register(registrationData)
    
    // Show success message and redirect to login
    router.push({
      path: '/login',
      query: { 
        registered: 'success',
        email: form.email 
      }
    })
  } catch (e) {
    error.value = e.message || t('messages.registrationFailed')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.animate-shake {
  animation: shake 0.3s ease-in-out;
}
</style>

