<template>
  <div class="p-4 bg-white rounded-lg shadow-md">
    <h3 class="text-lg font-bold mb-4">Translation System Test</h3>
    
    <div class="mb-4">
      <p><strong>Current Locale:</strong> {{ currentLocaleInfo.name }} ({{ currentLocaleInfo.code }})</p>
      <p><strong>Native Name:</strong> {{ currentLocaleInfo.nativeName }}</p>
    </div>
    
    <div class="mb-4">
      <h4 class="font-semibold mb-2">Language Switcher:</h4>
      <div class="flex gap-2">
        <button 
          v-for="locale in availableLocales" 
          :key="locale.code"
          @click="setLocale(locale.code)"
          class="px-3 py-1 rounded border"
          :class="locale.code === currentLocale ? 'bg-green-600 text-white' : 'bg-gray-100 hover:bg-gray-200'"
        >
          {{ locale.nativeName }}
        </button>
      </div>
    </div>
    
    <div class="mb-4">
      <h4 class="font-semibold mb-2">Sample Translations:</h4>
      <div class="space-y-2 text-sm">
        <p><strong>Common Welcome:</strong> {{ t('common.welcome') }}</p>
        <p><strong>Storefront Home:</strong> {{ t('storefront.home') }}</p>
        <p><strong>Add to Cart:</strong> {{ t('storefront.addToCart') }}</p>
        <p><strong>Product Description:</strong> {{ t('storefront.productDescription') }}</p>
        <p><strong>Key Features:</strong> {{ t('storefront.keyFeatures') }}</p>
        <p><strong>High Quality:</strong> {{ t('storefront.highQuality') }}</p>
        <p><strong>Interpolation Test:</strong> {{ t('storefront.onlyLeft', { count: 5 }) }}</p>
      </div>
    </div>
    
    <div class="text-xs text-gray-500">
      <p>This component tests the translation system functionality.</p>
      <p>All translations should update immediately when switching languages.</p>
    </div>
  </div>
</template>

<script setup>
import { useTranslation } from '@/composables/useTranslation'

const { t, locale: currentLocale, currentLocaleInfo, availableLocales, setLocale } = useTranslation()
</script>
</template>