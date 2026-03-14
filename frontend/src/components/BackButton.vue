<template>
  <button 
    @click="goBack"
    class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 border-2 border-gray-300 hover:border-green-500 rounded-xl font-semibold text-gray-700 hover:text-green-600 transition-all shadow-sm hover:shadow-md group"
    :class="customClass"
  >
    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    <span>{{ buttonText }}</span>
  </button>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useI18nStore } from '@/stores/i18n'

const props = defineProps({
  to: {
    type: String,
    default: null
  },
  customClass: {
    type: String,
    default: ''
  },
  text: {
    type: String,
    default: null
  }
})

const router = useRouter()
const i18n = useI18nStore()

const buttonText = computed(() => {
  if (props.text) return props.text
  
  const translations = {
    en: 'Back',
    am: 'ተመለስ',
    or: 'Deebi\'i'
  }
  
  return translations[i18n.currentLocale] || translations.en
})

const goBack = () => {
  if (props.to) {
    router.push(props.to)
  } else {
    router.back()
  }
}
</script>
