<template>
  <div class="language-selector">
    <label class="label">{{ label || 'Language' }}</label>
    <div class="select-wrapper">
      <select 
        :value="currentLocale" 
        @change="handleChange"
        class="select"
        :disabled="disabled"
      >
        <option 
          v-for="locale in availableLocales" 
          :key="locale.code" 
          :value="locale.code"
        >
          {{ locale.flag }} {{ locale.nativeName }} ({{ locale.name }})
        </option>
      </select>
      <svg class="select-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>
    <p v-if="description" class="description">{{ description }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18nStore } from '@/stores/i18n'

const props = defineProps({
  label: {
    type: String,
    default: 'Language'
  },
  description: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const i18nStore = useI18nStore()
const currentLocale = computed(() => i18nStore.currentLocale)
const availableLocales = computed(() => i18nStore.locales)

const handleChange = async (event) => {
  await i18nStore.setLocale(event.target.value)
}
</script>

<style scoped>
.language-selector {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.label {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--text-primary);
}

.select-wrapper {
  position: relative;
}

.select {
  width: 100%;
  padding: 0.75rem 2.5rem 0.75rem 0.75rem;
  border: 1px solid var(--border-primary);
  border-radius: 0.5rem;
  background: var(--bg-primary);
  color: var(--text-primary);
  font-size: 0.875rem;
  appearance: none;
  cursor: pointer;
  transition: all 0.2s ease;
}

.select:hover {
  border-color: var(--border-secondary);
}

.select:focus {
  outline: none;
  border-color: var(--border-focus);
  box-shadow: 0 0 0 3px var(--bg-brand-subtle);
}

.select:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.select-icon {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1rem;
  height: 1rem;
  color: var(--text-secondary);
  pointer-events: none;
}

.description {
  font-size: 0.75rem;
  color: var(--text-secondary);
  margin: 0;
}
</style>