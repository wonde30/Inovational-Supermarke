import { computed } from 'vue'
import { useI18nStore } from '../stores/i18n'
import { translateProductName, translateCategoryName } from '../utils/productTranslations'

/**
 * Composable for translating product and category names
 */
export function useProductTranslation() {
  const i18nStore = useI18nStore()
  
  const currentLocale = computed(() => i18nStore.currentLocale)
  
  /**
   * Translate a product name to the current locale
   * @param {string} productName - Original product name
   * @returns {string} - Translated product name
   */
  const tp = (productName) => {
    return translateProductName(productName, currentLocale.value)
  }
  
  /**
   * Translate a category name to the current locale
   * @param {string} categoryName - Original category name
   * @returns {string} - Translated category name
   */
  const tc = (categoryName) => {
    return translateCategoryName(categoryName, currentLocale.value)
  }
  
  /**
   * Translate a product object (modifies name and category.name)
   * @param {Object} product - Product object
   * @returns {Object} - Product with translated name and category
   */
  const translateProduct = (product) => {
    if (!product) return product
    
    return {
      ...product,
      name: tp(product.name),
      category: product.category ? {
        ...product.category,
        name: tc(product.category.name)
      } : product.category
    }
  }
  
  /**
   * Translate an array of products
   * @param {Array} products - Array of product objects
   * @returns {Array} - Array of products with translated names
   */
  const translateProducts = (products) => {
    if (!Array.isArray(products)) return products
    return products.map(translateProduct)
  }
  
  return {
    tp,           // Translate product name
    tc,           // Translate category name
    translateProduct,
    translateProducts,
    currentLocale
  }
}
