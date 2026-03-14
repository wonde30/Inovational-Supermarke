<template>
  <div class="form-group">
    <label v-if="label" :for="id" class="form-label">{{ label }}</label>
    <input :id="id" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder" :disabled="disabled"
      class="input" :class="{ 'input-error': error }" />
    <p v-if="error" class="form-error">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  label: String,
  type: { type: String, default: 'text' },
  placeholder: String,
  error: String,
  disabled: Boolean,
  id: String
})

defineEmits(['update:modelValue'])
</script>
