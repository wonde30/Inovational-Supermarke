<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center p-4">
    <div class="text-center">
      <div class="text-8xl mb-6">🚫</div>
      <h1 class="text-4xl font-bold text-white mb-4">Access Denied / መዳረሻ ተከልክሏል</h1>
      <p class="text-xl text-gray-300 mb-8">You don't have permission to access this page.</p>
      <p class="text-gray-400 mb-8">ይህን ገጽ ለመድረስ ፈቃድ የለዎትም።</p>
      <div class="flex gap-4 justify-center">
        <router-link to="/admin/dashboard" class="btn btn-primary">
          <span>🏠</span>
          <span>Go to Dashboard</span>
        </router-link>
        <button @click="logout" class="btn btn-secondary">
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const logout = async () => {
  await auth.logout()
  router.push('/login')
}
</script>
