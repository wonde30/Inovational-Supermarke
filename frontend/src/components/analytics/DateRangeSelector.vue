<template>
  <div class="date-range-selector">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="start-date" class="block text-sm font-medium text-dark-700 mb-2">
          {{ t('analytics.startDate') }}
        </label>
        <input
          id="start-date"
          type="date"
          :value="modelValue.startDate"
          @input="handleStartDateChange"
          class="w-full px-4 py-2 border border-dark-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
          :class="{ 'border-red-500': validationError }"
        />
      </div>

      <div>
        <label for="end-date" class="block text-sm font-medium text-dark-700 mb-2">
          {{ t('analytics.endDate') }}
        </label>
        <input
          id="end-date"
          type="date"
          :value="modelValue.endDate"
          @input="handleEndDateChange"
          class="w-full px-4 py-2 border border-dark-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
          :class="{ 'border-red-500': validationError }"
        />
      </div>
    </div>

    <div v-if="validationError" class="mt-2 text-sm text-red-600">
      {{ validationError }}
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useTranslation } from '@/composables/useTranslation'

const { t } = useTranslation()

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
    validator: (value) => {
      return value && typeof value.startDate === 'string' && typeof value.endDate === 'string'
    }
  }
})

const emit = defineEmits(['update:modelValue'])

const validationError = ref('')

const validateDateRange = (startDate, endDate) => {
  if (!startDate || !endDate) {
    validationError.value = ''
    return true
  }

  const start = new Date(startDate)
  const end = new Date(endDate)

  if (start > end) {
    validationError.value = t('analytics.startDateMustBeBeforeEndDate')
    return false
  }

  validationError.value = ''
  return true
}

const handleStartDateChange = (event) => {
  const newStartDate = event.target.value
  const newValue = {
    ...props.modelValue,
    startDate: newStartDate
  }
  
  validateDateRange(newStartDate, props.modelValue.endDate)
  emit('update:modelValue', newValue)
}

const handleEndDateChange = (event) => {
  const newEndDate = event.target.value
  const newValue = {
    ...props.modelValue,
    endDate: newEndDate
  }
  
  validateDateRange(props.modelValue.startDate, newEndDate)
  emit('update:modelValue', newValue)
}

// Watch for external changes to validate
watch(() => props.modelValue, (newValue) => {
  validateDateRange(newValue.startDate, newValue.endDate)
}, { deep: true })
</script>

<style scoped>
.date-range-selector {
  width: 100%;
}
</style>
