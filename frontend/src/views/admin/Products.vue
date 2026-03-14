<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Products Header -->
    <div class="relative z-10 mb-6">
      <div class="relative group">
        <!-- 3D Background Layer -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl transform transition-transform group-hover:scale-105 shadow-2xl"></div>
        
        <!-- Main Content Layer -->
        <div class="relative bg-gradient-to-r from-green-600/95 via-emerald-600/95 to-teal-600/95 backdrop-blur-xl rounded-3xl p-6 lg:p-8 text-white shadow-2xl overflow-hidden border border-white/20 mx-4 mt-4">
          <!-- Animated Mesh Background -->
          <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full blur-3xl animate-float-delayed"></div>
          </div>
          
          <!-- Floating Particles -->
          <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle-float absolute w-2 h-2 bg-white/60 rounded-full" style="top: 20%; left: 10%; animation-delay: 0s"></div>
            <div class="particle-float absolute w-3 h-3 bg-yellow-300/40 rounded-full" style="top: 60%; left: 80%; animation-delay: 1s"></div>
            <div class="particle-float absolute w-2 h-2 bg-pink-300/50 rounded-full" style="top: 40%; left: 60%; animation-delay: 2s"></div>
          </div>
          
          <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
              <!-- 3D Products Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">📦</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart Products / ምርቶች
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📊</span>
                  <span>{{ products.length }} Products</span>
                  <span class="mx-2">•</span>
                  <span>🏪</span>
                  <span>Advanced Inventory Management</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="openBulkImport" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">📥</span>
                <span class="relative">Bulk Import</span>
              </button>
              
              <button @click="openModal()" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">➕</span>
                <span class="relative">Add Product</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4">
      <!-- Revolutionary Search & Filter Section -->
      <div class="group relative transform transition-all duration-500 hover:scale-105 mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Enhanced Search -->
            <div class="md:col-span-2 relative group/search">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-blue-600 transition-colors">
                <span class="text-2xl">🔍</span>
              </div>
              <input 
                v-model="search" 
                @input="fetchProducts"
                type="text" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Search products by name, SKU, or category..."
              />
            </div>
            
            <!-- Category Filter -->
            <div class="relative group/category">
              <select 
                v-model="categoryFilter" 
                @change="fetchProducts"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/category:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            
            <!-- Stock Filter -->
            <div class="relative group/stock">
              <select 
                v-model="stockFilter" 
                @change="fetchProducts"
                class="appearance-none w-full pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="">All Stock Levels</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock</option>
                <option value="out_of_stock">Out of Stock</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/stock:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Products Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="relative">
          <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
          <div class="relative w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center shadow-xl">
            <div class="loading-spinner w-10 h-10"></div>
          </div>
        </div>
      </div>

      <div v-else-if="products.length === 0" class="relative group py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-3xl blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-6xl">📦</span>
            </div>
          </div>
          <h3 class="text-3xl font-black text-gray-700 mb-4">No Products Found</h3>
          <p class="text-gray-500 text-lg mb-8">Start building your inventory by adding your first product</p>
          <button @click="openModal()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1">
            <span class="text-2xl">➕</span>
            <span>Add Your First Product</span>
          </button>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="product in products" 
          :key="product.id" 
          class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Product Card -->
          <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all flex flex-col" style="min-height: 400px;">
            <!-- Enhanced Product Image -->
            <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
              <img :src="getImageUrl(product.image)" :alt="product.name" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500" @error="handleImageError" />
              
              <!-- Enhanced Status Badges -->
              <div class="absolute top-3 right-3 space-y-1">
                <span v-if="product.quantity <= 0" class="block px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                  ❌ Out of Stock
                </span>
                <span v-else-if="product.low_stock" class="block px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                  ⚠️ Low Stock
                </span>
                <span v-else class="block px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold rounded-full shadow-lg">
                  ✅ In Stock
                </span>
              </div>
              
              <!-- SKU Badge -->
              <div class="absolute top-3 left-3">
                <code class="px-2 py-1 bg-black/70 text-white text-xs font-mono rounded-lg backdrop-blur-sm">{{ product.sku }}</code>
              </div>
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-transform">
                  <span class="text-2xl">✏️</span>
                </div>
              </div>
            </div>

            <!-- Enhanced Product Details -->
            <div class="p-4 bg-gradient-to-br from-white to-gray-50 flex-1 flex flex-col">
              <!-- Product Name -->
              <h3 class="font-black text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-green-600 transition-colors" style="min-height: 3.5rem;">
                {{ product.name }}
              </h3>
              
              <!-- Category -->
              <div class="mb-3">
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                  {{ product.category?.name || 'Uncategorized' }}
                </span>
              </div>
              
              <!-- Price Section -->
              <div class="flex items-baseline justify-between mb-3">
                <span class="text-3xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                  ETB {{ formatCurrency(product.price) }}
                </span>
                <div class="text-right">
                  <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                    <span class="text-xl">⭐</span>
                  </div>
                </div>
              </div>
              
              <!-- Stock Info -->
              <div class="mt-auto pt-3 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                  <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full animate-pulse" :class="product.quantity > 10 ? 'bg-green-500' : product.quantity > 0 ? 'bg-yellow-500' : 'bg-red-500'"></span>
                    <span class="text-sm font-bold text-gray-600">
                      {{ product.quantity }} units
                    </span>
                  </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                  <button @click="openModal(product)" class="flex-1 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                    <span>✏️</span>
                    <span>Edit</span>
                  </button>
                  <button @click="deleteProduct(product.id)" class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105">
                    🗑️
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Revolutionary Product Modal -->
    <Modal v-model="showModal" :title="editingProduct ? 'Edit Product / ምርት አርትዕ' : 'Add Product / ምርት ጨምር'">
      <div class="relative">
        <!-- 3D Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-2xl opacity-10"></div>
        
        <form @submit.prevent="saveProduct" class="relative space-y-6 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Name -->
            <div class="md:col-span-2">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">📝</span>
                <span>Product Name / የምርት ስም</span>
              </label>
              <input 
                v-model="form.name" 
                type="text"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="Enter product name..."
                required
              />
            </div>
            
            <!-- SKU -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">🏷️</span>
                <span>SKU Code</span>
              </label>
              <input 
                v-model="form.sku" 
                type="text"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="e.g., PRD-001"
                required
              />
            </div>
            
            <!-- Category -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">📂</span>
                <span>Category / ምድብ</span>
              </label>
              <select 
                v-model="form.category_id" 
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm cursor-pointer"
                required
              >
                <option value="">Select Category</option>
                <option v-for="cat in categoryOptions" :key="cat.value" :value="cat.value">
                  {{ cat.label }}
                </option>
              </select>
            </div>
            
            <!-- Price -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">💰</span>
                <span>Selling Price (ETB)</span>
              </label>
              <input 
                v-model="form.price" 
                type="number" 
                step="0.01"
                min="0"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="0.00"
                required
              />
            </div>
            
            <!-- Cost -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">📊</span>
                <span>Cost Price (ETB)</span>
              </label>
              <input 
                v-model="form.cost" 
                type="number" 
                step="0.01"
                min="0"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="0.00"
              />
            </div>
            
            <!-- Quantity -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">📦</span>
                <span>Stock Quantity</span>
              </label>
              <input 
                v-model="form.quantity" 
                type="number"
                min="0"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="0"
                required
              />
            </div>
            
            <!-- Reorder Level -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">⚠️</span>
                <span>Reorder Level</span>
              </label>
              <input 
                v-model="form.reorder_level" 
                type="number"
                min="0"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="10"
              />
            </div>
            
            <!-- Image URL -->
            <div class="md:col-span-2">
              <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">🖼️</span>
                <span>Product Image URL (Optional)</span>
              </label>
              <input 
                v-model="form.image" 
                type="url"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
                placeholder="https://example.com/image.jpg"
              />
              <p class="text-xs text-gray-500 mt-1">Enter a valid image URL or leave empty for default</p>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
            <button 
              type="button" 
              @click="showModal = false" 
              class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transition-all hover:scale-105 flex items-center gap-2"
            >
              <span>❌</span>
              <span>Cancel</span>
            </button>
            <button 
              type="submit" 
              :disabled="processing"
              class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 flex items-center gap-2"
            >
              <span v-if="processing" class="loading-spinner w-5 h-5"></span>
              <span v-else>{{ editingProduct ? '💾' : '➕' }}</span>
              <span>{{ processing ? 'Saving...' : (editingProduct ? 'Update Product' : 'Add Product') }}</span>
            </button>
          </div>
        </form>
      </div>
    </Modal>

    <!-- Bulk Import Modal -->
    <Modal v-model="showBulkImport" title="Bulk Import Products / በጅምላ ምርቶች ማስመጣት">
      <div class="space-y-6 p-6">
        <div class="text-center">
          <div class="relative inline-block mb-4">
            <div class="absolute inset-0 bg-purple-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-4xl">📥</span>
            </div>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-2">Import Products from CSV</h3>
          <p class="text-gray-600">Upload a CSV file to add multiple products at once</p>
        </div>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-purple-400 transition-colors">
          <input type="file" accept=".csv" @change="handleFileUpload" class="hidden" ref="fileInput" />
          <button @click="$refs.fileInput.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white rounded-xl font-bold transition-all shadow-lg hover:scale-105">
            <span class="text-xl">📁</span>
            <span>Choose CSV File</span>
          </button>
          <p class="text-sm text-gray-500 mt-2">Supported format: CSV with columns: name, sku, category_id, price, cost, quantity</p>
        </div>
        
        <div class="flex justify-end gap-4">
          <button @click="showBulkImport = false" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">
            Close
          </button>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { productsApi, categoriesApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import Modal from '../../components/Modal.vue'
import { useTranslation } from '@/composables/useTranslation'

const { t } = useTranslation()
const toast = useToastStore()

// Reactive Data
const loading = ref(true)
const processing = ref(false)
const products = ref([])
const categories = ref([])
const meta = ref({ current_page: 1, last_page: 1 })
const search = ref('')
const categoryFilter = ref('')
const stockFilter = ref('')
const showModal = ref(false)
const showBulkImport = ref(false)
const editingProduct = ref(null)

const form = reactive({
  name: '',
  sku: '',
  price: '',
  cost: '',
  quantity: '',
  reorder_level: 10,
  category_id: '',
  image: ''
})

// Computed Properties
const categoryOptions = computed(() => {
  return categories.value.map(c => ({ value: c.id, label: c.name }))
})

// Utility Functions
const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-ET', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const getImageUrl = (image) => {
  if (!image) return '/images/products/default.jpg'
  if (image.startsWith('http')) return image
  if (image.startsWith('/')) return image
  if (image.startsWith('images/')) return '/' + image
  return `/storage/${image}`
}

