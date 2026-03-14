<template>
  <div class="text-center py-12">
    <div class="text-gray-400 text-5xl mb-4">📭</div>
    <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
    <p class="text-gray-500 mt-1">{{ message }}</p>
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: 'No data' },
  message: { type: String, default: 'There is nothing to display here.' }
})
</script>
