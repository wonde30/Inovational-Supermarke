<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 relative overflow-hidden">
    <!-- Revolutionary Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20 animate-float"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-300 to-pink-400 rounded-full blur-3xl opacity-10 animate-pulse" style="width: 600px; height: 600px;"></div>
    </div>

    <!-- Revolutionary Categories Header -->
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
              <!-- 3D Categories Icon -->
              <div class="relative group/icon">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl blur-xl opacity-60 group-hover/icon:opacity-100 transition-opacity animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-2xl rounded-2xl flex items-center justify-center border-2 border-white/40 shadow-2xl transform group-hover/icon:scale-110 group-hover/icon:rotate-6 transition-all">
                  <span class="text-4xl">📂</span>
                </div>
              </div>
              
              <div>
                <h1 class="text-3xl lg:text-4xl font-black mb-1 bg-gradient-to-r from-white via-yellow-100 to-white bg-clip-text text-transparent animate-gradient-x">
                  Smart Categories / ምድቦች
                </h1>
                <p class="text-green-100 text-lg font-medium flex items-center gap-2">
                  <span>📊</span>
                  <span>{{ categories.length }} Categories</span>
                  <span class="mx-2">•</span>
                  <span>🏷️</span>
                  <span>Advanced Organization System</span>
                </p>
              </div>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <button @click="openBulkActions" class="group/btn relative px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 backdrop-blur-md rounded-2xl font-bold transition-all border-2 border-white/30 flex items-center gap-3 shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">⚡</span>
                <span class="relative">Bulk Actions</span>
              </button>
              
              <button @click="openModal()" class="group/btn relative px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-yellow-500/50 flex items-center gap-3 text-gray-900 transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
                <span class="text-2xl relative">➕</span>
                <span class="relative">Add Category</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-10 px-4">
      <!-- Revolutionary Search Section -->
      <div class="group relative transform transition-all duration-500 hover:scale-105 mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-xl border-2 border-gray-100 group-hover:border-blue-300 transition-all">
          <div class="flex gap-4">
            <!-- Enhanced Search -->
            <div class="flex-1 relative group/search">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within/search:text-blue-600 transition-colors">
                <span class="text-2xl">🔍</span>
              </div>
              <input 
                v-model="search" 
                @input="filterCategories"
                type="text" 
                class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-lg bg-gradient-to-r from-white to-gray-50 hover:shadow-lg" 
                placeholder="Search categories by name or description..."
              />
            </div>
            
            <!-- Sort Options -->
            <div class="relative group/sort">
              <select 
                v-model="sortBy" 
                @change="filterCategories"
                class="appearance-none pl-6 pr-12 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all bg-gradient-to-r from-white to-gray-50 cursor-pointer font-medium text-lg hover:shadow-lg"
              >
                <option value="name">Sort by Name</option>
                <option value="created_at">Sort by Date</option>
                <option value="products_count">Sort by Products</option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/sort:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revolutionary Categories Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="relative">
          <div class="absolute inset-0 bg-green-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
          <div class="relative w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center shadow-xl">
            <div class="loading-spinner w-10 h-10"></div>
          </div>
        </div>
      </div>

      <div v-else-if="filteredCategories.length === 0" class="relative group py-20">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-3xl blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
        <div class="relative text-center">
          <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gray-400 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-6xl">📂</span>
            </div>
          </div>
          <h3 class="text-3xl font-black text-gray-700 mb-4">No Categories Found</h3>
          <p class="text-gray-500 text-lg mb-8">Start organizing your products by creating categories</p>
          <button @click="openModal()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 hover:-translate-y-1">
            <span class="text-2xl">➕</span>
            <span>Create Your First Category</span>
          </button>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="category in filteredCategories" 
          :key="category.id" 
          class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
        >
          <!-- 3D Shadow Layer -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity"></div>
          
          <!-- Main Category Card -->
          <div class="relative bg-white rounded-2xl shadow-xl border-2 border-gray-100 group-hover:border-green-300 overflow-hidden transition-all flex flex-col" style="min-height: 280px;">
            <!-- Enhanced Category Header -->
            <div class="relative h-32 bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center overflow-hidden">
              <div class="text-6xl group-hover:scale-110 transition-transform duration-500">
                {{ getCategoryIcon(category.name) }}
              </div>
              
              <!-- Products Count Badge -->
              <div class="absolute top-3 right-3">
                <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-cyan-600 text-white text-xs font-bold rounded-full shadow-lg">
                  {{ category.products_count || 0 }} Products
                </span>
              </div>
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-transform">
                  <span class="text-2xl">✏️</span>
                </div>
              </div>
            </div>

            <!-- Enhanced Category Details -->
            <div class="p-4 bg-gradient-to-br from-white to-gray-50 flex-1 flex flex-col">
              <!-- Category Name -->
              <h3 class="font-black text-gray-900 text-xl mb-2 group-hover:text-green-600 transition-colors">
                {{ category.name }}
              </h3>
              
              <!-- Description -->
              <p class="text-gray-600 text-sm mb-4 flex-1 line-clamp-3">
                {{ category.description || 'No description available' }}
              </p>
              
              <!-- Stats Section -->
              <div class="pt-3 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                  <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold text-gray-600">
                      {{ category.products_count || 0 }} products
                    </span>
                  </div>
                  <div class="text-xs text-gray-500">
                    Created {{ formatDate(category.created_at) }}
                  </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                  <button @click="openModal(category)" class="flex-1 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105 flex items-center justify-center gap-2">
                    <span>✏️</span>
                    <span>Edit</span>
                  </button>
                  <button @click="deleteCategory(category.id)" class="px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:scale-105">
                    🗑️
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Revolutionary Category Modal -->
    <Modal v-model="showModal" :title="editing ? 'Edit Category / ምድብ አርትዕ' : 'Add Category / ምድብ ጨምር'">
      <div class="relative">
        <!-- 3D Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl blur-2xl opacity-10"></div>
        
        <form @submit.prevent="saveCategory" class="relative space-y-6 p-6">
          <!-- Category Name -->
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
              <span class="text-lg">📝</span>
              <span>Category Name / የምድብ ስም</span>
            </label>
            <input 
              v-model="form.name" 
              type="text"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm" 
              placeholder="Enter category name..."
              required
            />
          </div>
          
          <!-- Category Description -->
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
              <span class="text-lg">📄</span>
              <span>Description / መግለጫ</span>
            </label>
            <textarea 
              v-model="form.description" 
              rows="4"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none font-medium bg-white shadow-sm resize-none" 
              placeholder="Enter category description..."
            ></textarea>
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
              <span v-else>{{ editing ? '💾' : '➕' }}</span>
              <span>{{ processing ? 'Saving...' : (editing ? 'Update Category' : 'Add Category') }}</span>
            </button>
          </div>
        </form>
      </div>
    </Modal>

    <!-- Bulk Actions Modal -->
    <Modal v-model="showBulkActions" title="Bulk Actions / በጅምላ እርምጃዎች">
      <div class="space-y-6 p-6">
        <div class="text-center">
          <div class="relative inline-block mb-4">
            <div class="absolute inset-0 bg-purple-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
            <div class="relative w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto shadow-xl">
              <span class="text-4xl">⚡</span>
            </div>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-2">Bulk Category Actions</h3>
          <p class="text-gray-600">Perform actions on multiple categories at once</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
          <button class="p-4 border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 transition-colors text-center">
            <span class="text-2xl block mb-2">📥</span>
            <span class="font-bold">Import Categories</span>
          </button>
          <button class="p-4 border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 transition-colors text-center">
            <span class="text-2xl block mb-2">📤</span>
            <span class="font-bold">Export Categories</span>
          </button>
        </div>
        
        <div class="flex justify-end gap-4">
          <button @click="showBulkActions = false" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">
            Close
          </button>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { categoriesApi } from '../../services/api'
