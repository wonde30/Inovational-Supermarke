#!/usr/bin/env node

/**
 * Translation validation script
 * Tests that all translation files are valid and contain expected keys
 */

import fs from 'fs'
import path from 'path'
import { fileURLToPath } from 'url'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const locales = ['en', 'am', 'or']
const criticalKeys = [
  'storefront.smartShoppingDestination',
  'storefront.welcomeBack',
  'common.welcome',
  'storefront.smartSuperMarket',
  'auth.login',
  'auth.register'
]

console.log('🔍 Testing translation files...\n')

function getNestedValue(obj, keyPath) {
  return keyPath.split('.').reduce((current, key) => {
    return current && current[key] !== undefined ? current[key] : undefined
  }, obj)
}

let allValid = true

for (const locale of locales) {
  const filePath = path.join(__dirname, 'src', 'locales', `${locale}.json`)
  
  console.log(`📁 Testing ${locale}.json...`)
  
  try {
    // Check if file exists
    if (!fs.existsSync(filePath)) {
      console.error(`❌ File not found: ${filePath}`)
      allValid = false
      continue
    }
    
    // Read and parse JSON
    const content = fs.readFileSync(filePath, 'utf8')
    const translations = JSON.parse(content)
    
    console.log(`✅ Valid JSON with ${Object.keys(translations).length} sections`)
    
    // Test critical keys
    for (const key of criticalKeys) {
      const value = getNestedValue(translations, key)
      if (value === undefined) {
        console.error(`❌ Missing key: ${key}`)
        allValid = false
      } else if (typeof value !== 'string') {
        console.error(`❌ Invalid type for ${key}: expected string, got ${typeof value}`)
        allValid = false
      } else {
        console.log(`✅ ${key}: "${value.substring(0, 50)}${value.length > 50 ? '...' : ''}"`)
      }
    }
    
  } catch (error) {
    console.error(`❌ Error processing ${locale}.json:`, error.message)
    allValid = false
  }
  
  console.log('')
}

if (allValid) {
  console.log('🎉 All translation files are valid!')
  process.exit(0)
} else {
  console.log('💥 Some translation files have issues!')
  process.exit(1)
}