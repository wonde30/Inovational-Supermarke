<template>
  <div class="fixed top-4 left-4 z-50 bg-white/90 backdrop-blur-xl rounded-2xl p-4 shadow-2xl border-2 border-green-300 max-w-sm">
    <div class="flex items-center gap-3 mb-3">
      <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
        <span class="text-white text-lg">🤖</span>
      </div>
      <div>
        <h4 class="font-black text-gray-900">New: AI Assistant!</h4>
        <p class="text-xs text-gray-600">Multilingual admin helper</p>
      </div>
      <button @click="$emit('close')" class="ml-auto w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm">
        ✕
      </button>
    </div>
    
    <div class="space-y-2 text-sm text-gray-700">
      <p class="flex items-center gap-2">
        <span>🇺🇸</span>
        <span>English support</span>
      </p>
      <p class="flex items-center gap-2">
        <span>🇪🇹</span>
        <span>አማርኛ እና ኦሮምኛ ድጋፍ</span>
      </p>
      <p class="flex items-center gap-2">
        <span>💬</span>
        <span>Ask about navigation, users, reports</span>
      </p>
    </div>
    
    <div class="mt-4 text-center">
      <p class="text-xs text-gray-500">Look for the 🤖 button in the bottom-right corner!</p>
    </div>
  </div>
</template>

<script setup>
defineEmits(['close'])
</script>