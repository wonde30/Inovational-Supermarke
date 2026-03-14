import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import i18nPlugin from './plugins/i18n'
import './assets/main.css'
import './assets/theme.css'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(i18nPlugin)

// Initialize stores after Pinia is registered
import { useThemeStore } from './stores/theme'
import { useI18nStore } from './stores/i18n'

const themeStore = useThemeStore()
const i18nStore = useI18nStore()

// Initialize theme and locale from localStorage
themeStore.initTheme()

// Ensure translations are loaded before mounting the app
i18nStore.initLocale().then(async () => {
  // Double-check that translations are loaded
  console.log('=== FINAL TRANSLATION CHECK ===')
  console.log('Current locale:', i18nStore.currentLocale)
  console.log('Translations loaded:', Object.keys(i18nStore.translations))
  
  // Test critical keys
  const testKeys = ['storefront.smartShoppingDestination', 'storefront.welcomeBack', 'common.welcome']
  testKeys.forEach(key => {
    const translation = i18nStore.t(key)
    console.log(`${key}: "${translation}"`)
    if (translation === key) {
      console.error(`❌ Translation missing for: ${key}`)
    } else {
      console.log(`✅ Translation working for: ${key}`)
    }
  })
  
  app.mount('#app')
}).catch(error => {
  console.error('Failed to initialize translations:', error)
  // Mount anyway with English fallback
  app.mount('#app')
})
