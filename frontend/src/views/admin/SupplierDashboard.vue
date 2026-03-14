<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Supplier Dashboard</h1>
        <p class="text-gray-600">Welcome to your supplier portal</p>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 bg-orange-100 rounded-lg">
        <span class="text-2xl">📦</span>
        <span class="font-medium text-orange-800">Supplier Portal</span>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
          <div class="text-3xl">📋</div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Completed Orders</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
          <div class="text-3xl">✅</div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">In Transit</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
          <div class="text-3xl">🚛</div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Value</p>
            <p class="text-2xl font-bold text-gray-900">$0</p>
          </div>
          <div class="text-3xl">💰</div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <router-link 
            to="/admin/purchase-orders" 
            class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
          >
            <div class="text-2xl">📄</div>
            <div>
              <p class="font-medium text-gray-900">View Purchase Orders</p>
              <p class="text-sm text-gray-600">Check your pending orders</p>
            </div>
          </router-link>

          <router-link 
            to="/admin/delivery-status" 
            class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
          >
            <div class="text-2xl">📍</div>
            <div>
              <p class="font-medium text-gray-900">Update Delivery Status</p>
              <p class="text-sm text-gray-600">Update shipment status</p>
            </div>
          </router-link>

          <router-link 
            to="/admin/stock-confirmation" 
            class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
          >
            <div class="text-2xl">✅</div>
            <div>
              <p class="font-medium text-gray-900">Confirm Stock</p>
              <p class="text-sm text-gray-600">Confirm stock deliveries</p>
            </div>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
        
        <!-- Placeholder content -->
        <div class="text-center py-12 text-gray-500">
          <div class="text-4xl mb-4">📊</div>
          <p class="text-lg font-medium mb-2">Supplier Activity</p>
          <p class="text-sm">Your recent purchase orders and activities will appear here.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../../stores/auth'

const auth = useAuthStore()

// Ensure only suppliers can access this dashboard
if (!auth.isSupplier) {
  // This should be handled by route guards, but as a fallback
  console.warn('Unauthorized access to supplier dashboard')
}
</script>