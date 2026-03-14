<template>
  <div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    <button 
      v-if="!isOpen"
      @click="toggleChat"
      class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 hover:from-purple-700 hover:via-pink-700 hover:to-red-700 text-white rounded-full p-4 shadow-2xl transition-all transform hover:scale-110 animate-bounce"
    >
      <div class="relative">
        <span class="text-3xl">🤖</span>
        <span v-if="unreadCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse">
          {{ unreadCount }}
        </span>
      </div>
    </button>

    <!-- Chat Window -->
    <div 
      v-if="isOpen"
      class="bg-white rounded-2xl shadow-2xl w-96 h-[600px] flex flex-col overflow-hidden border-4 border-purple-200 animate-slideUp"
    >
      <!-- Header -->
      <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 text-white p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="relative">
            <span class="text-3xl animate-bounce">🤖</span>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white animate-pulse"></span>
          </div>
          <div>
            <h3 class="font-bold text-lg">{{ botName }}</h3>
            <p class="text-xs text-purple-200">{{ isAdmin ? 'Admin Assistant' : 'Shopping Assistant' }} • Online</p>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <button @click="minimizeChat" class="hover:bg-white/20 rounded-full p-2 transition-all">
            <span class="text-xl">−</span>
          </button>
          <button @click="toggleChat" class="hover:bg-white/20 rounded-full p-2 transition-all">
            <span class="text-xl">✕</span>
          </button>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-3 border-b">
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
          <button 
            v-for="action in quickActions" 
            :key="action.text"
            @click="sendQuickMessage(action.text)"
            class="bg-white hover:bg-purple-100 border-2 border-purple-300 rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-all flex items-center gap-2 shadow-sm"
          >
            <span>{{ action.icon }}</span>
            <span>{{ action.text }}</span>
          </button>
        </div>
      </div>

      <!-- Messages -->
      <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
        <div v-for="(message, index) in messages" :key="index" class="animate-fadeIn">
          <!-- Bot Message -->
          <div v-if="message.type === 'bot'" class="flex items-start gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
              <span class="text-xl">🤖</span>
            </div>
            <div class="flex-1">
              <div class="bg-white rounded-2xl rounded-tl-none p-4 shadow-md border border-purple-100">
                <p class="text-gray-800 text-sm leading-relaxed" v-html="message.text"></p>
              </div>
              <p class="text-xs text-gray-400 mt-1 ml-2">{{ message.time }}</p>
            </div>
          </div>

          <!-- User Message -->
          <div v-else class="flex items-start gap-3 justify-end">
            <div class="flex-1 text-right">
              <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl rounded-tr-none p-4 shadow-md inline-block">
                <p class="text-sm leading-relaxed">{{ message.text }}</p>
              </div>
              <p class="text-xs text-gray-400 mt-1 mr-2">{{ message.time }}</p>
            </div>
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
              <span class="text-xl">👤</span>
            </div>
          </div>
        </div>

        <!-- Typing Indicator -->
        <div v-if="isTyping" class="flex items-start gap-3 animate-fadeIn">
          <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
            <span class="text-xl">🤖</span>
          </div>
          <div class="bg-white rounded-2xl rounded-tl-none p-4 shadow-md border border-purple-100">
            <div class="flex gap-1">
              <span class="w-2 h-2 bg-purple-400 rounded-full animate-bounce"></span>
              <span class="w-2 h-2 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
              <span class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Input Area -->
      <div class="p-4 bg-white border-t-2 border-purple-100">
        <div class="flex gap-2">
          <button 
            @click="startVoiceInput"
            :class="isListening ? 'bg-red-500 animate-pulse' : 'bg-purple-100 hover:bg-purple-200'"
            class="p-3 rounded-xl transition-all"
          >
            <span class="text-xl">{{ isListening ? '🎤' : '🎙️' }}</span>
          </button>
          <input 
            v-model="userInput"
            @keypress.enter="sendMessage"
            type="text"
            placeholder="Type your message..."
            class="flex-1 border-2 border-purple-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none transition-all"
          />
          <button 
            @click="sendMessage"
            :disabled="!userInput.trim()"
            class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white p-3 rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
          >
            <span class="text-xl">📤</span>
          </button>
        </div>
        <p class="text-xs text-gray-400 mt-2 text-center">
          Powered by AI • {{ language === 'am' ? 'በ AI የተጎለበተ' : (language === 'or' ? 'AI powered' : 'AI Powered') }}
        </p>
      </div>
    </div>

    <!-- Minimized State -->
    <div 
      v-if="isMinimized"
      @click="restoreChat"
      class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full px-6 py-3 shadow-2xl cursor-pointer hover:shadow-3xl transition-all flex items-center gap-3"
    >
      <span class="text-2xl">🤖</span>
      <span class="font-bold">{{ botName }}</span>
      <span v-if="unreadCount > 0" class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
        {{ unreadCount }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, watch } from 'vue'
