<template>
  <div class="fixed top-4 right-4 bg-white border-2 border-red-500 rounded-lg p-4 shadow-lg z-[9999] max-w-md">
    <h3 class="font-bold text-red-600 mb-2">Translation Debug</h3>
    <div class="text-sm space-y-1">
      <p><strong>Current Locale:</strong> {{ currentLocale }}</p>
      <p><strong>Translations Loaded:</strong> {{ translationsLoaded }}</p>
      <p><strong>Available Sections:</strong> {{ availableSections }}</p>
      
      <div class="mt-3">
        <p class="font-semibold">Test Keys:</p>
        <div class="space-y-1 text-xs">
          <div v-for="testKey in testKeys" :key="testKey" class="flex justify-between">
            <span class="text-gray-600">{{ testKey }}:</span>
            <span class="font-mono" :class="getTranslation(testKey) === testKey ? 'text-red-500' : 'text-green-500'">
              {{ getTranslation(testKey) }}
            </span>
          </div>
        </div>
      </div>
      
      <button @click="reloadTranslations" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded text-xs">
        Reload Translations
      </button>
      <button @click="$emit('close')" class="mt-2 ml-2 px-3 py-1 bg-red-500 text-white rounded text-xs">
        Close
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18nStore } from '@/stores/i18n'
import { useTranslation } from '@/composables/useTranslation'

defineEmits(['close'])

const i18nStore = useI18nStore()
const { t } = useTranslation()

const currentLocale = computed(() => i18nStore.currentLocale)
const translationsLoaded = computed(() => {
  const translations = i18nStore.translations[i18nStore.currentLocale]
  return translations && Object.keys(translations).length > 0
})
const availableSections = computed(() => {
  const translations = i18nStore.translations[i18nStore.currentLocale]
  return translations ? Object.keys(translations).join(', ') : 'None'
})

const testKeys = [
  'storefront.smartShoppingDestination',
  'storefront.welcomeBack',
  'common.welcome',
  'storefront.smartSuperMarket',
  'auth.login'
]

const getTranslation = (key) => {
  return t(key)
}

const reloadTranslations = async () => {
  try {
    await i18nStore.loadTranslations()
    console.log('Translations reloaded successfully')
  } catch (error) {
    console.error('Failed to reload translations:', error)
  }
}
</script>