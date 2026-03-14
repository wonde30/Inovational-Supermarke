<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Stock Confirmation</h1>
        <p class="text-gray-600">Confirm stock deliveries and update quantities</p>
      </div>
    </div>

    <!-- Supplier Instructions -->
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
      <h2 class="text-lg font-semibold text-orange-900 mb-2">Stock Confirmation Process</h2>
      <p class="text-orange-700 mb-3">
        Confirm the quantities of items delivered and update any discrepancies or notes.
      </p>
      <ul class="text-sm text-orange-600 space-y-1">
        <li>• Review each item in the purchase order</li>
        <li>• Confirm actual quantities delivered</li>
        <li>• Add notes for any damaged or missing items</li>
        <li>• Submit confirmation to update inventory</li>
      </ul>
    </div>

    <!-- Pending Confirmations -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Stock Confirmations</h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-12 text-gray-500">
          <div class="text-4xl mb-4">✅</div>
          <p class="text-lg font-medium mb-2">Stock Confirmation</p>
          <p class="text-sm">Purchase orders requiring stock confirmation will appear here.</p>
          <div class="mt-6">
            <button class="btn btn-primary">
              <span>📄</span>
              <span>View Purchase Orders</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation History -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmation History</h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-8 text-gray-500">
          <div class="text-3xl mb-2">📋</div>
          <p class="text-sm">Your confirmation history will be displayed here.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../../stores/auth'

const auth = useAuthStore()

// Ensure only suppliers can access this page
if (!auth.isSupplier) {
  console.warn('Unauthorized access to stock confirmation')
}
</script>