import { useI18nStore } from '@/stores/i18n'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({
  isAdmin: {
    type: Boolean,
    default: false
  }
})

const i18n = useI18nStore()
const auth = useAuthStore()

const isOpen = ref(false)
const isMinimized = ref(false)
const isTyping = ref(false)
const isListening = ref(false)
const userInput = ref('')
const messages = ref([])
const messagesContainer = ref(null)
const unreadCount = ref(0)

const language = computed(() => i18n.currentLocale)

const botName = computed(() => {
  if (props.isAdmin) {
    return language.value === 'am' ? 'የአስተዳደር AI' : (language.value === 'or' ? 'AI Bulchiinsa' : 'Admin AI')
  }
  return language.value === 'am' ? 'የግዢ AI' : (language.value === 'or' ? 'AI Bittaa' : 'Shopping AI')
})

const quickActions = computed(() => {
  if (props.isAdmin) {
    return [
      { icon: '📊', text: language.value === 'am' ? 'ሪፖርት' : (language.value === 'or' ? 'Gabaasa' : 'Reports') },
      { icon: '📦', text: language.value === 'am' ? 'ምርቶች' : (language.value === 'or' ? 'Oomishaalee' : 'Products') },
      { icon: '👥', text: language.value === 'am' ? 'ተጠቃሚዎች' : (language.value === 'or' ? 'Fayyadamtoota' : 'Users') },
      { icon: '⚙️', text: language.value === 'am' ? 'ቅንብሮች' : (language.value === 'or' ? 'Qindaaina' : 'Settings') },
    ]
  }
  return [
    { icon: '🛍️', text: language.value === 'am' ? 'ምርቶች' : (language.value === 'or' ? 'Oomishaalee' : 'Products') },
    { icon: '📋', text: language.value === 'am' ? 'ትዕዛዞች' : (language.value === 'or' ? 'Ajaja' : 'Orders') },
    { icon: '💳', text: language.value === 'am' ? 'ክፍያ' : (language.value === 'or' ? 'Kaffaltii' : 'Payment') },
    { icon: '❓', text: language.value === 'am' ? 'እገዛ' : (language.value === 'or' ? 'Gargaarsa' : 'Help') },
  ]
})

const toggleChat = () => {
  isOpen.value = !isOpen.value
  isMinimized.value = false
  if (isOpen.value && messages.value.length === 0) {
    sendWelcomeMessage()
  }
  if (isOpen.value) {
    unreadCount.value = 0
  }
}

const minimizeChat = () => {
  isMinimized.value = true
  isOpen.value = false
}

const restoreChat = () => {
  isMinimized.value = false
  isOpen.value = true
  unreadCount.value = 0
}

