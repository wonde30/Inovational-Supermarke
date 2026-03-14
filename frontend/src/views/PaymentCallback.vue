<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 flex items-center justify-center p-6">
    <div class="max-w-md w-full">
      <!-- Success State - Always show this for Chapa returns -->
      <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
          <span class="text-4xl">✅</span>
        </div>
        <h2 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h2>
        <p class="text-gray-600 mb-2">ክፍያዎ በተሳካ ሁኔታ ተጠናቅቋል!</p>
        <p class="text-gray-500 mb-2">Your order has been confirmed and is being processed.</p>
        <p class="text-sm text-green-600 font-medium mb-6">Redirecting to Store in {{ redirectCountdown }} seconds...</p>

        <div class="space-y-3">
          <button @click="goToStore" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg">
            🛍️ Continue Shopping
          </button>
          <button @click="goToOrders" class="w-full px-6 py-3 border-2 border-green-600 text-green-600 rounded-xl font-semibold hover:bg-green-50 transition-all">
            📋 View My Orders
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useToastStore } from '../stores/toast'

const router = useRouter()
const toast = useToastStore()

const redirectCountdown = ref(2)
let redirectTimer = null
let countdownInterval = null

const startRedirectCountdown = () => {
  redirectCountdown.value = 2
  
  // Start countdown
  countdownInterval = setInterval(() => {
    redirectCountdown.value--
    if (redirectCountdown.value <= 0) {
      clearInterval(countdownInterval)
    }
  }, 1000)
  
  // Redirect to storefront after 2 seconds
  redirectTimer = setTimeout(() => {
    router.push('/store')
  }, 2000)
}

const goToOrders = () => {
  if (redirectTimer) clearTimeout(redirectTimer)
  if (countdownInterval) clearInterval(countdownInterval)
  router.push('/store/my-orders')
}

const goToStore = () => {
  if (redirectTimer) clearTimeout(redirectTimer)
  if (countdownInterval) clearInterval(countdownInterval)
  router.push('/store')
}

onMounted(async () => {
  console.log('🔄 Payment callback page mounted')
  
  // Clear cart
  localStorage.removeItem('cart')
  
  // Get order ID
  const orderId = localStorage.getItem('pending_order_id')
  console.log('📦 Order ID from localStorage:', orderId)
  
  // If we have an order ID, complete it
  if (orderId) {
    try {
      console.log('🔍 Completing order:', orderId)
      
      const token = localStorage.getItem('token')
      
      // Call complete-order endpoint
      const response = await fetch(`/api/v1/payments/complete-order`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ order_id: parseInt(orderId) })
      })
      
      const data = await response.json()
      console.log('📊 Complete order response:', data)
      
      if (data.success) {
        console.log('✅ Order completed successfully!')
        console.log('📋 Order status:', data.data?.order?.status)
      } else {
        console.error('❌ Failed to complete order:', data.message)
      }
    } catch (error) {
      console.error('💥 Error completing order:', error)
    }
    
    // Clear pending order
    localStorage.removeItem('pending_order_id')
  }
  
  // Show success message
  toast.success('Payment completed successfully!')
  
  // Start auto-redirect
  startRedirectCountdown()
})

onUnmounted(() => {
  if (redirectTimer) clearTimeout(redirectTimer)
  if (countdownInterval) clearInterval(countdownInterval)
})
</script>

<style scoped>
.animate-bounce {
  animation: bounce 1s infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}
</style>
