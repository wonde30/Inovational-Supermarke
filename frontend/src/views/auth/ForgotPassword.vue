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
              <span class="text-4xl">🔐</span>
            </div>
            <h1 class="text-2xl font-bold transition-colors" :class="isDark ? 'text-white' : 'text-gray-900'">{{ t('auth.forgotPasswordTitle') }}</h1>
            <p class="text-sm mt-2 transition-colors" :class="isDark ? 'text-slate-300' : 'text-gray-600'">
              {{ t('auth.forgotPasswordSubtitle') }}
            </p>
          </div>

          <!-- Success Message -->
          <div v-if="success" class="mb-6 p-4 rounded-xl border-2 bg-green-50 border-green-200">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <p class="text-green-700 text-sm font-medium">{{ successMessage }}</p>
                <p class="text-green-600 text-xs mt-1">{{ t('auth.checkEmailInbox') }}</p>
              </div>
            </div>
          </div>

          <!-- Form -->
          <form v-if="!success" @submit.prevent="handleSubmit" class="space-y-5">
            <!-- Email -->
            <div>
              <label class="form-label">{{ t('auth.emailAddress') }}</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors" :class="isDark ? 'text-slate-400' : 'text-gray-400'">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
                <input 
                  v-model="email" 
                  type="email" 
                  class="w-full pl-12 pr-4 py-3.5 border-2 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                  :class="isDark ? 'bg-slate-700 border-slate-600 text-white placeholder-slate-400' : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'"
                  :placeholder="t('auth.enterEmailAddress')"
                  required
                  :disabled="loading"
                />
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
              <span>{{ loading ? t('auth.sending') : t('auth.sendResetLink') }}</span>
            </button>
          </form>

          <!-- Back to Login -->
          <div class="mt-6 text-center">
            <router-link 
              to="/login" 
              class="inline-flex items-center gap-2 font-medium transition-colors" 
              :class="isDark ? 'text-slate-400 hover:text-slate-200' : 'text-gray-500 hover:text-gray-700'"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              {{ t('auth.backToLogin') }}
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
import { ref, computed } from 'vue'
import { authApi } from '../../services/api'
import { useThemeStore } from '../../stores/theme'
import { useTranslation } from '../../composables/useTranslation'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'

const themeStore = useThemeStore()
const { t } = useTranslation()
const isDark = computed(() => themeStore.isDark)

const email = ref('')
const error = ref('')
const success = ref(false)
const successMessage = ref('')
const loading = ref(false)

const handleSubmit = async () => {
  error.value = ''
  
  if (!email.value) {
    error.value = t('auth.pleaseEnterEmail')
    return
  }

  loading.value = true
  try {
    const response = await authApi.forgotPassword({ email: email.value })
    success.value = true
    successMessage.value = response.message || t('auth.resetLinkSent')
  } catch (e) {
    error.value = e.message || t('auth.failedToSendResetLink')
  } finally {
    loading.value = false
  }
}
</script>
