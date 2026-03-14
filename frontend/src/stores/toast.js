import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', {
  state: () => ({
    toasts: []
  }),

  actions: {
    add(toast) {
      const id = Date.now()
      this.toasts.push({ id, ...toast })
      
      // Auto dismiss after 3 seconds
      setTimeout(() => {
        this.remove(id)
      }, toast.duration || 3000)
      
      return id
    },

    remove(id) {
      const index = this.toasts.findIndex(t => t.id === id)
      if (index > -1) {
        this.toasts.splice(index, 1)
      }
    },

    success(message) {
      return this.add({ type: 'success', message })
    },

    error(message) {
      return this.add({ type: 'error', message, duration: 5000 })
    },

    info(message) {
      return this.add({ type: 'info', message })
    },

    warning(message) {
      return this.add({ type: 'warning', message })
    }
  }
})
