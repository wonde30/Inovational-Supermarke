<template>
  <div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Toggle Button -->
    <button 
      v-if="!isOpen" 
      @click="toggleChat" 
      class="group relative w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-full shadow-2xl hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-110 overflow-hidden"
    >
      <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
      <div class="relative flex items-center justify-center">
        <span class="text-2xl animate-bounce">🤖</span>
      </div>
      
      <!-- Notification Badge -->
      <div v-if="hasNewMessage" class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
      
      <!-- Floating Label -->
      <div class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white px-3 py-1 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
        Admin Assistant / የአስተዳደር ረዳት
      </div>
    </button>

    <!-- Chat Window -->
    <div 
      v-if="isOpen" 
      class="group relative w-96 h-[500px] bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border-2 border-white/50 overflow-hidden transform transition-all duration-300"
    >
      <!-- Chat Header -->
      <div class="relative bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-4 text-white">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-30">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-2xl animate-float"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
              <span class="text-xl">🤖</span>
            </div>
            <div>
              <h3 class="font-black text-lg">IBMS Assistant</h3>
              <p class="text-green-100 text-sm">{{ currentLanguage === 'am' ? 'የአስተዳደር ረዳት' : currentLanguage === 'or' ? 'Gargaaraa Bulchiinsaa' : 'Admin Helper' }}</p>
            </div>
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Language Selector -->
            <select v-model="currentLanguage" class="bg-white/20 text-white text-sm rounded-lg px-2 py-1 border border-white/30 focus:outline-none">
              <option value="en" class="text-gray-900">🇺🇸 EN</option>
              <option value="am" class="text-gray-900">🇪🇹 አማ</option>
              <option value="or" class="text-gray-900">🇪🇹 ORO</option>
            </select>
            
            <button @click="toggleChat" class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
              <span class="text-lg">✕</span>
            </button>
          </div>
        </div>
      </div>
      <!-- Quick Actions -->
      <div class="relative bg-gradient-to-r from-gray-50 to-white p-3 border-b border-gray-200">
        <div class="flex gap-2 overflow-x-auto">
          <button 
            v-for="action in quickActions" 
            :key="action.id"
            @click="handleQuickAction(action)"
            class="group/btn relative px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:scale-105 whitespace-nowrap overflow-hidden"
          >
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
            <span class="relative flex items-center gap-1">
              <span>{{ action.icon }}</span>
              <span>{{ action.label[currentLanguage] }}</span>
            </span>
          </button>
        </div>
      </div>

      <!-- Chat Messages -->
      <div ref="messagesContainer" class="flex-1 p-4 overflow-y-auto space-y-4 bg-gradient-to-b from-gray-50/50 to-white/50 scroll-smooth" style="max-height: 320px; min-height: 320px;">
        <!-- Welcome Message -->
        <div v-if="messages.length === 0" class="text-center py-8">
          <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <span class="text-2xl text-white">👋</span>
          </div>
          <h4 class="font-black text-gray-900 mb-2">{{ welcomeMessage.title }}</h4>
          <p class="text-gray-600 text-sm">{{ welcomeMessage.subtitle }}</p>
        </div>

        <!-- Messages -->
        <div v-for="message in messages" :key="message.id" class="flex mb-4" :class="message.isUser ? 'justify-end' : 'justify-start'">
          <div class="max-w-[85%] group relative">
            <!-- User Message -->
            <div v-if="message.isUser" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-3 rounded-2xl rounded-br-md shadow-lg">
              <p class="text-sm font-medium whitespace-pre-wrap break-words">{{ message.text }}</p>
              <span class="text-xs text-green-100 mt-1 block">{{ formatTime(message.timestamp) }}</span>
            </div>
            
            <!-- Bot Message -->
            <div v-else class="bg-white border-2 border-gray-200 p-3 rounded-2xl rounded-bl-md shadow-lg group-hover:border-green-300 transition-colors">
              <div class="flex items-start gap-2">
                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                  <span class="text-xs text-white">🤖</span>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm text-gray-900 font-medium whitespace-pre-wrap break-words">{{ message.text }}</p>
                  <span class="text-xs text-gray-500 mt-1 block">{{ formatTime(message.timestamp) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Typing Indicator -->
        <div v-if="isTyping" class="flex justify-start mb-4">
          <div class="bg-white border-2 border-gray-200 p-3 rounded-2xl rounded-bl-md shadow-lg">
            <div class="flex items-center gap-2">
              <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                <span class="text-xs text-white">🤖</span>
              </div>
              <div class="flex gap-1">
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Chat Input -->
      <div class="relative bg-white border-t-2 border-gray-200 p-4">
        <div class="flex gap-3">
          <div class="flex-1 relative">
            <input 
              v-model="currentMessage" 
              @keypress.enter="sendMessage"
              :placeholder="inputPlaceholder"
              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium text-sm"
            />
            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
              <span class="text-lg">💬</span>
            </div>
          </div>
          
          <button 
            @click="sendMessage" 
            :disabled="!currentMessage.trim() || isTyping"
            class="group/btn relative px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none overflow-hidden"
          >
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000"></div>
            <span class="relative">
              <span v-if="isTyping" class="loading-spinner w-4 h-4"></span>
              <span v-else>📤</span>
            </span>
          </button>
        </div>
        
        <!-- Suggested Responses -->
        <div v-if="suggestedResponses.length > 0" class="mt-3 flex flex-wrap gap-2">
          <button 
            v-for="suggestion in suggestedResponses" 
            :key="suggestion"
            @click="sendSuggestion(suggestion)"
            class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-full border border-gray-300 transition-colors"
          >
            {{ suggestion }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, watch } from 'vue'
import { chatbotService } from '../services/chatbotApi'

const isOpen = ref(false)
const currentLanguage = ref('en')
const currentMessage = ref('')
const messages = ref([])
const isTyping = ref(false)
const hasNewMessage = ref(false)
const messagesContainer = ref(null)
const suggestedResponses = ref([])

// Multilingual content
const welcomeMessage = computed(() => {
  const messages = {
    en: {
      title: 'Welcome to IBMS Assistant!',
      subtitle: 'I can help you with admin tasks, system navigation, and answer questions in English, Amharic, or Oromifa.'
    },
    am: {
      title: 'ወደ IBMS ረዳት እንኳን በደህና መጡ!',
      subtitle: 'የአስተዳደር ስራዎች፣ የስርዓት አሰሳ እና ጥያቄዎችን በእንግሊዝኛ፣ በአማርኛ ወይም በኦሮምኛ መመለስ እችላለሁ።'
    },
    or: {
      title: 'Gargaaraa IBMS-tti Baga Nagaan Dhuftan!',
      subtitle: 'Hojiiwwan bulchiinsaa, navigeeshinii sisteemii fi gaaffilee Afaan Ingilizii, Amaaraa ykn Oromootiin deebisuu nan danda\'a.'
    }
  }
  return messages[currentLanguage.value]
})

const inputPlaceholder = computed(() => {
  const placeholders = {
    en: 'Ask me anything about the system...',
    am: 'ስለ ስርዓቱ ማንኛውንም ይጠይቁኝ...',
    or: 'Waa\'ee sisteemichaa waan kamiyyuu na gaafadhaa...'
  }
  return placeholders[currentLanguage.value]
})
const quickActions = computed(() => [
  {
    id: 'help',
    icon: '❓',
    label: {
      en: 'Help',
      am: 'እርዳታ',
      or: 'Gargaarsa'
    }
  },
  {
    id: 'navigation',
    icon: '🧭',
    label: {
      en: 'Navigate',
      am: 'አሰሳ',
      or: 'Navigeeshinii'
    }
  },
  {
    id: 'reports',
    icon: '📊',
    label: {
      en: 'Reports',
      am: 'ሪፖርቶች',
      or: 'Gabaasota'
    }
  },
  {
    id: 'users',
    icon: '👥',
    label: {
      en: 'Users',
      am: 'ተጠቃሚዎች',
      or: 'Fayyadamtoota'
    }
  }
])

const toggleChat = () => {
  isOpen.value = !isOpen.value
  if (isOpen.value) {
    hasNewMessage.value = false
    nextTick(() => {
      scrollToBottom()
    })
  }
}

const sendMessage = () => {
  if (!currentMessage.value.trim() || isTyping.value) return
  
  const userMessage = {
    id: Date.now(),
    text: currentMessage.value,
    isUser: true,
    timestamp: new Date()
  }
  
  messages.value.push(userMessage)
  const messageText = currentMessage.value.toLowerCase()
  currentMessage.value = ''
  
  // Scroll to bottom immediately after user message
  nextTick(() => {
    scrollToBottom()
  })
  
  // Show typing indicator
  isTyping.value = true
  
  // Simulate bot response delay
  setTimeout(() => {
    const botResponse = generateResponse(messageText)
    messages.value.push({
      id: Date.now() + 1,
      text: botResponse,
      isUser: false,
      timestamp: new Date()
    })
    
    isTyping.value = false
    updateSuggestedResponses(messageText)
    
    // Scroll to bottom after bot response
    nextTick(() => {
      scrollToBottom()
    })
  }, 1000 + Math.random() * 1000) // Random delay between 1-2 seconds
}
const sendSuggestion = (suggestion) => {
  currentMessage.value = suggestion
  sendMessage()
}

const handleQuickAction = (action) => {
  // Generate response based on action using the chatbot service
  let response = ''
  
  switch (action.id) {
    case 'help':
      response = chatbotService.getDefaultResponse(currentLanguage.value)
      break
    case 'navigation':
      response = chatbotService.getNavigationHelp('general navigation', currentLanguage.value)
      break
    case 'reports':
      response = chatbotService.getResponse('reports', currentLanguage.value)
      break
    case 'users':
      response = chatbotService.getResponse('users', currentLanguage.value)
      break
    default:
      response = chatbotService.getDefaultResponse(currentLanguage.value)
  }
  
  messages.value.push({
    id: Date.now(),
    text: response,
    isUser: false,
    timestamp: new Date()
  })
  
  updateSuggestedResponses(action.id)
  
  // Ensure scroll to bottom after quick action
  nextTick(() => {
    scrollToBottom()
  })
}

const generateResponse = (messageText) => {
  // Use the chatbot service to generate intelligent responses
  return chatbotService.getResponse(messageText, currentLanguage.value)
}

const updateSuggestedResponses = (context) => {
  const suggestions = {
    en: ['How do I add users?', 'Show me reports', 'Navigate to products', 'Help with sales'],
    am: ['ተጠቃሚዎችን እንዴት እጨምራለሁ?', 'ሪፖርቶችን አሳየኝ', 'ወደ ምርቶች አሰስ', 'ከሽያጭ ጋር እርዳታ'],
    or: ['Fayyadamtoota akkamitti dabaluu danda\'a?', 'Gabaasota na argisiisi', 'Gara oomishaaleetti navigeeshini', 'Gurgurtaa irratti gargaarsa']
  }
  
  suggestedResponses.value = suggestions[currentLanguage.value] || []
}

const formatTime = (timestamp) => {
  return new Date(timestamp).toLocaleTimeString('en-US', { 
    hour: '2-digit', 
    minute: '2-digit' 
  })
}

const scrollToBottom = () => {
  if (messagesContainer.value) {
    // Use requestAnimationFrame to ensure DOM is updated
    requestAnimationFrame(() => {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    })
  }
}

onMounted(() => {
  // Show initial suggestions
  updateSuggestedResponses('initial')
})

// Watch for messages changes and auto-scroll
watch(messages, () => {
  nextTick(() => {
    scrollToBottom()
  })
}, { deep: true })

// Watch for typing indicator changes and auto-scroll
watch(isTyping, () => {
  if (isTyping.value) {
    nextTick(() => {
      scrollToBottom()
    })
  }
})
</script>
<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(2deg); }
}

.animate-float {
  animation: float 4s ease-in-out infinite;
}

.loading-spinner {
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Enhanced scrollbar styling */
.overflow-y-auto {
  scrollbar-width: thin;
  scrollbar-color: #c1c1c1 #f1f1f1;
}

.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #10b981, #059669);
  border-radius: 3px;
  transition: background 0.3s ease;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #059669, #047857);
}

/* Smooth scroll behavior */
.scroll-smooth {
  scroll-behavior: smooth;
}

/* Message animation */
.message-enter-active {
  transition: all 0.3s ease-out;
}

.message-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.message-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>