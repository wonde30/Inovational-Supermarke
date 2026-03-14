import { useI18nStore } from '@/stores/i18n'

/**
 * Global i18n plugin for Vue 3
 * Makes translation function available globally as $t
 */
export default {
  install(app) {
    const i18nStore = useI18nStore()
    
    // Make translation function available globally
    app.config.globalProperties.$t = i18nStore.t
    
    // Provide translation function for composition API
    app.provide('$t', i18nStore.t)
    app.provide('i18nStore', i18nStore)
  }
}