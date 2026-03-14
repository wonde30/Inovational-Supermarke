import { defineStore } from 'pinia'

/**
 * Theme Store - Manages dark/light mode state and persistence
 * 
 * Features:
 * - Toggle between light and dark modes
 * - Persist theme preference to localStorage
 * - Restore theme preference on app load
 * - Apply theme by setting data-theme attribute on document root
 */
export const useThemeStore = defineStore('theme', {
  state: () => ({
    isDark: false
  }),

  getters: {
    /**
     * Get current theme as string ('dark' or 'light')
     */
    currentTheme: (state) => state.isDark ? 'dark' : 'light'
  },

  actions: {
    /**
     * Toggle between light and dark modes
     */
    toggleTheme() {
      this.isDark = !this.isDark
      this.applyTheme()
      this.persistTheme()
    },

    /**
     * Set theme to specific value
     * @param {string} theme - 'dark' or 'light'
     */
    setTheme(theme) {
      if (theme !== 'dark' && theme !== 'light') {
        console.warn(`Invalid theme: ${theme}. Using 'light' as default.`)
        theme = 'light'
      }
      this.isDark = theme === 'dark'
      this.applyTheme()
      this.persistTheme()
    },

    /**
     * Apply theme by setting dark class on document root
     */
    applyTheme() {
      if (this.isDark) {
        document.documentElement.classList.add('dark')
        document.documentElement.setAttribute('data-theme', 'dark')
      } else {
        document.documentElement.classList.remove('dark')
        document.documentElement.removeAttribute('data-theme')
      }
    },

    /**
     * Persist theme preference to localStorage
     */
    persistTheme() {
      try {
        localStorage.setItem('theme', this.currentTheme)
      } catch (error) {
        console.warn('Failed to persist theme preference:', error)
      }
    },

    /**
     * Initialize theme from localStorage or default to light mode
     * Call this on app mount
     */
    initTheme() {
      try {
        const savedTheme = localStorage.getItem('theme')
        if (savedTheme === 'dark' || savedTheme === 'light') {
          this.setTheme(savedTheme)
        } else {
          this.setTheme('light')
        }
      } catch (error) {
        console.warn('Failed to load theme preference:', error)
        this.setTheme('light')
      }
    }
  }
})
