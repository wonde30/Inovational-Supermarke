<template>
  <div class="language-switcher-container relative inline-block" ref="container">
    <!-- Revolutionary Language Button -->
    <button
      @click.stop="toggleDropdown"
      @mousedown.prevent
      class="group relative flex items-center justify-center gap-2 min-w-16 h-11 px-4 rounded-2xl bg-gradient-to-r from-purple-50 via-pink-50 to-blue-50 border-2 border-purple-200 hover:border-purple-400 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 active:scale-95 transition-all duration-300 cursor-pointer relative z-10 shadow-lg hover:shadow-xl overflow-hidden"
      :aria-label="`Current language: ${currentLocaleInfo.nativeName}. Click to change language`"
      tabindex="0"
      :title="`Current: ${currentLocaleInfo.nativeName}`"
      type="button"
    >
      <!-- Animated Background -->
      <div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
      
      <!-- Flag with Glow -->
      <div class="relative">
        <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
          <span class="text-xl">{{ currentLocaleInfo.flag }}</span>
        </div>
        <span class="relative text-xl group-hover:scale-110 transition-transform">{{ currentLocaleInfo.flag }}</span>
      </div>
      
      <!-- Language Code -->
      <span class="relative text-sm font-black text-gray-700 group-hover:text-purple-600 transition-colors">{{ currentLocale.toUpperCase() }}</span>
      
      <!-- Animated Arrow -->
      <svg 
        class="relative w-4 h-4 text-purple-600 transition-all duration-300" 
        :class="{ 'rotate-180 text-pink-600': isDropdownOpen }"
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
      </svg>
      
      <!-- Live Indicator -->
      <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
    </button>
    
    <!-- Revolutionary Dropdown -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95 -translate-y-2"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 -translate-y-2"
    >
      <div v-if="isDropdownOpen" class="absolute top-full right-0 mt-3 min-w-64 bg-white border-2 border-purple-200 rounded-2xl shadow-2xl z-[9999] overflow-hidden">
        <!-- Animated Top Bar -->
        <div class="flex h-1.5">
          <div class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 animate-gradient-x"></div>
          <div class="flex-1 bg-gradient-to-r from-pink-500 to-red-500 animate-gradient-x" style="animation-delay: 0.3s"></div>
          <div class="flex-1 bg-gradient-to-r from-blue-500 to-cyan-500 animate-gradient-x" style="animation-delay: 0.6s"></div>
        </div>
        
        <!-- Header -->
        <div class="px-4 py-3 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100">
          <div class="flex items-center gap-2">
            <span class="text-lg">🌍</span>
            <div>
              <p class="text-sm font-black text-gray-900">Select Language</p>
              <p class="text-xs text-gray-500">Choose your preferred language</p>
            </div>
          </div>
        </div>
        
        <!-- Language Options -->
        <div class="p-2">
          <button
            v-for="locale in availableLocales"
            :key="locale.code"
            @click.stop="selectLocale(locale.code)"
            class="group relative flex items-center gap-3 w-full px-4 py-3 text-left rounded-xl transition-all duration-200 border-none bg-transparent cursor-pointer hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:scale-105 overflow-hidden"
            :class="{ 'bg-gradient-to-r from-purple-100 to-pink-100 border-2 border-purple-300': locale.code === currentLocale }"
            :aria-label="`Switch to ${locale.nativeName}`"
            type="button"
          >
            <!-- Hover Effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
            
            <!-- Flag with Animation -->
            <div class="relative w-12 h-12 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all shadow-md">
              <span class="text-2xl">{{ locale.flag }}</span>
            </div>
            
            <!-- Language Info -->
            <div class="relative flex flex-col flex-1">
              <span class="text-sm font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ locale.nativeName }}</span>
              <span class="text-xs text-gray-500">{{ locale.name }}</span>
            </div>
            
            <!-- Selected Indicator -->
            <div v-if="locale.code === currentLocale" class="relative flex items-center gap-2">
              <span class="text-xs font-bold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">Active</span>
              <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">✓</span>
              </div>
            </div>
            
            <!-- Arrow on Hover -->
            <svg v-else class="relative w-5 h-5 text-purple-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
        
        <!-- Footer -->
        <div class="px-4 py-2 bg-gradient-to-r from-purple-50 to-pink-50 border-t border-purple-100 text-center">
          <p class="text-xs text-gray-500">🌐 {{ availableLocales.length }} languages available</p>
        </div>
        
        <!-- Animated Bottom Bar -->
        <div class="flex h-1.5">
          <div class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 animate-gradient-x"></div>
          <div class="flex-1 bg-gradient-to-r from-pink-500 to-red-500 animate-gradient-x" style="animation-delay: 0.3s"></div>
          <div class="flex-1 bg-gradient-to-r from-blue-500 to-cyan-500 animate-gradient-x" style="animation-delay: 0.6s"></div>
        </div>
      </div>
    </transition>
    
    <!-- Backdrop to close dropdown -->
    <div v-if="isDropdownOpen" class="fixed inset-0 z-[9998]" @click="closeDropdown"></div>
  </div>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useI18nStore } from '@/stores/i18n'

const i18nStore = useI18nStore()
const container = ref(null)
const isDropdownOpen = ref(false)

const currentLocale = computed(() => i18nStore.currentLocale)
const currentLocaleInfo = computed(() => i18nStore.currentLocaleInfo)
const availableLocales = computed(() => i18nStore.locales)

const toggleDropdown = (event) => {
  console.log('Language switcher clicked!', event)
  event.preventDefault()
  event.stopPropagation()
  isDropdownOpen.value = !isDropdownOpen.value
  console.log('Dropdown state:', isDropdownOpen.value)
}

const selectLocale = async (localeCode) => {
  console.log('=== SELECTING LOCALE ===')
  console.log('From:', currentLocale.value, 'To:', localeCode)
  
  try {
    // Close dropdown first
    isDropdownOpen.value = false
    
    // Set locale in store
    await i18nStore.setLocale(localeCode)
    
    // Verify the change
    console.log('Store locale after change:', i18nStore.currentLocale)
    console.log('Computed locale after change:', currentLocale.value)
    
    // Test translation
    console.log('Test translation:', i18nStore.t('storefront.checkoutTitle'))
    
    // Force a small delay to ensure reactivity
    await new Promise(resolve => setTimeout(resolve, 100))
    
    console.log('✅ Language change completed successfully')
    
  } catch (error) {
    console.error('❌ Failed to change locale:', error)
  }
}

const closeDropdown = () => {
  console.log('Closing dropdown')
  isDropdownOpen.value = false
}

const handleOutsideClick = (event) => {
  if (container.value && !container.value.contains(event.target)) {
    closeDropdown()
  }
}

onMounted(() => {
  console.log('=== LanguageSwitcher mounted ===')
  console.log('Current locale:', currentLocale.value)
  console.log('Available locales:', availableLocales.value)
  
  document.addEventListener('click', handleOutsideClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleOutsideClick)
})
</script>

<style scoped>
.language-switcher-container {
  position: relative;
  z-index: 10;
}

.language-switcher-container button {
  pointer-events: auto !important;
}

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}
</style>
