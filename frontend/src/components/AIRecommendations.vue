<template>
  <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-red-600 rounded-2xl p-6 text-white shadow-2xl relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-20">
      <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
    </div>
    
    <div class="relative">
      <!-- Header -->
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center animate-bounce">
            <span class="text-2xl">🤖</span>
          </div>
          <div>
            <h3 class="text-xl font-bold">{{ t('aiRecommendations.title') }}</h3>
            <p class="text-sm text-purple-200">{{ t('aiRecommendations.personalizedForYou') }}</p>
          </div>
        </div>
        <button @click="refreshRecommendations" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg px-4 py-2 text-sm font-semibold transition-all flex items-center gap-2">
          <span class="animate-spin" v-if="loading">⏳</span>
          <span v-else>🔄</span>
          {{ t('aiRecommendations.refresh') }}
        </button>
      </div>
      
      <!-- AI Insights -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all cursor-pointer">
          <div class="text-3xl mb-2">🎯</div>
          <p class="text-sm text-purple-200 mb-1">{{ t('aiRecommendations.matchScore') }}</p>
          <p class="text-2xl font-bold">{{ matchScore }}%</p>
        </div>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all cursor-pointer">
          <div class="text-3xl mb-2">💰</div>
          <p class="text-sm text-purple-200 mb-1">{{ t('aiRecommendations.potentialSavings') }}</p>
          <p class="text-2xl font-bold">ETB {{ savings }}</p>
        </div>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all cursor-pointer">
          <div class="text-3xl mb-2">⭐</div>
          <p class="text-sm text-purple-200 mb-1">{{ t('aiRecommendations.trendingNow') }}</p>
          <p class="text-2xl font-bold">{{ trendingCount }}</p>
        </div>
      </div>
      
      <!-- Recommended Products -->
      <div class="space-y-3">
        <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
          <span>✨</span> {{ t('aiRecommendations.topPicksForYou') }}
        </h4>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div v-for="product in recommendations" :key="product.id" 
               class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all cursor-pointer group">
            <div class="flex items-center gap-4">
              <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                {{ product.icon }}
              </div>
              <div class="flex-1">
                <h5 class="font-bold text-white mb-1">{{ product.name }}</h5>
                <p class="text-sm text-purple-200 mb-2">{{ product.reason }}</p>
                <div class="flex items-center justify-between">
                  <span class="text-lg font-bold text-yellow-300">ETB {{ product.price }}</span>
                  <button @click="addToCart(product)" class="bg-white/20 hover:bg-white/30 rounded-lg px-3 py-1 text-xs font-semibold transition-all">
                    {{ t('aiRecommendations.addToCart') }}
                  </button>
                </div>
              </div>
            </div>
            
            <!-- AI Confidence Badge -->
            <div class="mt-3 flex items-center gap-2 text-xs">
              <div class="flex-1 bg-white/20 rounded-full h-1.5 overflow-hidden">
                <div class="bg-yellow-400 h-1.5 rounded-full transition-all" :style="{ width: product.confidence + '%' }"></div>
              </div>
              <span class="text-purple-200">{{ product.confidence }}% {{ t('aiRecommendations.match') }}</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- AI Learning Notice -->
      <div class="mt-6 bg-white/10 backdrop-blur-sm rounded-xl p-4 flex items-start gap-3">
        <span class="text-2xl">💡</span>
        <div class="flex-1 text-sm">
          <p class="font-semibold mb-1">{{ t('aiRecommendations.aiLearningPreferences') }}</p>
          <p class="text-purple-200">{{ t('aiRecommendations.aiLearningDescription', { count: totalInteractions }) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'
import { useTranslation } from '@/composables/useTranslation'

const { t } = useTranslation()
const cartStore = useCartStore()

const loading = ref(false)
const matchScore = ref(92)
const savings = ref(350)
const trendingCount = ref(8)
const totalInteractions = ref(147)

const recommendations = ref([
  {
    id: 1,
    name: t('aiRecommendations.freshTomatoes'),
    icon: '🍅',
    price: 45,
    reason: t('aiRecommendations.youBuyWeekly'),
    confidence: 95
  },
  {
    id: 2,
    name: t('aiRecommendations.organicMilk'),
    icon: '🥛',
    price: 85,
    reason: t('aiRecommendations.popularWithSimilar'),
    confidence: 88
  },
  {
    id: 3,
    name: t('aiRecommendations.wholeWheatBread'),
    icon: '🍞',
    price: 35,
    reason: t('aiRecommendations.frequentlyBoughtTogether'),
    confidence: 82
  },
  {
    id: 4,
    name: t('aiRecommendations.ethiopianCoffee'),
    icon: '☕',
    price: 250,
    reason: t('aiRecommendations.trendingInArea'),
    confidence: 90
  }
])

const refreshRecommendations = () => {
  loading.value = true
  setTimeout(() => {
    matchScore.value = Math.floor(Math.random() * 20) + 80
    savings.value = Math.floor(Math.random() * 300) + 200
    trendingCount.value = Math.floor(Math.random() * 10) + 5
    loading.value = false
  }, 1500)
}

const addToCart = (product) => {
  // Add to cart logic
  console.log('Adding to cart:', product)
}

onMounted(() => {
  // Simulate AI learning
  setInterval(() => {
    totalInteractions.value += Math.floor(Math.random() * 5)
  }, 5000)
})
</script>

<style scoped>
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.animate-pulse {
  animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
