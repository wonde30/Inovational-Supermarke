<template>
  <!-- Floating Chat Button -->
  <div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Window -->
    <transition name="slide-up">
      <div v-if="isOpen" class="mb-4 w-96 max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4 text-white">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-bounce">
                <span class="text-2xl">🤖</span>
              </div>
              <div>
                <h3 class="font-bold text-lg">AI Shopping Assistant</h3>
                <div class="flex items-center gap-2 text-sm text-purple-200">
                  <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                  <span>Online & Ready to Help</span>
                </div>
              </div>
            </div>
            <button @click="isOpen = false" class="text-white/80 hover:text-white transition-all">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        
        <!-- Messages -->
        <div class="h-96 overflow-y-auto p-4 bg-gray-50 space-y-4" ref="messagesContainer">
          <div v-for="(message, index) in messages" :key="index" 
               :class="message.type === 'user' ? 'flex justify-end' : 'flex justify-start'">
            <div :class="message.type === 'user' 
                 ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl rounded-tr-sm px-4 py-3 max-w-[80%]' 
                 : 'bg-white text-gray-800 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[80%] shadow-md'">
              <p class="text-sm">{{ message.text }}</p>
              <p class="text-xs mt-1 opacity-70">{{ message.time }}</p>
            </div>
          </div>
          
          <!-- Typing Indicator -->
          <div v-if="isTyping" class="flex justify-start">
            <div class="bg-white text-gray-800 rounded-2xl rounded-tl-sm px-4 py-3 shadow-md">
              <div class="flex items-center gap-2">
                <div class="flex gap-1">
                  <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce"></span>
                  <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                  <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
                <span class="text-xs text-gray-500">AI is thinking...</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="p-3 bg-white border-t border-gray-200">
          <div class="flex gap-2 mb-3 overflow-x-auto pb-2">
            <button v-for="action in quickActions" :key="action.text"
                    @click="sendQuickMessage(action.text)"
                    class="flex-shrink-0 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-full px-4 py-2 text-xs font-semibold transition-all">
              {{ action.icon }} {{ action.text }}
            </button>
          </div>
        </div>
        
        <!-- Input -->
        <div class="p-4 bg-white border-t border-gray-200">
          <div class="flex gap-2">
            <input 
              v-model="userInput" 
              @keyup.enter="sendMessage"
              type="text" 
              placeholder="Ask me anything..."
              class="flex-1 border-2 border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none transition-all"
            />
            <button @click="sendMessage" 
                    :disabled="!userInput.trim()"
                    class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl px-4 py-2 font-semibold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </transition>
    
    <!-- Chat Button -->
    <button @click="toggleChat" 
            class="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-all transform hover:scale-110 relative">
      <span class="text-3xl" v-if="!isOpen">🤖</span>
      <svg v-else class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
      
      <!-- Notification Badge -->
      <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-bounce">
        {{ unreadCount }}
      </span>
      
      <!-- Pulse Animation -->
      <span class="absolute inset-0 rounded-full bg-purple-600 animate-ping opacity-75"></span>
    </button>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted } from 'vue'

const isOpen = ref(false)
const isTyping = ref(false)
const userInput = ref('')
const unreadCount = ref(0)
const messagesContainer = ref(null)

const messages = ref([
  {
    type: 'bot',
    text: 'Hello! 👋 I am your AI Shopping Assistant. How can I help you today?',
    time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
  }
])

const quickActions = ref([
  { icon: '🔍', text: 'Find Products' },
  { icon: '💰', text: 'Best Deals' },
  { icon: '📦', text: 'Track Order' },
  { icon: '❓', text: 'Help' }
])

const aiResponses = {
  'find products': 'I can help you find products! What are you looking for? Try searching for groceries, electronics, or household items.',
  'best deals': 'Great choice! 🎉 Here are today best deals:\n\n🍅 Fresh Tomatoes - 30% OFF\n🥛 Organic Milk - Buy 2 Get 1 Free\n☕ Ethiopian Coffee - ETB 50 OFF\n\nWould you like to add any to your cart?',
  'track order': 'I can help you track your order! Please provide your order number, or I can show you your recent orders.',
  'help': 'I am here to help! I can:\n\n✅ Find products\n✅ Show you deals\n✅ Track orders\n✅ Answer questions\n✅ Provide recommendations\n\nWhat would you like to know?',
  'default': 'That is a great question! 🤔 Based on your shopping history, I recommend checking out our fresh produce section. We have amazing deals on vegetables and fruits today!'
}

const toggleChat = () => {
  isOpen.value = !isOpen.value
  if (isOpen.value) {
    unreadCount.value = 0
    nextTick(() => {
      scrollToBottom()
    })
  }
}

const sendMessage = () => {
  if (!userInput.value.trim()) return
  
  // Add user message
  messages.value.push({
    type: 'user',
    text: userInput.value,
    time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
  })
  
  const userMessage = userInput.value.toLowerCase()
  userInput.value = ''
  
  // Show typing indicator
  isTyping.value = true
  scrollToBottom()
  
  // Simulate AI response
  setTimeout(() => {
    isTyping.value = false
    
    // Find matching response
    let response = aiResponses.default
    for (const [key, value] of Object.entries(aiResponses)) {
      if (userMessage.includes(key)) {
        response = value
        break
      }
    }
    
    messages.value.push({
      type: 'bot',
      text: response,
      time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
    })
    
    scrollToBottom()
  }, 1500)
}

const sendQuickMessage = (text) => {
  userInput.value = text
  sendMessage()
}

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

onMounted(() => {
  // Simulate new message notification
  setTimeout(() => {
    if (!isOpen.value) {
      unreadCount.value = 1
    }
  }, 5000)
})
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.3s ease;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

.animate-bounce {
  animation: bounce 1s infinite;
}

@keyframes ping {
  75%, 100% {
    transform: scale(2);
    opacity: 0;
  }
}

.animate-ping {
  animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #9333ea, #ec4899);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #7e22ce, #db2777);
}
</style>
