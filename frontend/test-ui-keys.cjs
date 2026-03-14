// Test the specific keys that were showing as raw in the UI
const fs = require('fs')
const path = require('path')

async function testUIKeys() {
  console.log('🧪 Testing UI Keys That Were Showing as Raw...')
  
  try {
    // Load translation files
    const enPath = path.join(__dirname, 'src/locales/en.json')
    const amPath = path.join(__dirname, 'src/locales/am.json')
    const orPath = path.join(__dirname, 'src/locales/or.json')
    
    const enTranslations = JSON.parse(fs.readFileSync(enPath, 'utf8'))
    const amTranslations = JSON.parse(fs.readFileSync(amPath, 'utf8'))
    const orTranslations = JSON.parse(fs.readFileSync(orPath, 'utf8'))
    
    // Test key translation function
    function getTranslation(translations, key) {
      const keys = key.split('.')
      let value = translations
      
      for (const k of keys) {
        if (value && typeof value === 'object' && k in value) {
          value = value[k]
        } else {
          return key // Return key if not found
        }
      }
      
      return typeof value === 'string' ? value : key
    }
    
    // Test the specific keys that were showing as raw in the screenshot
    const criticalKeys = [
      'storefront.smartShoppingDestination',
      'storefront.welcomeBack',
      'storefront.searchProducts',
      'storefront.cartIsEmpty',
      'storefront.subtotal',
      'auth.login',
      'auth.register'
    ]
    
    console.log('\n📝 Testing Critical UI Keys:')
    
    criticalKeys.forEach(key => {
      console.log(`\n🔍 Testing: ${key}`)
      
      const enValue = getTranslation(enTranslations, key)
      const amValue = getTranslation(amTranslations, key)
      const orValue = getTranslation(orTranslations, key)
      
      const enStatus = enValue === key ? '❌ MISSING' : '✅ FOUND'
      const amStatus = amValue === key ? '❌ MISSING' : '✅ FOUND'
      const orStatus = orValue === key ? '❌ MISSING' : '✅ FOUND'
      
      console.log(`  🇺🇸 EN: ${enStatus} "${enValue}"`)
      console.log(`  🇪🇹 AM: ${amStatus} "${amValue}"`)
      console.log(`  🇪🇹 OR: ${orStatus} "${orValue}"`)
    })
    
    console.log('\n✅ Critical UI keys test completed!')
    
  } catch (error) {
    console.error('❌ Test failed:', error.message)
  }
}

testUIKeys()