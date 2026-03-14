<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('settings.title') }}</h1>

    <!-- Database Backup Section -->
    <div class="card mb-6">
      <h2 class="text-lg font-semibold mb-4">💾 {{ t('settings.databaseBackup') }}</h2>
      <p class="text-gray-600 mb-4">{{ t('settings.backupDescription') }}</p>
      
      <div class="flex gap-4 mb-6">
        <button @click="createBackup" :disabled="creating" class="btn btn-primary">
          {{ creating ? t('settings.creating') : `📥 ${t('settings.createBackup')}` }}
        </button>
        <button @click="fetchBackups" class="btn btn-secondary">🔄 {{ t('settings.refreshList') }}</button>
      </div>

      <!-- Backup List -->
      <div v-if="loading" class="text-center py-4">
        <LoadingSpinner />
      </div>
      <div v-else-if="backups.length === 0" class="text-center py-8 text-gray-500">
        <p class="text-4xl mb-2">📁</p>
        <p>{{ t('settings.noBackupsFound') }}</p>
      </div>
      <div v-else class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-left text-gray-500 border-b bg-gray-50">
              <th class="py-2 px-3">{{ t('settings.filename') }}</th>
              <th class="py-2 px-3">{{ t('settings.size') }}</th>
              <th class="py-2 px-3">{{ t('settings.created') }}</th>
              <th class="py-2 px-3">{{ t('common.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="backup in backups" :key="backup.filename" class="border-b hover:bg-gray-50">
              <td class="py-3 px-3 font-mono text-sm">{{ backup.filename }}</td>
              <td class="py-3 px-3">{{ backup.size_formatted }}</td>
              <td class="py-3 px-3">{{ backup.created_at }}</td>
              <td class="py-3 px-3">
                <div class="flex gap-2">
                  <button @click="restoreBackup(backup.filename)" class="text-blue-600 hover:underline text-sm">
                    🔄 {{ t('settings.restore') }}
                  </button>
                  <button @click="downloadBackup(backup.filename)" class="text-green-600 hover:underline text-sm">
                    📥 {{ t('settings.download') }}
                  </button>
                  <button @click="deleteBackup(backup.filename)" class="text-red-600 hover:underline text-sm">
                    🗑️ {{ t('common.delete') }}
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- System Information -->
    <div class="card">
      <h2 class="text-lg font-semibold mb-4">ℹ️ {{ t('settings.systemInformation') }}</h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.systemName') }}</p>
          <p class="font-semibold">{{ t('settings.ibmsFullName') }}</p>
        </div>
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.version') }}</p>
          <p class="font-semibold">1.0.0</p>
        </div>
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.backend') }}</p>
          <p class="font-semibold">Laravel 11 / PHP 8.2</p>
        </div>
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.database') }}</p>
          <p class="font-semibold">MySQL 8.0</p>
        </div>
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.frontend') }}</p>
          <p class="font-semibold">Vue.js 3 / Vite</p>
        </div>
        <div class="p-4 bg-gray-50 rounded">
          <p class="text-sm text-gray-500">{{ t('settings.location') }}</p>
          <p class="font-semibold">{{ t('settings.yourCity') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { backupApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '../../composables/useTranslation'
import LoadingSpinner from '../../components/LoadingSpinner.vue'

const toast = useToastStore()
const { t } = useTranslation()
const loading = ref(false)
const creating = ref(false)
const backups = ref([])
const activeTab = ref('backup')

const fetchBackups = async () => {
  loading.value = true
  try {
    const res = await backupApi.list()
    backups.value = res.data || []
  } catch (e) {
    toast.error('Failed to load backups')
  } finally {
    loading.value = false
  }
}

const createBackup = async () => {
  creating.value = true
  try {
    const res = await backupApi.create()
    toast.success('Backup created successfully!')
    fetchBackups()
  } catch (e) {
    toast.error(e.message || 'Failed to create backup')
  } finally {
    creating.value = false
  }
}

const restoreBackup = async (filename) => {
  if (!confirm(`Are you sure you want to restore backup: ${filename}? This will overwrite current data.`)) {
    return
  }
  try {
    await backupApi.restore(filename)
    toast.success('Backup restored successfully!')
  } catch (e) {
    toast.error(e.message || 'Failed to restore backup')
  }
}

const deleteBackup = async (filename) => {
  if (!confirm(`Are you sure you want to delete backup: ${filename}?`)) return
  try {
    await backupApi.delete(filename)
    toast.success('Backup deleted successfully!')
    fetchBackups()
  } catch (e) {
    toast.error('Failed to delete backup')
  }
}

const downloadBackup = async (filename) => {
  try {
    const response = await backupApi.download(filename)
    // Create blob URL and trigger download
    const blob = new Blob([response.data], { type: 'application/sql' })
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = filename
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)
    toast.success('Download started successfully!')
  } catch (e) {
    toast.error('Failed to download backup')
  }
}

onMounted(fetchBackups)
</script>

<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(3deg); }
}

@keyframes float-delayed {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-15px) rotate(-2deg); }
}

@keyframes particle-float {
  0%, 100% { transform: translateY(0px) translateX(0px) scale(1); opacity: 0.6; }
  25% { transform: translateY(-10px) translateX(5px) scale(1.1); opacity: 0.8; }
  50% { transform: translateY(-20px) translateX(-5px) scale(0.9); opacity: 1; }
  75% { transform: translateY(-15px) translateX(8px) scale(1.05); opacity: 0.7; }
}

@keyframes gradient-x {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 8s ease-in-out infinite;
}

.particle-float {
  animation: particle-float 4s ease-in-out infinite;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}
</style>
