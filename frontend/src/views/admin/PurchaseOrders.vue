<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Purchase Orders</h1>
        <p class="text-gray-600">Manage purchase orders and supplier relationships</p>
      </div>
      <button 
        v-if="canCreatePurchaseOrders"
        class="btn btn-primary flex items-center gap-2"
      >
        <span>➕</span>
        <span>New Purchase Order</span>
      </button>
    </div>

    <!-- Role-based Content -->
    <div v-if="isSupplier" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-blue-900 mb-2">Supplier View</h2>
      <p class="text-blue-700">View and manage your purchase orders, update delivery status, and confirm stock receipts.</p>
    </div>

    <div v-else-if="isAdmin || isManager" class="bg-green-50 border border-green-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-green-900 mb-2">Management View</h2>
      <p class="text-green-700">Create and manage purchase orders, track supplier performance, and oversee procurement processes.</p>
    </div>

    <!-- Purchase Orders List -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
          {{ isSupplier ? 'Your Purchase Orders' : 'All Purchase Orders' }}
        </h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-12 text-gray-500">
          <div class="text-4xl mb-4">📄</div>
          <p class="text-lg font-medium mb-2">Purchase Orders Management</p>
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
const isSupplier = computed(() => auth.isSupplier)

const canCreatePurchaseOrders = computed(() => 
  auth.canManageOrders && (isAdmin.value || isManager.value)
)
</script>