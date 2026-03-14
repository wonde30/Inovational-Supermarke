<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Delivery Assignments</h1>
        <p class="text-gray-600">Manage delivery assignments and routes</p>
      </div>
      <button 
        v-if="canManageDeliveries"
        class="btn btn-primary flex items-center gap-2"
      >
        <span>🚛</span>
        <span>New Assignment</span>
      </button>
    </div>

    <!-- Role-based Content -->
    <div v-if="isDeliveryStaff" class="bg-purple-50 border border-purple-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-purple-900 mb-2">Delivery Staff View</h2>
      <p class="text-purple-700">View your assigned deliveries, update delivery status, and manage your delivery routes.</p>
    </div>

    <div v-else-if="isAdmin || isManager" class="bg-green-50 border border-green-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-green-900 mb-2">Management View</h2>
      <p class="text-green-700">Assign deliveries to staff, monitor delivery performance, and optimize delivery routes.</p>
    </div>

    <!-- Delivery Assignments List -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
          {{ isDeliveryStaff ? 'Your Assignments' : 'All Delivery Assignments' }}
        </h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-12 text-gray-500">
          <div class="text-4xl mb-4">🚛</div>
          <p class="text-lg font-medium mb-2">Delivery Management</p>
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

const isAdmin = computed(() => auth.isAdmin)
const isManager = computed(() => auth.isManager)
const isDeliveryStaff = computed(() => auth.isDeliveryStaff)

const canManageDeliveries = computed(() => 
  auth.canManageDeliveries
)
</script>