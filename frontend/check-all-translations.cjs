// Comprehensive check for all translation keys used in Home.vue
const fs = require('fs')
const path = require('path')

async function checkAllTranslations() {
  console.log('🔍 Comprehensive Translation Check...')
  
  try {
    // Load translation files
    const enPath = path.join(__dirname, 'src/locales/en.json')
    const amPath = path.join(__dirname, 'src/locales/am.json')
    const orPath = path.join(__dirname, 'src/locales/or.json')
    
    const enTranslations = JSON.parse(fs.readFileSync(enPath, 'utf8'))
    const amTranslations = JSON.parse(fs.readFileSync(amPath, 'utf8'))
    const orTranslations = JSON.parse(fs.readFileSync(orPath, 'utf8'))
    
    // Load Home.vue file
    const homeVuePath = path.join(__dirname, 'src/views/storefront/Home.vue')
    const homeVueContent = fs.readFileSync(homeVuePath, 'utf8')
    
    // Extract all translation keys from Home.vue
    const translationKeyRegex = /t\(['"`]([^'"`]+)['"`]\)/g
    const matches = []
    let match
    
    while ((match = translationKeyRegex.exec(homeVueContent)) !== null) {
      matches.push(match[1])
    }
    
    // Remove duplicates
    const uniqueKeys = [...new Set(matches)]
    
    console.log(`\n📝 Found ${uniqueKeys.length} unique translation keys in Home.vue:`)
    uniqueKeys.forEach(key => console.log(`  - ${key}`))
    
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
    
    console.log('\n🧪 Testing all keys across languages:')
    
    let missingKeys = []
    
    uniqueKeys.forEach(key => {
      const enValue = getTranslation(enTranslations, key)
      const amValue = getTranslation(amTranslations, key)
      const orValue = getTranslation(orTranslations, key)
      
      const enMissing = enValue === key
      const amMissing = amValue === key
      const orMissing = orValue === key
      
      if (enMissing || amMissing || orMissing) {
        console.log(`\n❌ MISSING: ${key}`)
        if (enMissing) console.log(`  🇺🇸 EN: MISSING`)
        else console.log(`  🇺🇸 EN: "${enValue}"`)
        
        if (amMissing) console.log(`  🇪🇹 AM: MISSING`)
        else console.log(`  🇪🇹 AM: "${amValue}"`)
        
        if (orMissing) console.log(`  🇪🇹 OR: MISSING`)
        else console.log(`  🇪🇹 OR: "${orValue}"`)
        
        missingKeys.push(key)
      } else {
        console.log(`✅ ${key}`)
      }
    })
    
    if (missingKeys.length === 0) {
      console.log('\n🎉 All translation keys are available in all languages!')
    } else {
      console.log(`\n⚠️  Found ${missingKeys.length} keys with missing translations:`)
      missingKeys.forEach(key => console.log(`  - ${key}`))
    }
    
  } catch (error) {
    console.error('❌ Check failed:', error.message)
  }
}

checkAllTranslations()