<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-3xl font-bold mb-6">Dashboard Test Page</h1>
      
      <!-- Language Switcher Test -->
      <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Language Test</h2>
        <div class="flex items-center gap-4 mb-4">
          <LanguageSwitcher />
          <span>Current: {{ locale }}</span>
        </div>
        <div class="space-y-2">
          <p>Welcome: {{ t('common.welcome') }}</p>
          <p>Dashboard: {{ t('navigation.dashboard') }}</p>
          <p>Products: {{ t('navigation.products') }}</p>
          <p>Reports: {{ t('navigation.reports') }}</p>
        </div>
      </div>

      <!-- Dashboard Component Test -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Dashboard Component Test</h2>
        <router-link to="/admin/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Go to Dashboard
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useTranslation } from '@/composables/useTranslation'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'

const { t, locale } = useTranslation()
</script>
</template>