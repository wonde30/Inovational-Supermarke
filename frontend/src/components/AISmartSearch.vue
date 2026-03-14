<template>
  <div class="relative">
    <!-- Search Bar -->
    <div class="relative group">
      <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
      <div class="relative bg-white rounded-2xl shadow-2xl border-2 border-purple-200 overflow-hidden">
        <div class="flex items-center">
          <!-- Search Icon -->
          <div class="pl-6 pr-4">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          
          <!-- Input -->
          <input 
            v-model="searchQuery"
            @input="handleSearch"
            @focus="showSuggestions = true"
            type="text"
            placeholder="Search with AI... Try 'fresh vegetables' or 'coffee'"
            class="flex-1 py-4 text-lg outline-none bg-transparent"
          />
          
          <!-- AI Badge -->
          <div class="px-3">
            <div class="flex items-center gap-2 bg-gradient-to-r from-purple-100 to-pink-100 px-3 py-1.5 rounded-full">
              <span class="text-sm font-bold text-purple-700">AI</span>
              <div class="w-2 h-2 bg-purple-600 rounded-full animate-pulse"></div>
            </div>
          </div>
          
          <!-- Voice Button -->
          <button 
            @click="startVoiceSearch"
            :class="isListening ? 'bg-red-500 animate-pulse' : 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700'"
            class="m-2 p-4 text-white rounded-xl transition-all transform hover:scale-105 shadow-lg"
          >
            <svg v-if="!isListening" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
            </svg>
            <svg v-else class="w-6 h-6 animate-bounce" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
              <path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
            </svg>
          </button>
          
          <!-- Camera Button -->
          <button 
            @click="startImageSearch"
            class="m-2 mr-4 p-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-xl transition-all transform hover:scale-105 shadow-lg"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
    
    <!-- AI Suggestions Dropdown -->
    <transition name="slide-down">
      <div v-if="showSuggestions && (suggestions.length > 0 || aiSuggestions.length > 0)" 
           class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border-2 border-purple-200 overflow-hidden z-50">
        
        <!-- AI Suggestions -->
        <div v-if="aiSuggestions.length > 0" class="p-4 border-b border-gray-100">
          <div class="flex items-center gap-2 mb-3">
            <span class="text-sm font-bold text-purple-700">🤖 AI Suggestions</span>
            <span class="text-xs text-gray-500">Based on your preferences</span>
          </div>
          <div class="space-y-2">
            <button 
              v-for="suggestion in aiSuggestions" 
              :key="suggestion.text"
              @click="selectSuggestion(suggestion.text)"
              class="w-full flex items-center gap-3 p-3 hover:bg-purple-50 rounded-xl transition-all group"
            >
              <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="text-xl">{{ suggestion.icon }}</span>
              </div>
              <div class="flex-1 text-left">
                <p class="font-semibold text-gray-900">{{ suggestion.text }}</p>
                <p class="text-xs text-gray-500">{{ suggestion.reason }}</p>
              </div>
              <div class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-semibold">
                {{ suggestion.confidence }}% match
              </div>
            </button>
          </div>
        </div>
        
        <!-- Regular Suggestions -->
        <div v-if="suggestions.length > 0" class="p-4">
          <div class="text-xs font-semibold text-gray-500 mb-2">Search Results</div>
          <div class="space-y-1">
            <button 
              v-for="suggestion in suggestions" 
              :key="suggestion"
              @click="selectSuggestion(suggestion)"
              class="w-full flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-all text-left"
            >
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <span class="text-gray-700">{{ suggestion }}</span>
            </button>
          </div>
        </div>
        
        <!-- Trending Searches -->
        <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 border-t border-purple-100">
          <div class="flex items-center gap-2 mb-3">
            <span class="text-sm font-bold text-purple-700">🔥 Trending Now</span>
          </div>
          <div class="flex flex-wrap gap-2">
            <button 
              v-for="trend in trendingSearches" 
              :key="trend"
              @click="selectSuggestion(trend)"
              class="px-3 py-1.5 bg-white hover:bg-purple-100 rounded-full text-sm font-medium text-gray-700 transition-all border border-purple-200"
            >
              {{ trend }}
            </button>
          </div>
        </div>
      </div>
    </transition>
    
    <!-- Voice Listening Indicator -->
    <transition name="fade">
      <div v-if="isListening" class="absolute top-full left-0 right-0 mt-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-2xl p-4 shadow-2xl">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
            </svg>
          </div>
          <div class="flex-1">
            <p class="font-bold text-lg">Listening...</p>
            <p class="text-sm text-red-100">Speak now to search</p>
          </div>
          <button @click="stopVoiceSearch" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg font-semibold transition-all">
            Stop
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const emit = defineEmits(['search'])

const searchQuery = ref('')
const showSuggestions = ref(false)
const isListening = ref(false)
const suggestions = ref([])

const aiSuggestions = ref([
  { icon: '🍅', text: 'Fresh Tomatoes', reason: 'You buy this weekly', confidence: 95 },
  { icon: '🥛', text: 'Organic Milk', reason: 'Popular with similar users', confidence: 88 },
  { icon: '☕', text: 'Ethiopian Coffee', reason: 'Trending in your area', confidence: 90 }
])

const trendingSearches = ref([
  'Fresh Vegetables',
  'Dairy Products',
  'Ethiopian Coffee',
  'Organic Foods',
  'Household Items'
])

const handleSearch = () => {
  if (searchQuery.value.length > 0) {
    // Simulate search suggestions
    suggestions.value = [
      `${searchQuery.value} - All Products`,
      `${searchQuery.value} - Best Sellers`,
      `${searchQuery.value} - On Sale`
    ]
  } else {
    suggestions.value = []
  }
  
  emit('search', searchQuery.value)
}

const selectSuggestion = (text) => {
  searchQuery.value = text
  showSuggestions.value = false
  emit('search', text)
}

const startVoiceSearch = () => {
  isListening.value = true
  
  // Simulate voice recognition
  setTimeout(() => {
    searchQuery.value = 'Fresh vegetables'
    isListening.value = false
    emit('search', searchQuery.value)
  }, 3000)
}

const stopVoiceSearch = () => {
  isListening.value = false
}

const startImageSearch = () => {
  alert('📸 Image search coming soon! Take a photo of any product to find it instantly.')
}

// Close suggestions when clicking outside
watch(searchQuery, (newVal) => {
  if (newVal.length === 0) {
    showSuggestions.value = false
  }
})
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.3s ease;
}

.slide-down-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
