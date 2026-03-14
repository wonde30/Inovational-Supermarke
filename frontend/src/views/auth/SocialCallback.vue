<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600">
    <div class="text-center text-white">
      <div v-if="!error" class="animate-spin text-6xl mb-4">⏳</div>
      <div v-else class="text-6xl mb-4">❌</div>
      <h2 class="text-2xl font-bold">{{ error ? 'Authentication Failed' : 'Completing authentication...' }}</h2>
      <p class="text-green-200 mt-2">{{ error || 'Please wait' }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const error = ref('')

onMounted(() => {
  // Get token and user from URL query params
  const token = route.query.token
  const userParam = route.query.user
  const errorParam = route.query.error
  
  if (errorParam) {
    error.value = decodeURIComponent(errorParam)
    // Send error message to parent window
    if (window.opener) {
      window.opener.postMessage({
        type: 'google-auth-error',
        message: error.value
      }, window.location.origin)
      
      // Close popup after sending message
      setTimeout(() => {
        window.close()
      }, 2000)
    }
  } else if (token && userParam) {
    try {
      const user = JSON.parse(decodeURIComponent(userParam))
      
      // Send success message to parent window
      if (window.opener) {
        window.opener.postMessage({
          type: 'google-auth-success',
          token: token,
          user: user
        }, window.location.origin)
        
        // Close popup after sending message
        setTimeout(() => {
          window.close()
        }, 500)
      }
    } catch (e) {
      error.value = 'Failed to parse authentication data'
      if (window.opener) {
        window.opener.postMessage({
          type: 'google-auth-error',
          message: error.value
        }, window.location.origin)
        
        setTimeout(() => {
          window.close()
        }, 2000)
      }
    }
  } else {
    error.value = 'Missing authentication data'
    if (window.opener) {
      window.opener.postMessage({
        type: 'google-auth-error',
        message: error.value
      }, window.location.origin)
      
      setTimeout(() => {
        window.close()
      }, 2000)
    }
  }
})
</script>
