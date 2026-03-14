<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Delivery Status</h1>
        <p class="text-gray-600">Track and update delivery status</p>
      </div>
    </div>

    <!-- Role-based Content -->
    <div v-if="isDeliveryStaff" class="bg-purple-50 border border-purple-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-purple-900 mb-2">Update Delivery Status</h2>
      <p class="text-purple-700">Update the status of your deliveries and provide delivery confirmations.</p>
    </div>

    <div v-else-if="isSupplier" class="bg-orange-50 border border-orange-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-orange-900 mb-2">Supplier Delivery Updates</h2>
      <p class="text-orange-700">Update delivery status for your purchase orders and shipments.</p>
    </div>

    <div v-else class="bg-green-50 border border-green-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-green-900 mb-2">Delivery Monitoring</h2>
      <p class="text-green-700">Monitor all delivery statuses and track delivery performance.</p>
    </div>

    <!-- Delivery Status List -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Delivery Status Updates</h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-12 text-gray-500">
          <div class="text-4xl mb-4">📍</div>
          <p class="text-lg font-medium mb-2">Delivery Status Tracking</p>
          <p class="text-sm">This feature will be implemented based on your role permissions.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../../stores/auth'

const auth = useAuthStore()

const isDeliveryStaff = computed(() => auth.isDeliveryStaff)
const isSupplier = computed(() => auth.isSupplier)
</script>