const sendWelcomeMessage = () => {
  const welcomeMessages = {
    en: props.isAdmin 
      ? `Hello ${auth.user?.name || 'Admin'}! 👋<br><br>I'm your AI Admin Assistant. I can help you with:<br>• 📊 Analytics & Reports<br>• 📦 Product Management<br>• 👥 User Management<br>• ⚙️ System Settings<br><br>How can I assist you today?`
      : `Hello ${auth.user?.name || 'there'}! 👋<br><br>I'm your AI Shopping Assistant. I can help you with:<br>• 🛍️ Finding Products<br>• 📋 Tracking Orders<br>• 💳 Payment Issues<br>• ❓ General Questions<br><br>What would you like to know?`,
    am: props.isAdmin
      ? `ሰላም ${auth.user?.name || 'አስተዳዳሪ'}! 👋<br><br>እኔ የእርስዎ AI አስተዳደር ረዳት ነኝ። እርስዎን መርዳት እችላለሁ:<br>• 📊 ትንታኔዎች እና ሪፖርቶች<br>• 📦 የምርት አስተዳደር<br>• 👥 የተጠቃሚ አስተዳደር<br>• ⚙️ የስርዓት ቅንብሮች<br><br>ዛሬ እንዴት ልረዳዎት እችላለሁ?`
      : `ሰላም ${auth.user?.name || 'እንኳን ደህና መጡ'}! 👋<br><br>እኔ የእርስዎ AI የግዢ ረዳት ነኝ። እርስዎን መርዳት እችላለሁ:<br>• 🛍️ ምርቶችን ማግኘት<br>• 📋 ትዕዛዞችን መከታተል<br>• 💳 የክፍያ ጉዳዮች<br>• ❓ አጠቃላይ ጥያቄዎች<br><br>ምን ማወቅ ይፈልጋሉ?`,
    or: props.isAdmin
      ? `Nagaa ${auth.user?.name || 'Bulchaa'}! 👋<br><br>Ani gargaaraa AI Bulchiinsaa keessan. Isin gargaaruu nan danda'a:<br>• 📊 Xiinxala & Gabaasa<br>• 📦 Bulchiinsa Oomishaa<br>• 👥 Bulchiinsa Fayyadamtootaa<br>• ⚙️ Qindaa'ina Sirna<br><br>Har'a akkamiin isin gargaaruu danda'a?`
      : `Nagaa ${auth.user?.name || 'maqaa'}! 👋<br><br>Ani gargaaraa AI Bittaa keessan. Isin gargaaruu nan danda'a:<br>• 🛍️ Oomishaalee Argachuu<br>• 📋 Ajaja Hordofuu<br>• 💳 Dhimma Kaffaltii<br>• ❓ Gaaffilee Waliigalaa<br><br>Maal beekuu barbaaddu?`
  }

  addMessage('bot', welcomeMessages[language.value] || welcomeMessages.en)
}

const sendMessage = () => {
  if (!userInput.value.trim()) return

  const message = userInput.value.trim()
  addMessage('user', message)
  userInput.value = ''

  // Simulate AI response
  isTyping.value = true
  setTimeout(() => {
    const response = generateAIResponse(message)
    addMessage('bot', response)
    isTyping.value = false
  }, 1500)
}

const sendQuickMessage = (message) => {
  userInput.value = message
  sendMessage()
}

