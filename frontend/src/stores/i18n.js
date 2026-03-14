import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

/**
 * I18n Store - Manages language/locale state and translations
 * 
 * Features:
 * - Support for English (en), Amharic (am), and Oromo (or)
 * - Lazy-load translation files
 * - Persist locale preference to localStorage
 * - Restore locale preference on app load
 * - Translation helper function with interpolation support
 * - Missing translation key fallback
 */
export const useI18nStore = defineStore('i18n', () => {
  // Reactive state
  const locale = ref('en')
  const translations = ref({
    en: {},
    am: {},
    or: {}
  })
  const isLoading = ref(false)
  const availableLocales = [
    { code: 'en', name: 'English', nativeName: 'English', flag: 'ENG' },
    { code: 'am', name: 'Amharic', nativeName: 'አማርኛ', flag: 'AMH' },
    { code: 'or', name: 'Oromo', nativeName: 'Afaan Oromoo', flag: 'ORM' }
  ]

  // Computed properties
  const currentLocale = computed(() => locale.value)
  const locales = computed(() => availableLocales)
  const currentLocaleInfo = computed(() => {
    return availableLocales.find(l => l.code === locale.value) || availableLocales[0]
  })

  /**
   * Translation helper function
   * @param {string} key - Translation key in dot notation (e.g., 'auth.login')
   * @param {object} params - Optional parameters for interpolation (e.g., {name: 'John'})
   * @returns {string} Translated text or key itself if not found
   */
  const t = (key, params = {}) => {
    try {
      const keys = key.split('.')
      let value = translations.value[locale.value]
      
      // Check if translations are loaded
      if (!value || Object.keys(value).length === 0) {
        console.warn(`No translations loaded for locale: ${locale.value}`)
        
        // Try English fallback if not already English
        if (locale.value !== 'en' && translations.value.en && Object.keys(translations.value.en).length > 0) {
          value = translations.value.en
          console.warn(`Using English fallback for key: ${key}`)
        } else {
          return key
        }
      }
      
      // Navigate through nested object
      for (const k of keys) {
        if (value && typeof value === 'object' && k in value) {
          value = value[k]
        } else {
          // If key not found in current locale, try English as fallback
          if (locale.value !== 'en' && translations.value.en && Object.keys(translations.value.en).length > 0) {
            let fallbackValue = translations.value.en
            for (const fallbackKey of keys) {
              if (fallbackValue && typeof fallbackValue === 'object' && fallbackKey in fallbackValue) {
                fallbackValue = fallbackValue[fallbackKey]
              } else {
                fallbackValue = null
                break
              }
            }
            if (fallbackValue && typeof fallbackValue === 'string') {
              console.warn(`Translation key "${key}" not found in ${locale.value}, using English fallback`)
              return fallbackValue.replace(/\{(\w+)\}/g, (match, param) => {
                return params[param] !== undefined ? params[param] : match
              })
            }
          }
          console.warn(`Translation key not found: ${key} in locale: ${locale.value}`)
          return key
        }
      }
      
      // Ensure value is a string
      if (typeof value !== 'string') {
        console.warn(`Translation key is not a string: ${key}`)
        return key
      }
      
      // Interpolate parameters (replace {param} with actual values)
      return value.replace(/\{(\w+)\}/g, (match, param) => {
        return params[param] !== undefined ? params[param] : match
      })
    } catch (error) {
      console.error(`Translation error for key "${key}":`, error)
      return key
    }
  }

  /**
   * Set locale to specific value
   * @param {string} newLocale - 'en', 'am', or 'or'
   */
  const setLocale = async (newLocale) => {
    const validLocales = ['en', 'am', 'or']
    if (!validLocales.includes(newLocale)) {
      console.warn(`Invalid locale: ${newLocale}. Using 'en' as default.`)
      newLocale = 'en'
    }
    
    console.log(`Setting locale from ${locale.value} to ${newLocale}`)
    
    locale.value = newLocale
    await loadTranslations()
    persistLocale()
    
    console.log(`Locale set to: ${locale.value}`)
    console.log('Current translations loaded:', Object.keys(translations.value[locale.value]))
    
    // Sync with backend if user is authenticated
    await syncWithBackend(newLocale)
  }

  /**
   * Sync language preference with backend
   */
  const syncWithBackend = async (localeCode) => {
    try {
      const token = localStorage.getItem('token')
      if (token) {
        const { authApi } = await import('../services/api')
        await authApi.updateLanguage({ language: localeCode })
        
        // Update user object in localStorage
        const user = JSON.parse(localStorage.getItem('user') || '{}')
        if (user) {
          user.language = localeCode
          localStorage.setItem('user', JSON.stringify(user))
        }
      }
    } catch (error) {
      console.warn('Failed to sync language preference with backend:', error)
    }
  }

  /**
   * Cycle through available languages: en -> am -> or -> en
   */
  const cycleLocale = async () => {
    const currentIndex = availableLocales.findIndex(l => l.code === locale.value)
    const nextIndex = (currentIndex + 1) % availableLocales.length
    const nextLocale = availableLocales[nextIndex].code
    await setLocale(nextLocale)
  }

  /**
   * Toggle between English and Amharic (legacy method for backward compatibility)
   */
  const toggleLocale = async () => {
    const newLocale = locale.value === 'en' ? 'am' : 'en'
    await setLocale(newLocale)
  }

  /**
   * Load translation file for current locale
   * Lazy-loads only if not already loaded
   */
  const loadTranslations = async () => {
    try {
      isLoading.value = true
      console.log(`Loading translations for ${locale.value}...`)
      
      // Always reload to ensure fresh data
      const module = await import(`../locales/${locale.value}.json`)
      translations.value[locale.value] = module.default
      
      console.log(`✅ Loaded ${Object.keys(translations.value[locale.value]).length} translation sections for ${locale.value}`)
      console.log('Available sections:', Object.keys(translations.value[locale.value]))
      
      // Test a key to ensure it works
      const testKey = 'storefront.smartShoppingDestination'
      const testTranslation = t(testKey)
      console.log(`Test translation (${testKey}):`, testTranslation)
      
      // Ensure English is always loaded as fallback
      if (locale.value !== 'en' && (!translations.value.en || Object.keys(translations.value.en).length === 0)) {
        console.log('Loading English as fallback...')
        const enModule = await import(`../locales/en.json`)
        translations.value.en = enModule.default
        console.log('✅ English fallback loaded')
      }
      
    } catch (error) {
      console.error(`❌ Failed to load translations for ${locale.value}:`, error)
      // Fallback to English if Amharic or Oromo fails
      if (locale.value !== 'en') {
        console.log('Falling back to English...')
        locale.value = 'en'
        await loadTranslations()
      }
    } finally {
      isLoading.value = false
    }
  }

  /**
   * Persist locale preference to localStorage
   */
  const persistLocale = () => {
    try {
      localStorage.setItem('locale', locale.value)
    } catch (error) {
      console.warn('Failed to persist locale preference:', error)
    }
  }

  /**
   * Initialize locale from localStorage or default to English
   * Call this on app mount
   */
  const initLocale = async () => {
    try {
      const savedLocale = localStorage.getItem('locale')
      console.log('Initializing locale. Saved locale:', savedLocale)
      
      const validLocales = ['en', 'am', 'or']
      if (validLocales.includes(savedLocale)) {
        console.log(`Loading saved locale: ${savedLocale}`)
        await setLocale(savedLocale)
      } else {
        console.log('No valid saved locale, defaulting to English')
        await setLocale('en')
      }
      
      // Ensure all translations are loaded
      await loadTranslations()
      
      console.log('Locale initialization complete. Current locale:', locale.value)
      console.log('Translations loaded:', Object.keys(translations.value))
      
      // Test critical keys
      const testKeys = ['storefront.smartShoppingDestination', 'storefront.welcomeBack', 'common.welcome']
      testKeys.forEach(key => {
        const translation = t(key)
        console.log(`Test ${key}:`, translation)
      })
      
    } catch (error) {
      console.warn('Failed to load locale preference:', error)
      await setLocale('en')
    }
  }

  return {
    // State
    locale: currentLocale,
    translations,
    isLoading,
    
    // Getters
    currentLocale,
    locales,
    currentLocaleInfo,
    
    // Actions
    t,
    setLocale,
    cycleLocale,
    toggleLocale,
    loadTranslations,
    persistLocale,
    initLocale,
    syncWithBackend
  }
})