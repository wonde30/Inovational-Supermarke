<template>
  <button
    @click="toggleTheme"
    class="group relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-r from-yellow-50 via-orange-50 to-red-50 border-2 border-yellow-200 hover:border-yellow-400 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 active:scale-95 transition-all duration-300 cursor-pointer shadow-lg hover:shadow-xl overflow-hidden"
    :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
    tabindex="0"
    :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
  >
    <!-- Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
    
    <!-- Icon with Glow and Rotation -->
    <transition name="icon-rotate" mode="out-in">
      <div v-if="isDark" key="sun" class="relative">
        <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
          <span class="text-2xl">☀️</span>
        </div>
        <span class="relative text-2xl group-hover:scale-110 group-hover:rotate-90 transition-all duration-300">☀️</span>
      </div>
      <div v-else key="moon" class="relative">
        <div class="absolute inset-0 blur-md opacity-50 group-hover:opacity-75 transition-opacity">
          <span class="text-2xl">🌙</span>
        </div>
        <span class="relative text-2xl group-hover:scale-110 group-hover:-rotate-12 transition-all duration-300">🌙</span>
      </div>
    </transition>
    
    <!-- Live Indicator -->
    <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-500 rounded-full border-2 border-white animate-pulse"></div>
  </button>
</template>

<script setup>
import { computed } from 'vue'
import { useThemeStore } from '@/stores/theme'

const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const toggleTheme = () => {
  themeStore.toggleTheme()
}
</script>

<style scoped>
.icon-rotate-enter-active,
.icon-rotate-leave-active {
  transition: all 0.3s ease;
}

.icon-rotate-enter-from {
  opacity: 0;
  transform: rotate(-180deg) scale(0.5);
}

.icon-rotate-leave-to {
  opacity: 0;
  transform: rotate(180deg) scale(0.5);
}
</style>
