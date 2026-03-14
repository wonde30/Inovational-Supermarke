<template>
  <div class="flex flex-col justify-center items-center gap-4" :class="containerClass">
    <div class="relative">
      <div class="loading-spinner" :class="sizeClass"></div>
      <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-500 to-accent-500 opacity-20 blur-xl animate-pulse"></div>
    </div>
    <p v-if="text" class="text-dark-500 font-medium animate-pulse">{{ text }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  size: { type: String, default: 'md' },
  fullScreen: { type: Boolean, default: false },
  text: { type: String, default: '' }
})

const sizeClass = computed(() => ({
  'sm': 'w-6 h-6 border-2',
  'md': 'w-12 h-12 border-4',
  'lg': 'w-20 h-20 border-4'
}[props.size]))

const containerClass = computed(() => props.fullScreen ? 'fixed inset-0 bg-white/80 backdrop-blur-sm z-50' : 'py-8')
</script>
