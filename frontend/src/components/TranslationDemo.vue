<template>
  <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        {{ t('common.welcome') }} 🌍
      </h2>
      <div class="flex items-center gap-2">
        <ThemeToggle />
        <LanguageSwitcher />
      </div>
    </div>

    <div class="space-y-4">
      <!-- Current Language Display -->
      <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
        <p class="text-sm text-green-700 dark:text-green-300 font-medium">
          Current Language: <span class="font-bold">{{ locale === 'en' ? 'English' : 'አማርኛ (Amharic)' }}</span>
        </p>
      </div>

      <!-- Common Translations -->
      <div class="grid grid-cols-2 gap-3">
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
          {{ t('common.save') }}
        </button>
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
          {{ t('common.delete') }}
        </button>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          {{ t('common.edit') }}
        </button>
        <button class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
          {{ t('common.cancel') }}
        </button>
      </div>

      <!-- Navigation Examples -->
      <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
        <h3 class="font-semibold text-gray-800 dark:text-white mb-3">{{ t('navigation.dashboard') }}</h3>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
          <li>📊 {{ t('navigation.dashboard') }}</li>
          <li>🛒 {{ t('navigation.pos') }}</li>
          <li>📦 {{ t('navigation.products') }}</li>
          <li>💰 {{ t('navigation.sales') }}</li>
          <li>📋 {{ t('navigation.orders') }}</li>
        </ul>
      </div>

      <!-- Messages Examples -->
      <div class="space-y-2">
        <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
          <p class="text-sm text-green-700 dark:text-green-300">✅ {{ t('messages.saveSuccess') }}</p>
        </div>
        <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
          <p class="text-sm text-red-700 dark:text-red-300">❌ {{ t('messages.errorOccurred') }}</p>
        </div>
      </div>

      <!-- Instructions -->
      <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
        <p class="text-sm text-blue-700 dark:text-blue-300">
          <strong>{{ isAmharic ? 'መመሪያ' : 'Instructions' }}:</strong>
          {{ isAmharic 
            ? 'ቋንቋውን ለመቀየር ከላይ ያለውን የቋንቋ መቀየሪያ ቁልፍ ይጫኑ። ሁሉም ጽሑፎች በቅጽበት ይቀየራሉ።'
            : 'Click the language switcher button above to toggle between English and Amharic. All text will change instantly.'
          }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useTranslation } from '@/composables/useTranslation'
import ThemeToggle from './ThemeToggle.vue'
import LanguageSwitcher from './LanguageSwitcher.vue'

const { t, locale, isAmharic } = useTranslation()
</script>
