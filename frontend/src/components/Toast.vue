<template>
  <div class="fixed top-4 right-4 z-50 space-y-3 max-w-sm">
    <transition-group name="toast">
      <div v-for="toast in toasts" :key="toast.id"
        class="toast flex items-start gap-3 min-w-[320px]"
        :class="typeClass(toast.type)"
        role="alert"
        :aria-live="toast.type === 'error' ? 'assertive' : 'polite'">
        <!-- Icon for accessibility and visual indicator -->
        <span class="flex-shrink-0 text-2xl" aria-hidden="true">
          <!-- Success Icon -->
          <span v-if="toast.type === 'success'">✅</span>
          <!-- Error Icon -->
          <span v-else-if="toast.type === 'error'">❌</span>
          <!-- Warning Icon -->
          <span v-else-if="toast.type === 'warning'">⚠️</span>
          <!-- Info Icon -->
          <span v-else-if="toast.type === 'info'">ℹ️</span>
        </span>
        
        <!-- Message with screen reader label -->
        <span class="flex-1 font-semibold text-sm leading-relaxed">
          <span class="sr-only">{{ getAriaLabel(toast.type) }}: </span>
          {{ toast.message }}
        </span>
        
        <!-- Close button -->
        <button 
          @click="remove(toast.id)" 
          class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 rounded w-6 h-6 flex items-center justify-center"
          :aria-label="`Close ${toast.type} notification`">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useToastStore } from '../stores/toast'

const toastStore = useToastStore()
const toasts = computed(() => toastStore.toasts)

const typeClass = (type) => ({
  'success': 'toast-success',
  'error': 'toast-error',
  'info': 'toast-info',
  'warning': 'toast-warning'
}[type] || 'toast-info')

const getAriaLabel = (type) => ({
  'success': 'Success',
  'error': 'Error',
  'info': 'Information',
  'warning': 'Warning'
}[type] || 'Notification')

const remove = (id) => toastStore.remove(id)
</script>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateX(100%); }
</style>