const addMessage = (type, text) => {
  messages.value.push({
    type,
    text,
    time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
  })
  
  if (type === 'bot' && !isOpen.value) {
    unreadCount.value++
  }

  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

const generateAIResponse = (message) => {
  const lowerMessage = message.toLowerCase()
  
  // Admin responses
  if (props.isAdmin) {
    if (lowerMessage.includes('report') || lowerMessage.includes('ሪፖርት') || lowerMessage.includes('gabaasa')) {
      return language.value === 'am' 
        ? '📊 የሽያጭ ሪፖርቶችን በ <strong>ሪፖርቶች</strong> ገጽ ላይ ማየት ይችላሉ። የዛሬውን፣ የሳምንቱን ወይም የወሩን ሪፖርት ማየት ይችላሉ።'
        : language.value === 'or'
        ? '📊 Gabaasa gurgurtaa fuula <strong>Gabaasa</strong> irratti arguu dandeessu. Gabaasa har\'aa, torban kanaa ykn ji\'a kanaa ilaaluu dandeessa.'
        : '📊 You can view sales reports in the <strong>Reports</strong> section. Check today\'s, weekly, or monthly reports with detailed analytics.'
    }
    
    if (lowerMessage.includes('product') || lowerMessage.includes('ምርት') || lowerMessage.includes('oomisha')) {
      return language.value === 'am'
        ? '📦 አዲስ ምርት ለመጨመር <strong>ምርቶች > አዲስ ምርት</strong> ይጫኑ። ስም፣ ዋጋ፣ ምድብ እና ምስል ያስፈልጋል።'
        : language.value === 'or'
        ? '📦 Oomisha haaraa ida\'uuf <strong>Oomishaalee > Oomisha Haaraa</strong> cuqaasi. Maqaa, gatii, ramaddii fi suuraa barbaachisa.'
        : '📦 To add a new product, go to <strong>Products > Add Product</strong>. You\'ll need name, price, category, and image.'
    }
    
    if (lowerMessage.includes('user') || lowerMessage.includes('ተጠቃሚ') || lowerMessage.includes('fayyadamtoo')) {
      return language.value === 'am'
        ? '👥 ተጠቃሚዎችን በ <strong>ተጠቃሚዎች</strong> ገጽ ላይ ማስተዳደር ይችላሉ። ሚናዎችን መቀየር፣ መዝጋት ወይም መሰረዝ ይችላሉ።'
        : language.value === 'or'
        ? '👥 Fayyadamtoota fuula <strong>Fayyadamtoota</strong> irratti bulchuu dandeessa. Gahee jijjiiruu, cufuu ykn haquu dandeessa.'
        : '👥 Manage users in the <strong>Users</strong> section. You can change roles, deactivate, or delete accounts.'
    }
  } 
  // Customer responses
  else {
    if (lowerMessage.includes('product') || lowerMessage.includes('ምርት') || lowerMessage.includes('oomisha')) {
      return language.value === 'am'
        ? '🛍️ ምርቶችን በ <strong>ምርቶች</strong> ገጽ ላይ ማግኘት ይችላሉ። በምድብ ማጣራት ወይም መፈለግ ይችላሉ። ምርቶቻችን ሁሉም በጥራት የተመረጡ ናቸው!'
        : language.value === 'or'
        ? '🛍️ Oomishaalee fuula <strong>Oomishaalee</strong> irratti argachuu dandeessa. Ramaddiidhaan calaluu ykn barbaaduu dandeessa. Oomishaaleen keenya hundi qulqullina qabu!'
        : '🛍️ Browse products in the <strong>Products</strong> section. Filter by category or search. All our products are quality-checked!'
    }
    
    if (lowerMessage.includes('order') || lowerMessage.includes('ትዕዛዝ') || lowerMessage.includes('ajaja')) {
      return language.value === 'am'
        ? '📋 ትዕዛዞችዎን በ <strong>ትዕዛዞቼ</strong> ገጽ ላይ መከታተል ይችላሉ። የትዕዛዝ ሁኔታ፣ የመላኪያ መረጃ እና የክፍያ ዝርዝሮችን ማየት ይችላሉ።'
        : language.value === 'or'
        ? '📋 Ajaja keessan fuula <strong>Ajaja Koo</strong> irratti hordofuu dandeessu. Haala ajajaa, odeeffannoo ergaa fi bal\'ina kaffaltii ilaaluu dandeessa.'
        : '📋 Track your orders in <strong>My Orders</strong>. View order status, shipping info, and payment details.'
    }
    
    if (lowerMessage.includes('payment') || lowerMessage.includes('ክፍያ') || lowerMessage.includes('kaffaltii')) {
      return language.value === 'am'
        ? '💳 በቻፓ፣ ቴሌብር፣ CBE ብር እና ሞባይል ባንኪንግ መክፈል ይችላሉ። ሁሉም ክፍያዎች 100% ደህንነታቸው የተጠበቀ ናቸው! 🔒'
        : language.value === 'or'
        ? '💳 Chapa, Telebirr, CBE Birr fi Mobile Banking fayyadamuun kaffaltii gochuu dandeessa. Kaffaltiin hundi 100% nageenya qabu! 🔒'
        : '💳 Pay with Chapa, Telebirr, CBE Birr, or Mobile Banking. All payments are 100% secure! 🔒'
    }
  }
  
  // Default response
  const defaultResponses = {
    en: `I understand you're asking about "${message}". Let me help you with that! Could you please provide more details?`,
    am: `"${message}" ብለው እየጠየቁ እንደሆነ ተረድቻለሁ። በዚህ ረገድ ልረዳዎት! እባክዎን ተጨማሪ ዝርዝሮችን ይስጡ?`,
    or: `"${message}" jedhamee gaafachuu keessan hubadheera. Kana irratti isin gargaaruu! Maaloo bal'ina dabalataa kennuu dandeessu?`
  }
  
  return defaultResponses[language.value] || defaultResponses.en
}

const startVoiceInput = () => {
  if (!('webkitSpeechRecognition' in window)) {
    addMessage('bot', language.value === 'am' ? 'የድምጽ ግቤት በአሳሽዎ አይደገፍም' : (language.value === 'or' ? 'Galmee sagalee browser keessan irratti hin deeggaramu' : 'Voice input not supported in your browser'))
    return
  }
  
  isListening.value = true
  
  // Simulate voice input
  setTimeout(() => {
    isListening.value = false
    addMessage('bot', language.value === 'am' ? '🎤 የድምጽ ግቤት በቅርቡ ይመጣል!' : (language.value === 'or' ? '🎤 Galmeen sagalee dhiyoo dhufa!' : '🎤 Voice input coming soon!'))
  }, 2000)
}

onMounted(() => {
  // Show welcome notification after 3 seconds
  setTimeout(() => {
    if (!isOpen.value) {
      unreadCount.value = 1
    }
  }, 3000)
})
</script>

<style scoped>
@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.animate-slideUp {
  animation: slideUp 0.3s ease-out;
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
