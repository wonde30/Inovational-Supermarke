<template>
  <div class="min-h-screen flex relative overflow-hidden transition-colors duration-300" :class="isDark ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900' : 'bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50'">
    <!-- Theme and Language Controls - Top Right -->
    <div class="absolute top-4 right-4 z-50 flex items-center gap-2">
      <ThemeToggle />
      <LanguageSwitcher />
    </div>
    
    <!-- Decorative Background -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full blur-3xl transition-colors animate-pulse" :class="isDark ? 'bg-green-900/30' : 'bg-green-300/40'"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full blur-3xl transition-colors animate-pulse" :class="isDark ? 'bg-emerald-900/30' : 'bg-emerald-300/40'" style="animation-delay: 1s"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full blur-3xl transition-colors animate-pulse" :class="isDark ? 'bg-teal-900/20' : 'bg-teal-200/30'" style="animation-delay: 2s"></div>
    </div>

    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative z-10 flex-col justify-center items-center p-12 transition-colors" :class="isDark ? 'bg-gradient-to-br from-green-800 via-emerald-800 to-teal-800' : 'bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600'">
      <div class="text-center max-w-md">
        <div class="relative w-32 h-32 mx-auto mb-8">
          <div class="absolute inset-0 bg-gradient-to-br from-green-400 via-emerald-400 to-teal-400 rounded-3xl blur-xl opacity-60 animate-pulse"></div>
          <div class="relative w-full h-full bg-white/10 backdrop-blur-lg rounded-3xl flex items-center justify-center shadow-2xl border-2 border-white/20">
            <span class="text-7xl">🏪</span>
          </div>
        </div>
        <h1 class="text-5xl font-black text-white mb-4 drop-shadow-lg">Smart SuperMarket</h1>
        <p class="text-xl text-green-100 mb-8">{{ t('auth.modernInventory') }}</p>
        
        <!-- Features -->
        <div class="space-y-4 text-left">
          <div class="group flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all hover:scale-105">
            <div class="relative w-12 h-12 flex-shrink-0">
              <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-400 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
              <div class="relative w-full h-full bg-white/20 rounded-xl flex items-center justify-center">
                <span class="text-2xl">📦</span>
              </div>
            </div>
            <div>
              <p class="text-white font-semibold">{{ t('auth.smartInventory') }}</p>
              <p class="text-green-100 text-sm">{{ t('auth.realTimeTracking') }}</p>
            </div>
          </div>
          <div class="group flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all hover:scale-105">
            <div class="relative w-12 h-12 flex-shrink-0">
              <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
              <div class="relative w-full h-full bg-white/20 rounded-xl flex items-center justify-center">
                <span class="text-2xl">💰</span>
              </div>
            </div>
            <div>
              <p class="text-white font-semibold">{{ t('auth.easyBilling') }}</p>
              <p class="text-green-100 text-sm">{{ t('auth.fastCheckout') }}</p>
            </div>
          </div>
          <div class="group flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all hover:scale-105">
            <div class="relative w-12 h-12 flex-shrink-0">
              <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-cyan-400 rounded-xl blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
              <div class="relative w-full h-full bg-white/20 rounded-xl flex items-center justify-center">
                <span class="text-2xl">📊</span>
              </div>
            </div>
            <div>
              <p class="text-white font-semibold">{{ t('auth.analytics') }}</p>
              <p class="text-green-100 text-sm">{{ t('auth.businessInsights') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative z-10">
      <div class="w-full max-w-md">
        <div class="backdrop-blur-xl rounded-3xl shadow-2xl p-8 transition-colors" :class="isDark ? 'bg-slate-800/90 border border-slate-700' : 'bg-white/80 border border-white/20'">
          <!-- Mobile Logo -->
          <div class="lg:hidden text-center mb-6">
            <div class="relative w-20 h-20 mx-auto mb-3">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-2xl blur-lg opacity-60"></div>
              <div class="relative w-full h-full bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-xl border-2 border-white/20">
                <span class="text-4xl">🏪</span>
              </div>
            </div>
            <h1 class="text-2xl font-bold transition-colors" :class="isDark ? 'text-white' : 'bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent'">Smart SuperMarket</h1>
          </div>

          <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mb-2 transition-colors" :class="isDark ? 'text-white' : 'text-gray-900'">{{ t('common.welcome') }}</h2>
            <p class="transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">{{ t('auth.loginSubtitle') }}</p>
          </div>
          
          <!-- Verification Status Message -->
          <div v-if="verificationMessage" class="mb-6 p-4 rounded-xl border-2 transition-all" :class="{
            'bg-green-50 border-green-200 text-green-700': verificationStatus === 'success',
            'bg-blue-50 border-blue-200 text-blue-700': verificationStatus === 'info',
            'bg-red-50 border-red-200 text-red-700': verificationStatus === 'error'
          }">
            <p class="text-sm font-medium">{{ verificationMessage }}</p>
          </div>
          
          <form @submit.prevent="handleLogin" class="space-y-5">
            <!-- Email -->
            <div>
              <label class="form-label">{{ t('auth.email') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
                <input 
                  v-model="form.email" 
                  type="email" 
                  class="w-full pl-12 pr-4 py-3.5 border-2 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white placeholder-slate-400' : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'"
                  :placeholder="t('auth.enterEmail')"
                  required
                />
              </div>
              <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
            </div>

            <!-- Password -->
            <div>
              <label class="form-label">{{ t('auth.password') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input 
                  v-model="form.password" 
                  :type="showPassword ? 'text' : 'password'" 
                  class="w-full pl-12 pr-12 py-3.5 border-2 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white placeholder-slate-400' : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'"
                  :placeholder="t('auth.enterPassword')"
                  required
                />
                <button 
                  type="button" 
                  @click="showPassword = !showPassword"
                  class="absolute right-4 top-1/2 -translate-y-1/2 transition-colors" 
                  :class="isDark ? 'text-slate-400 hover:text-slate-200' : 'text-gray-400 hover:text-gray-600'"
                >
                  <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
              <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
            </div>
            
            <!-- Error Message -->
            <div v-if="error" class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
              <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-red-700 text-sm">{{ error }}</span>
              </div>
              <!-- Resend Verification Button -->
              <button 
                v-if="error.includes('verify your email')"
                type="button"
                @click="resendVerificationEmail"
                :disabled="resendingEmail"
                class="w-full mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ resendingEmail ? '📧 Sending...' : '📧 Resend Verification Email' }}
              </button>
            </div>
            
            <!-- Login Button -->
            <button 
              type="submit" 
              :disabled="loading"
              class="group relative w-full py-4 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-500 hover:via-emerald-500 hover:to-teal-500 text-white rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden"
            >
              <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
              <svg v-if="loading" class="relative animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span class="relative">{{ loading ? t('auth.signingIn') : t('auth.loginButton') }}</span>
            </button>
            
            <!-- Forgot Password Link -->
            <div class="text-center">
              <router-link 
                to="/forgot-password" 
                class="text-sm font-medium transition-colors" 
                :class="isDark ? 'text-blue-400 hover:text-blue-300' : 'text-blue-600 hover:text-blue-700'"
              >
                {{ t('auth.forgotPassword') }}
              </router-link>
            </div>
          </form>

          <!-- Links -->
          <div class="mt-6 text-center space-y-3">
            <p class="transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">
              {{ t('auth.dontHaveAccount') }}
              <router-link to="/register" class="text-green-600 hover:text-green-500 font-semibold transition-colors">{{ t('auth.registerButton') }}</router-link>
            </p>
            <router-link to="/store" class="block font-medium transition-colors" :class="isDark ? 'text-slate-400 hover:text-slate-200' : 'text-gray-500 hover:text-gray-700'">
              ← {{ t('auth.backToStore') }}
            </router-link>
          </div>
        </div>
        
        <p class="text-center text-sm mt-6 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-500'">
          © {{ new Date().getFullYear() }} Smart SuperMarket. {{ t('auth.allRightsReserved') }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { useThemeStore } from '../../stores/theme'
import { useTranslation } from '../../composables/useTranslation'
import { authApi } from '../../services/api'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const themeStore = useThemeStore()
const { t } = useTranslation()

const isDark = computed(() => themeStore.isDark)

const form = reactive({ email: '', password: '' })
const errors = reactive({ email: '', password: '' })
const error = ref('')
const loading = ref(false)
const showPassword = ref(false)
const verificationMessage = ref('')
const verificationStatus = ref('')
const resendingEmail = ref(false)

onMounted(() => {
  // Check for verification status in URL
  const verified = route.query.verified
  const message = route.query.message
  const registered = route.query.registered
  const email = route.query.email
  
  if (verified === 'success') {
    verificationStatus.value = 'success'
    verificationMessage.value = '✅ Email verified successfully! You can now login.'
  } else if (verified === 'already') {
    verificationStatus.value = 'info'
    verificationMessage.value = 'ℹ️ Email already verified. Please login.'
  } else if (verified === 'error') {
    verificationStatus.value = 'error'
    // Show specific error message if provided
    const errorMessages = {
      'user_not_found': 'User account not found.',
      'invalid_link': 'Invalid or expired verification link.',
      'verification_failed': 'Verification failed. Please try again.'
    }
    const errorMsg = message ? errorMessages[message] || 'Email verification failed.' : 'Invalid verification link.'
    verificationMessage.value = `❌ ${errorMsg}`
  } else if (registered === 'success') {
    verificationStatus.value = 'success'
    verificationMessage.value = `✅ Registration successful! Please check your email (${email}) to verify your account before logging in.`
  }
  
  // Auto-hide message after 15 seconds
  if (verificationMessage.value) {
    setTimeout(() => {
      verificationMessage.value = ''
      verificationStatus.value = ''
    }, 15000)
  }
  
  // Clean up URL parameters after reading them
  if (verified || registered) {
    const cleanUrl = window.location.pathname
    window.history.replaceState({}, document.title, cleanUrl)
  }
})

const handleLogin = async () => {
  errors.email = errors.password = error.value = ''
  
  if (!form.email) errors.email = 'Email is required'
  if (!form.password) errors.password = 'Password is required'
  if (errors.email || errors.password) return

  loading.value = true
  try {
    await authStore.login(form)
    const redirect = router.currentRoute.value.query.redirect
    if (redirect && !redirect.includes('/admin')) {
      router.push(redirect)
    } else {
      const userRole = authStore.user?.role
      if (userRole === 'customer') {
        router.push('/store')
      } else {
        router.push('/admin/dashboard')
      }
    }
  } catch (e) {
    const errorMsg = e.message || 'Invalid credentials. Please try again.'
    error.value = errorMsg
    
    // Check if error is about email verification
    if (errorMsg.includes('verify your email')) {
      verificationStatus.value = 'error'
      verificationMessage.value = '⚠️ ' + errorMsg
    }
  } finally {
    loading.value = false
  }
}

const resendVerificationEmail = async () => {
  if (!form.email) {
    error.value = 'Please enter your email address'
    return
  }
  
  resendingEmail.value = true
  try {
    await authApi.resendVerification({ email: form.email })
    verificationStatus.value = 'success'
    verificationMessage.value = '✅ Verification email sent! Please check your inbox.'
    
    setTimeout(() => {
      verificationMessage.value = ''
      verificationStatus.value = ''
    }, 10000)
  } catch (e) {
    error.value = e.message || 'Failed to resend verification email'
  } finally {
    resendingEmail.value = false
  }
}
</script>
