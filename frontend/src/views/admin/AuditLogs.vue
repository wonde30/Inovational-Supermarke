<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">Audit Logs / የክትትል መዝገብ</h2>
      <div class="flex gap-2">
        <select v-model="filters.action" @change="fetchLogs" class="input">
          <option value="">All Actions</option>
          <option value="login">Login</option>
          <option value="logout">Logout</option>
          <option value="create">Create</option>
          <option value="update">Update</option>
          <option value="delete">Delete</option>
          <option value="sale">Sale</option>
        </select>
        <input type="date" v-model="filters.date" @change="fetchLogs" class="input" />
      </div>
    </div>

    <LoadingSpinner v-if="loading" />
    
    <div v-else class="card">
      <table class="w-full">
        <thead>
          <tr class="text-left text-gray-500 border-b">
            <th class="pb-2">Time</th>
            <th class="pb-2">User</th>
            <th class="pb-2">Action</th>
            <th class="pb-2">Model</th>
            <th class="pb-2">Description</th>
            <th class="pb-2">IP Address</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs" :key="log.id" class="border-b hover:bg-gray-50">
            <td class="py-2 text-sm">{{ formatDateTime(log.created_at) }}</td>
            <td class="py-2">
              <span class="font-medium">{{ log.user?.name || 'System' }}</span>
            </td>
            <td class="py-2">
              <span :class="actionClass(log.action)" class="px-2 py-1 rounded text-xs font-medium">
                {{ log.action }}
              </span>
            </td>
            <td class="py-2 text-sm">
              {{ log.model_type }}
              <span v-if="log.model_id" class="text-gray-400">#{{ log.model_id }}</span>
            </td>
            <td class="py-2 text-sm text-gray-600">{{ log.description || '-' }}</td>
            <td class="py-2 text-sm text-gray-500">{{ log.ip_address }}</td>
          </tr>
        </tbody>
      </table>

      <div v-if="!logs.length" class="text-center py-8 text-gray-500">
        No audit logs found for the selected filters.
      </div>

      <Pagination 
        v-if="meta.last_page > 1"
        :current-page="meta.current_page" 
        :total-pages="meta.last_page" 
        @page-change="fetchLogs" 
        class="mt-4" 
      />
    </div>

    <!-- Fraud Prevention Info -->
    <div class="card mt-6 bg-blue-50 border-blue-200">
      <h3 class="font-semibold text-blue-800 mb-2">🔒 Fraud Prevention / የማጭበርበር መከላከያ</h3>
      <ul class="text-sm text-blue-700 space-y-1">
        <li>• All user actions are logged with timestamps and IP addresses</li>
        <li>• Price changes and deletions are tracked for accountability</li>
        <li>• Sales transactions cannot be modified after completion</li>
        <li>• ሁሉም የተጠቃሚ እንቅስቃሴዎች ይመዘገባሉ</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { advancedApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import Pagination from '../../components/Pagination.vue'

const toast = useToastStore()
const loading = ref(true)
const logs = ref([])
const meta = ref({ current_page: 1, last_page: 1 })
const filters = reactive({ action: '', date: '' })

const fetchLogs = async (page = 1) => {
  loading.value = true
  try {
    const params = { page, per_page: 25 }
    if (filters.action) params.action = filters.action
    if (filters.date) params.date = filters.date
    
    const response = await advancedApi.auditLogs(params)
    logs.value = response.data
    meta.value = response.meta
  } catch (e) {
    toast.error('Failed to load audit logs')
  } finally {
    loading.value = false
  }
}

const formatDateTime = (date) => {
  return new Date(date).toLocaleString('en-ET')
}

const actionClass = (action) => {
  const classes = {
    login: 'bg-green-100 text-green-800',
    logout: 'bg-gray-100 text-gray-800',
    create: 'bg-blue-100 text-blue-800',
    update: 'bg-yellow-100 text-yellow-800',
    delete: 'bg-red-100 text-red-800',
    sale: 'bg-purple-100 text-purple-800',
  }
  return classes[action] || 'bg-gray-100 text-gray-800'
}

onMounted(fetchLogs)
</script>
