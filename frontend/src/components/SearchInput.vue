<template>
  <div class="relative">
    <input type="text" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder" class="input pl-10" />
    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
  </div>
</template>

<script setup>
defineProps({
  modelValue: String,
  placeholder: { type: String, default: 'Search...' }
})

defineEmits(['update:modelValue'])
</script>