const handleImageError = (e) => {
  e.target.style.display = 'none'
  e.target.parentElement.innerHTML = '<span class="text-4xl">📦</span>'
}

// API Functions
const fetchProducts = async (page = 1) => {
  loading.value = true
  try {
    const params = { 
      page, 
      search: search.value,
      category_id: categoryFilter.value,
      stock_filter: stockFilter.value
    }
    const response = await productsApi.getAll(params)
    products.value = response.data
    meta.value = response.meta
  } catch (e) {
    toast.error('Failed to load products')
  } finally {
    loading.value = false
  }
}

const fetchCategories = async () => {
  try {
    const response = await categoriesApi.getAll()
    categories.value = response.data
  } catch (e) {
    console.error('Failed to load categories:', e)
  }
}

const openModal = (product = null) => {
  editingProduct.value = product
  if (product) {
    Object.assign(form, product)
  } else {
    Object.assign(form, {
      name: '',
      sku: '',
      price: '',
      cost: '',
      quantity: '',
      reorder_level: 10,
      category_id: '',
      image: ''
    })
  }
  showModal.value = true
}

const saveProduct = async () => {
  processing.value = true
  try {
    if (editingProduct.value) {
      await productsApi.update(editingProduct.value.id, form)
      toast.success('✅ Product updated successfully!')
    } else {
      await productsApi.create(form)
      toast.success('✅ Product added successfully!')
    }
    showModal.value = false
    fetchProducts()
  } catch (e) {
    toast.error(e.message || 'Failed to save product')
  } finally {
    processing.value = false
  }
}

const deleteProduct = async (id) => {
  if (!confirm('Are you sure you want to delete this product?')) return
  
  try {
    await productsApi.delete(id)
    toast.success('🗑️ Product deleted successfully!')
    fetchProducts()
  } catch (e) {
    toast.error('Failed to delete product')
  }
}

const openBulkImport = () => {
  showBulkImport.value = true
}

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    toast.info('📥 Bulk import feature coming soon!')
    showBulkImport.value = false
  }
}

// Lifecycle
onMounted(() => {
  fetchProducts()
  fetchCategories()
})
</script>

<style scoped>
/* Revolutionary Products Styles */
@keyframes float {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  33% {
    transform: translateY(-20px) translateX(10px);
  }
  66% {
    transform: translateY(-10px) translateX(-10px);
  }
}

@keyframes float-delayed {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  33% {
    transform: translateY(-15px) translateX(-8px);
  }
  66% {
    transform: translateY(-8px) translateX(12px);
  }
}

@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 6s ease-in-out infinite 2s;
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

.particle-float {
  animation: float 4s ease-in-out infinite;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.loading-spinner {
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #22c55e, #10b981);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #16a34a, #059669);
}
</style>
