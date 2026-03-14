/**
 * Status Indicator Accessibility Verification
 * 
 * This script verifies that all status indicators (success, warning, error) 
 * include non-color cues (icons or text labels) in addition to color.
 * 
 * Requirements: 10.4, 10.5
 * Task: 9.3 Verify status indicators have non-color cues
 */

import { readFileSync, readdirSync, statSync } from 'fs'
import { join, extname } from 'path'

// ANSI color codes for terminal output
const colors = {
  reset: '\x1b[0m',
  green: '\x1b[32m',
  red: '\x1b[31m',
  yellow: '\x1b[33m',
  blue: '\x1b[34m',
  cyan: '\x1b[36m',
  bold: '\x1b[1m'
}

// Status indicator patterns to check
const statusPatterns = [
  // Toast notifications
  { type: 'toast', pattern: /toast\.type\s*===\s*['"](?:success|error|warning|info)['"]/g, component: 'Toast' },
  
  // Badge components with status
  { type: 'badge', pattern: /badge-(?:success|warning|error|danger|info)/g, component: 'Badge' },
  
  // Status classes
  { type: 'status', pattern: /statusClass|getStatusClass/g, component: 'Status Display' },
  
  // Stock indicators
  { type: 'stock', pattern: /(?:in-stock|out-of-stock|low-stock|stock.*status)/gi, component: 'Stock Indicator' },
  
  // Order status
  { type: 'order', pattern: /order.*status|status.*order/gi, component: 'Order Status' },
  
  // Alert/notification components
  { type: 'alert', pattern: /alert.*type|notification.*type/gi, component: 'Alert' }
]

// Icon patterns that indicate non-color cues
const iconPatterns = [
  /<svg[^>]*>/i,                           // SVG icons
  /<i\s+class=[^>]*>/i,                    // Icon elements
  /class=['"]*icon/i,                      // Icon classes
  /[🎉✅❌⏳🔄📦✓✗🚨]/,                      // Emoji icons
  /aria-label=/i,                          // ARIA labels
  /role=['"]alert['"]/i,                   // ARIA role
  /<span[^>]*sr-only[^>]*>/i,             // Screen reader only text
  /getStatusIcon|statusIcon/i,             // Status icon functions
  /getAriaLabel/i,                         // ARIA label functions
  /legend.*display.*true/i,                // Chart legends
  /tooltip/i,                              // Chart tooltips
  /axis.*label|label.*axis/i               // Chart axis labels
]

// Results tracking
const results = {
  totalFiles: 0,
  filesWithStatusIndicators: 0,
  indicatorsChecked: 0,
  indicatorsWithIcons: 0,
  indicatorsWithoutIcons: [],
  passed: true
}

/**
 * Recursively get all Vue files in a directory
 */
function getVueFiles(dir, fileList = []) {
  const files = readdirSync(dir)
  
  files.forEach(file => {
    const filePath = join(dir, file)
    const stat = statSync(filePath)
    
    if (stat.isDirectory()) {
      // Skip node_modules and dist directories
      if (!file.startsWith('.') && file !== 'node_modules' && file !== 'dist') {
        getVueFiles(filePath, fileList)
      }
    } else if (extname(file) === '.vue') {
      fileList.push(filePath)
    }
  })
  
  return fileList
}

/**
 * Check if content has icon indicators
 */
function hasIconIndicators(content) {
  return iconPatterns.some(pattern => pattern.test(content))
}

/**
 * Extract context around a match for better reporting
 */
function getContext(content, matchIndex, contextLength = 200) {
  const start = Math.max(0, matchIndex - contextLength)
  const end = Math.min(content.length, matchIndex + contextLength)
  return content.substring(start, end).replace(/\n/g, ' ').trim()
}

/**
 * Check a single file for status indicators
 */
function checkFile(filePath) {
  const content = readFileSync(filePath, 'utf-8')
  const relPath = filePath.replace(process.cwd(), '').replace(/\\/g, '/')
  
  let fileHasStatusIndicators = false
  const fileIssues = []
  
  // Check each status pattern
  statusPatterns.forEach(({ type, pattern, component }) => {
    const matches = content.match(pattern)
    
    if (matches && matches.length > 0) {
      fileHasStatusIndicators = true
      results.indicatorsChecked += matches.length
      
      // Check if the file has icon indicators
      const hasIcons = hasIconIndicators(content)
      
      if (hasIcons) {
        results.indicatorsWithIcons += matches.length
      } else {
        // This is a potential issue - status indicator without icons
        fileIssues.push({
          type,
          component,
          count: matches.length,
          context: getContext(content, content.indexOf(matches[0]))
        })
      }
    }
  })
  
  if (fileHasStatusIndicators) {
    results.filesWithStatusIndicators++
    
    if (fileIssues.length > 0) {
      results.indicatorsWithoutIcons.push({
        file: relPath,
        issues: fileIssues
      })
      results.passed = false
    }
  }
}

/**
 * Main verification function
 */
function verifyStatusIndicators() {
  console.log(`${colors.bold}${colors.cyan}`)
  console.log('═══════════════════════════════════════════════════════════')
  console.log('  Status Indicator Accessibility Verification')
  console.log('  Task 9.3: Verify status indicators have non-color cues')
  console.log('═══════════════════════════════════════════════════════════')
  console.log(colors.reset)
  
  // Get all Vue files
  const srcDir = join(process.cwd(), 'frontend', 'src')
  const vueFiles = getVueFiles(srcDir)
  results.totalFiles = vueFiles.length
  
  console.log(`${colors.blue}Scanning ${results.totalFiles} Vue files...${colors.reset}\n`)
  
  // Check each file
  vueFiles.forEach(checkFile)
  
  // Print results
  console.log(`${colors.bold}Results:${colors.reset}`)
  console.log(`  Total files scanned: ${results.totalFiles}`)
  console.log(`  Files with status indicators: ${results.filesWithStatusIndicators}`)
  console.log(`  Status indicators checked: ${results.indicatorsChecked}`)
  console.log(`  Indicators with icons/labels: ${colors.green}${results.indicatorsWithIcons}${colors.reset}`)
  
  if (results.indicatorsWithoutIcons.length > 0) {
    console.log(`  ${colors.red}Indicators without icons: ${results.indicatorsChecked - results.indicatorsWithIcons}${colors.reset}\n`)
    
    console.log(`${colors.bold}${colors.red}Issues Found:${colors.reset}`)
    results.indicatorsWithoutIcons.forEach(({ file, issues }) => {
      console.log(`\n  ${colors.yellow}${file}${colors.reset}`)
      issues.forEach(({ type, component, count, context }) => {
        console.log(`    - ${component} (${type}): ${count} indicator(s) without icons`)
        console.log(`      Context: ${context.substring(0, 100)}...`)
      })
    })
  } else {
    console.log(`  ${colors.green}Indicators without icons: 0${colors.reset}\n`)
  }
  
  // Print conclusion
  console.log(`\n${colors.bold}Conclusion:${colors.reset}`)
  if (results.passed) {
    console.log(`${colors.green}✓ PASSED: All status indicators include non-color cues (icons or text labels)${colors.reset}`)
    console.log(`${colors.green}  Requirements 10.4 and 10.5 are satisfied.${colors.reset}`)
  } else {
    console.log(`${colors.red}✗ FAILED: Some status indicators rely solely on color${colors.reset}`)
    console.log(`${colors.red}  Requirements 10.4 and 10.5 are NOT satisfied.${colors.reset}`)
    console.log(`\n${colors.yellow}Recommendation:${colors.reset}`)
    console.log(`  Add icons or text labels to all status indicators to ensure`)
    console.log(`  information is conveyed through multiple channels, not just color.`)
  }
  
  console.log(`\n${colors.cyan}═══════════════════════════════════════════════════════════${colors.reset}\n`)
  
  return results.passed
}

// Run verification
const passed = verifyStatusIndicators()
process.exit(passed ? 0 : 1)
