<template>
  <div class="qr-scanner-container">
    <!-- Scanner Display -->
    <div class="relative bg-black rounded-2xl overflow-hidden shadow-2xl">
      <div id="qr-reader" class="w-full"></div>
      
      <!-- Scanning Overlay -->
      <div v-if="scanning" class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-64 h-64 border-4 border-green-500 rounded-2xl animate-pulse"></div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
          <p class="text-white text-center text-lg font-medium">
            📷 Point camera at QR code
          </p>
        </div>
      </div>

      <!-- Error State -->
      <div v-if="error" class="absolute inset-0 bg-red-500/90 flex items-center justify-center p-6">
        <div class="text-center text-white">
          <span class="text-6xl mb-4 block">⚠️</span>
          <p class="text-xl font-bold mb-2">Camera Error</p>
          <p class="text-sm">{{ error }}</p>
          <button @click="retry" class="mt-4 px-6 py-2 bg-white text-red-600 rounded-lg font-bold">
            Try Again
          </button>
        </div>
      </div>
    </div>

    <!-- Scanner Controls -->
    <div class="mt-4 flex gap-3">
      <button 
        @click="toggleScanning" 
        class="flex-1 py-3 rounded-xl font-bold text-white transition-all"
        :class="scanning ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'"
      >
        {{ scanning ? '⏸️ Pause' : '▶️ Start' }} Scanning
      </button>
      <button 
        @click="switchCamera" 
        class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-bold transition-all"
        :disabled="!scanning"
      >
        🔄
      </button>
    </div>

    <!-- Scan Statistics -->
    <div v-if="scanCount > 0" class="mt-4 bg-blue-50 rounded-xl p-4">
      <p class="text-sm text-blue-600 text-center">
        ✅ Scanned {{ scanCount }} product{{ scanCount > 1 ? 's' : '' }} today
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Html5Qrcode } from 'html5-qrcode'

const emit = defineEmits(['scanned', 'error'])

const scanning = ref(false)
const error = ref(null)
const scanCount = ref(0)
const html5QrCode = ref(null)
const currentCamera = ref('environment') // 'environment' or 'user'

const startScanning = async () => {
  try {
    error.value = null
    
    if (!html5QrCode.value) {
      html5QrCode.value = new Html5Qrcode("qr-reader")
    }

    const config = {
      fps: 10,
      qrbox: { width: 250, height: 250 },
      aspectRatio: 1.0
    }

    await html5QrCode.value.start(
      { facingMode: currentCamera.value },
      config,
      onScanSuccess,
      onScanError
    )
    
    scanning.value = true
  } catch (err) {
    error.value = err.message || 'Failed to access camera'
    scanning.value = false
    emit('error', error.value)
  }
}

const stopScanning = async () => {
  if (html5QrCode.value && scanning.value) {
    try {
      await html5QrCode.value.stop()
      scanning.value = false
    } catch (err) {
      console.error('Error stopping scanner:', err)
    }
  }
}

const toggleScanning = async () => {
  if (scanning.value) {
    await stopScanning()
  } else {
    await startScanning()
  }
}

const switchCamera = async () => {
  await stopScanning()
  currentCamera.value = currentCamera.value === 'environment' ? 'user' : 'environment'
  await startScanning()
}

const retry = async () => {
  error.value = null
  await startScanning()
}

const onScanSuccess = async (decodedText) => {
  try {
    // Vibrate on successful scan (if supported)
    if (navigator.vibrate) {
      navigator.vibrate(100)
    }

    scanCount.value++
    emit('scanned', decodedText)
    
    // Pause scanning briefly to prevent multiple scans
    if (html5QrCode.value) {
      await html5QrCode.value.pause(true)
      setTimeout(() => {
        if (html5QrCode.value && scanning.value) {
          html5QrCode.value.resume()
        }
      }, 2000)
    }
  } catch (error) {
    console.error('Scan processing error:', error)
  }
}

const onScanError = (errorMessage) => {
  // Ignore frequent scan errors (normal when no QR code is visible)
  // Only log critical errors
  if (errorMessage.includes('NotFoundException') === false) {
    console.warn('QR Scan error:', errorMessage)
  }
}

onMounted(async () => {
  await startScanning()
})

onUnmounted(async () => {
  await stopScanning()
  if (html5QrCode.value) {
    html5QrCode.value.clear()
  }
})
</script>

<style scoped>
#qr-reader {
  min-height: 300px;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
