<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Test Dashboard</h1>
    <div class="bg-white p-4 rounded shadow">
      <p>Translation test: {{ t('common.welcome') }}</p>
      <p>Current locale: {{ locale }}</p>
      <p>User: {{ userName }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { useTranslation } from '@/composables/useTranslation'

const { t, locale } = useTranslation()
const authStore = useAuthStore()

const userName = computed(() => authStore.user?.name?.split(' ')[0] || 'User')
</script>
</template>