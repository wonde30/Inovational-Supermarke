<template>
  <div class="min-h-screen flex relative overflow-hidden transition-colors duration-300" :class="isDark ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900' : 'bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50'">
    <!-- Theme and Language Controls - Top Right -->
    <div class="absolute top-4 right-4 z-50 flex items-center gap-2">
      <ThemeToggle />
      <LanguageSwitcher />
    </div>
    
    <!-- Decorative Background -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full blur-3xl transition-colors" :class="isDark ? 'bg-blue-900/20' : 'bg-blue-200/30'"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full blur-3xl transition-colors" :class="isDark ? 'bg-purple-900/20' : 'bg-purple-200/30'"></div>
    </div>

    <!-- Main Content -->
    <div class="w-full flex items-center justify-center p-6 relative z-10">
      <div class="w-full max-w-md">
        <div class="backdrop-blur-xl rounded-3xl shadow-2xl p-8 transition-colors" :class="isDark ? 'bg-slate-800/90 border border-slate-700' : 'bg-white/80 border border-white/20'">
          <!-- Logo -->
          <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
              <span class="text-4xl">🔑</span>
            </div>
            <h1 class="text-2xl font-bold transition-colors" :class="isDark ? 'text-white' : 'text-gray-900'">{{ t('auth.resetPasswordTitle') }}</h1>
            <p class="text-sm mt-2 transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">
              {{ t('auth.enterNewPasswordBelow') }}
            </p>
          </div>

          <!-- Token Validation Loading -->
          <div v-if="validating" class="text-center py-8">
            <div class="animate-spin w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full mx-auto mb-4"></div>
            <p class="transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">{{ t('auth.validatingResetLink') }}</p>
          </div>

          <!-- Invalid Token -->
          <div v-else-if="!tokenValid" class="text-center py-8">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2 transition-colors" :class="isDark ? 'text-white' : 'text-gray-900'">{{ t('auth.invalidOrExpiredLink') }}</h3>
            <p class="text-sm mb-6 transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">
              {{ t('auth.resetLinkInvalidOrExpired') }}
            </p>
            <router-link 
              to="/forgot-password" 
              class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors"
            >
              {{ t('auth.requestNewLink') }}
            </router-link>
          </div>

          <!-- Reset Form -->
          <form v-else-if="!success" @submit.prevent="handleSubmit" class="space-y-5">
            <!-- Email (readonly) -->
            <div>
              <label class="form-label">{{ t('auth.emailAddress') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
                <input 
                  :value="email" 
                  type="email" 
                  class="w-full pl-12 pr-4 py-3.5 border-2 rounded-xl outline-none transition-all opacity-75 cursor-not-allowed" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white' : 'bg-gray-100 border-gray-200 text-gray-900'"
                  readonly
                />
              </div>
            </div>

            <!-- New Password -->
            <div>
              <label class="form-label">{{ t('auth.newPassword') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input 
                  v-model="form.password" 
                  :type="showPassword ? 'text' : 'password'" 
                  class="w-full pl-12 pr-12 py-3.5 border-2 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white placeholder-slate-400' : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'"
                  :placeholder="t('auth.enterNewPassword')"
                  required
                  :disabled="loading"
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
              <p class="text-xs mt-1 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-500'">
                {{ t('auth.passwordRequirements') }}
              </p>
            </div>

            <!-- Confirm Password -->
            <div>
              <label class="form-label">{{ t('auth.confirmPassword') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input 
                  v-model="form.password_confirmation" 
                  :type="showConfirmPassword ? 'text' : 'password'" 
                  class="w-full pl-12 pr-12 py-3.5 border-2 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white placeholder-slate-400' : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'"
                  :placeholder="t('auth.confirmNewPassword')"
                  required
                  :disabled="loading"
                />
                <button 
                  type="button" 
                  @click="showConfirmPassword = !showConfirmPassword"
                  class="absolute right-4 top-1/2 -translate-y-1/2 transition-colors" 
                  :class="isDark ? 'text-slate-400 hover:text-slate-200' : 'text-gray-400 hover:text-gray-600'"
                >
                  <svg v-if="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-red-700 text-sm">{{ error }}</span>
              </div>
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              :disabled="loading"
              class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3"
            >
              <svg v-if="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ loading ? t('auth.resetting') : t('auth.resetPassword') }}</span>
            </button>
          </form>

          <!-- Success Message -->
          <div v-else class="text-center py-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2 transition-colors" :class="isDark ? 'text-white' : 'text-gray-900'">{{ t('auth.passwordResetSuccessful') }}</h3>
            <p class="text-sm mb-6 transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">
              {{ t('auth.passwordResetSuccessMessage') }}
            </p>
            <router-link 
              to="/login" 
              class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors"
            >
              {{ t('auth.goToLogin') }}
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
import { useRoute, useRouter } from 'vue-router'
import { authApi } from '../../services/api'
import { useThemeStore } from '../../stores/theme'
import { useTranslation } from '../../composables/useTranslation'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'

const route = useRoute()
const router = useRouter()
const themeStore = useThemeStore()
const { t } = useTranslation()
const isDark = computed(() => themeStore.isDark)

const token = ref('')
const email = ref('')
const form = reactive({ password: '', password_confirmation: '' })
const error = ref('')
const success = ref(false)
const loading = ref(false)
const validating = ref(true)
const tokenValid = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)

onMounted(async () => {
  // Get token and email from URL
  token.value = route.query.token
  email.value = route.query.email

  if (!token.value || !email.value) {
    tokenValid.value = false
    validating.value = false
    return
  }

  // Verify the token
  try {
    await authApi.verifyResetToken({ token: token.value, email: email.value })
    tokenValid.value = true
  } catch (e) {
    tokenValid.value = false
    error.value = e.message || t('auth.invalidOrExpiredToken')
  } finally {
    validating.value = false
  }
})

const handleSubmit = async () => {
  error.value = ''
  
  if (form.password !== form.password_confirmation) {
    error.value = t('auth.passwordsDoNotMatch')
    return
  }
  
  if (form.password.length < 8) {
    error.value = t('auth.passwordTooShort')
    return
  }

  loading.value = true
  try {
    await authApi.resetPassword({
      email: email.value,
      token: token.value,
      password: form.password,
      password_confirmation: form.password_confirmation
    })
    success.value = true
  } catch (e) {
    error.value = e.message || t('auth.failedToResetPassword')
  } finally {
    loading.value = false
  }
}
</script>