import { useToastStore } from '../../stores/toast'
import { useTranslation } from '@/composables/useTranslation'
import Modal from '../../components/Modal.vue'

const { t } = useTranslation()
const toast = useToastStore()

// Reactive Data
const loading = ref(true)
const processing = ref(false)
const categories = ref([])
const search = ref('')
const sortBy = ref('name')
const showModal = ref(false)
const showBulkActions = ref(false)
const editing = ref(null)

const form = reactive({
  name: '',
  description: ''
})

// Computed Properties
const filteredCategories = computed(() => {
  let filtered = categories.value

  // Search filter
  if (search.value) {
    const searchTerm = search.value.toLowerCase()
    filtered = filtered.filter(category => 
      category.name.toLowerCase().includes(searchTerm) ||
      (category.description && category.description.toLowerCase().includes(searchTerm))
    )
  }

  // Sort
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.name.localeCompare(b.name)
      case 'created_at':
        return new Date(b.created_at) - new Date(a.created_at)
      case 'products_count':
        return (b.products_count || 0) - (a.products_count || 0)
      default:
        return 0
    }
  })

  return filtered
})

// Utility Functions
const getCategoryIcon = (categoryName) => {
  const icons = {
    'Electronics': '📱', 'Food': '🍞', 'Beverages': '🥤', 'Cleaning': '🧹',
    'Personal Care': '🧴', 'Office Supplies': '📎', 'Stationery': '✏️',
    'Clothing': '👕', 'Footwear': '👟', 'Home': '🏠', 'Kitchen': '🍳',
    'Sports': '⚽', 'Toys': '🧸', 'Health': '💊', 'Beauty': '💄',
    'Books': '📚', 'Grocery': '🛒', 'Automotive': '🚗', 'Garden': '🌱',
    'Pet': '🐕', 'Baby': '👶', 'Music': '🎵', 'Games': '🎮'
  }
  
  if (!categoryName) return '📂'
  
  for (const [key, icon] of Object.entries(icons)) {
    if (categoryName.toLowerCase().includes(key.toLowerCase())) return icon
  }
  
  return '📂'
}

