<template>
  <div class="form-group">
    <label v-if="label" :for="id" class="form-label">{{ label }}</label>
    <select :id="id" :value="modelValue" @change="$emit('update:modelValue', $event.target.value)"
      :disabled="disabled" class="input" :class="{ 'input-error': error }">
      <option v-if="placeholder" value="">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.label }}
      </option>
    </select>
    <p v-if="error" class="form-error">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  label: String,
  options: { type: Array, default: () => [] },
  placeholder: String,
  error: String,
  disabled: Boolean,
  id: String
})

defineEmits(['update:modelValue'])
</script>
