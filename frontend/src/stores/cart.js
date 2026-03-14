import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    discount: 0,
    taxRate: 15,  // 15% VAT for Ethiopia
    includeVAT: true  // Toggle for VAT inclusion
  }),

  getters: {
    itemCount: (state) => state.items.reduce((sum, item) => sum + item.quantity, 0),
    
    subtotal: (state) => {
      return state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    },
    
    tax: (state) => {
      if (!state.includeVAT) return 0  // Return 0 if VAT is not included
      const subtotal = state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0)
      return (subtotal * state.taxRate) / 100
    },
    
    total() {
      return Math.max(0, this.subtotal + this.tax - this.discount)
    }
  },

  actions: {
    addItem(product, quantity = 1) {
      const existingItem = this.items.find(item => item.id === product.id)
      
      if (existingItem) {
        existingItem.quantity += quantity
      } else {
        this.items.push({
          id: product.id,
          name: product.name,
          price: parseFloat(product.price),
          quantity,
          maxQuantity: product.quantity,
          image: product.image
        })
      }
    },

    updateQuantity(productId, quantity) {
      const item = this.items.find(item => item.id === productId)
      if (item) {
        item.quantity = Math.max(1, Math.min(quantity, item.maxQuantity))
      }
    },

    removeItem(productId) {
      const index = this.items.findIndex(item => item.id === productId)
      if (index > -1) {
        this.items.splice(index, 1)
      }
    },

    setDiscount(amount) {
      this.discount = Math.max(0, amount)
    },

    setTaxRate(rate) {
      this.taxRate = Math.max(0, rate)
    },

    toggleVAT(include) {
      this.includeVAT = include
    },

    clear() {
      this.items = []
      this.discount = 0
    },

    getItemsForApi() {
      return this.items.map(item => ({
        product_id: item.id,
        quantity: item.quantity
      }))
    }
  }
})
