<template>
  <div v-if="totalPages > 1" class="flex justify-center items-center space-x-2">
    <button @click="goTo(currentPage - 1)" :disabled="currentPage === 1"
      class="px-3 py-1 rounded border disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100">
      Prev
    </button>
    <span class="text-sm text-gray-600">Page {{ currentPage }} of {{ totalPages }}</span>
    <button @click="goTo(currentPage + 1)" :disabled="currentPage === totalPages"
      class="px-3 py-1 rounded border disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100">
      Next
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true }
})

const emit = defineEmits(['page-change'])

const goTo = (page) => {
  if (page >= 1 && page <= props.totalPages) {
    emit('page-change', page)
  }
}
</script>
