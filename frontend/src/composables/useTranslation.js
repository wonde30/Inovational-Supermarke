import { computed } from 'vue'
import { useI18nStore } from '@/stores/i18n'

/**
 * Composable for using translations in Vue components
 * 
 * Usage:
 * const { t, locale, currentLocaleInfo } = useTranslation()
 * 
 * In template:
 * {{ t('common.welcome') }}
 * {{ t('auth.login') }}
 * {{ t('messages.saveSuccess', { name: 'John' }) }}
 */
export function useTranslation() {
  const i18nStore = useI18nStore()

  // Create a reactive translation function that updates when locale changes
  const t = (key, params = {}) => {
    try {
      // Force reactivity by accessing the store getter directly
      const translation = i18nStore.t(key, params)
      
      // If we get back the key itself, it means translation failed
      if (translation === key) {
        console.warn(`Translation missing for key: ${key} in locale: ${i18nStore.currentLocale}`)
        
        // Try to provide a better fallback for common keys
        if (key.includes('.')) {
          const parts = key.split('.')
          const lastPart = parts[parts.length - 1]
          // Convert camelCase to readable text
          return lastPart.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase())
        }
      }
      
      return translation
    } catch (error) {
      console.warn(`Translation error for key "${key}":`, error)
      return key
    }
  }

  return {
    t,
    locale: computed(() => i18nStore.currentLocale),
    currentLocaleInfo: computed(() => i18nStore.currentLocaleInfo),
    availableLocales: computed(() => i18nStore.locales),
    isAmharic: computed(() => i18nStore.currentLocale === 'am'),
    isEnglish: computed(() => i18nStore.currentLocale === 'en'),
    isOromo: computed(() => i18nStore.currentLocale === 'or'),
    setLocale: i18nStore.setLocale,
    cycleLocale: i18nStore.cycleLocale
  }
}