const formatDate = (date) => {
  if (!date) return 'Unknown'
  return new Date(date).toLocaleDateString('en-ET', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric' 
  })
}

// API Functions
const fetchCategories = async () => {
  loading.value = true
  try {
    const response = await categoriesApi.getAll()
    categories.value = response.data
  } catch (e) {
    toast.error('Failed to load categories')
  } finally {
    loading.value = false
  }
}

const openModal = (category = null) => {
  editing.value = category
  if (category) {
    form.name = category.name
    form.description = category.description || ''
  } else {
    form.name = ''
    form.description = ''
  }
  showModal.value = true
}

const saveCategory = async () => {
  processing.value = true
  try {
    if (editing.value) {
      await categoriesApi.update(editing.value.id, form)
      toast.success('✅ Category updated successfully!')
    } else {
      await categoriesApi.create(form)
      toast.success('✅ Category added successfully!')
    }
    showModal.value = false
    fetchCategories()
  } catch (e) {
    toast.error(e.message || 'Failed to save category')
  } finally {
    processing.value = false
  }
}

const deleteCategory = async (id) => {
  if (!confirm('Are you sure you want to delete this category?')) return
  
  try {
    await categoriesApi.delete(id)
    toast.success('🗑️ Category deleted successfully!')
    fetchCategories()
  } catch (e) {
    toast.error('Failed to delete category')
  }
}

const openBulkActions = () => {
  showBulkActions.value = true
}

const filterCategories = () => {
  // Trigger reactivity for computed property
}

// Lifecycle
onMounted(fetchCategories)
</script>

<style scoped>
/* Revolutionary Categories Styles */
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

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
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
