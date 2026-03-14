<template>
  <teleport to="body">
    <transition name="modal">
      <div v-if="modelValue" class="modal-overlay" @click.self="close">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header flex justify-between items-center">
            <h3 class="text-xl font-bold" style="color: var(--text-primary)">{{ title }}</h3>
            <button 
              @click="close" 
              class="w-10 h-10 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center transition-colors"
              style="color: var(--text-secondary)"
            >
              ✕
            </button>
          </div>
          
          <!-- Content -->
          <div class="modal-body">
            <slot></slot>
          </div>
          
          <!-- Footer -->
          <div v-if="$slots.footer" class="modal-footer">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script setup>
const props = defineProps({
  modelValue: Boolean,
  title: { type: String, default: '' }
})

const emit = defineEmits(['update:modelValue'])

const close = () => emit('update:modelValue', false)
</script>

<style scoped>
.modal-enter-active, .modal-leave-active { 
  transition: opacity 0.3s ease; 
}
.modal-enter-from, .modal-leave-to { 
  opacity: 0; 
}
.modal-enter-active .modal-content {
  animation: scaleIn 0.3s ease-out;
}
.modal-leave-active .modal-content {
  animation: scaleOut 0.2s ease-in;
}
@keyframes scaleIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
@keyframes scaleOut {
  from { opacity: 1; transform: scale(1); }
  to { opacity: 0; transform: scale(0.95); }
}
</style>
