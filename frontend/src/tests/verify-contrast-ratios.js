/**
 * Contrast Ratio Verification Script
 * Task 9.1: Verify contrast ratios for all color combinations
 * Requirements: 6.4, 10.1, 10.2, 10.3
 * 
 * This script verifies:
 * 1. Primary text on main background (min 4.5:1)
 * 2. Secondary text on card background (min 4.5:1)
 * 3. Button text on colored backgrounds (min 4.5:1)
 * 4. Large text and UI components (min 3:1)
 * 5. Both light and dark modes
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// WCAG AA Contrast Requirements
const WCAG_AA_NORMAL_TEXT = 4.5;  // Normal text (< 18pt or < 14pt bold)
const WCAG_AA_LARGE_TEXT = 3.0;   // Large text (>= 18pt or >= 14pt bold)
const WCAG_AA_UI_COMPONENTS = 3.0; // UI components and graphical objects

/**
 * Convert hex color to RGB
 */
function hexToRgb(hex) {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;
}

/**
 * Calculate relative luminance
 * https://www.w3.org/TR/WCAG20-TECHS/G17.html
 */
function getLuminance(r, g, b) {
  const [rs, gs, bs] = [r, g, b].map(c => {
    c = c / 255;
    return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
  });
  return 0.2126 * rs + 0.7152 * gs + 0.0722 * bs;
}

/**
 * Calculate contrast ratio between two colors
 * https://www.w3.org/TR/WCAG20-TECHS/G17.html
 */
function getContrastRatio(color1, color2) {
  const rgb1 = hexToRgb(color1);
  const rgb2 = hexToRgb(color2);
  
  if (!rgb1 || !rgb2) {
    throw new Error(`Invalid color format: ${color1} or ${color2}`);
  }
  
  const lum1 = getLuminance(rgb1.r, rgb1.g, rgb1.b);
  const lum2 = getLuminance(rgb2.r, rgb2.g, rgb2.b);
  
  const lighter = Math.max(lum1, lum2);
  const darker = Math.min(lum1, lum2);
  
  return (lighter + 0.05) / (darker + 0.05);
}

/**
 * Check if contrast ratio meets WCAG AA standards
 */
function meetsWCAG_AA(ratio, type = 'normal') {
  if (type === 'normal') {
    return ratio >= WCAG_AA_NORMAL_TEXT;
  } else if (type === 'large' || type === 'ui') {
    return ratio >= WCAG_AA_LARGE_TEXT;
  }
  return false;
}

/**
 * Format contrast ratio result
 */
function formatResult(foreground, background, ratio, required, passes) {
  const status = passes ? '✓' : '✗';
  const passText = passes ? 'PASS' : 'FAIL';
  return `${status} ${foreground} on ${background}: ${ratio.toFixed(2)}:1 (required: ${required}:1) - ${passText}`;
}

/**
 * Parse CSS variables from theme.css
 */
function parseCSSVariables(cssContent) {
  const lightModeVars = {};
  const darkModeVars = {};
  
  // Parse :root block (light mode)
  const rootMatch = cssContent.match(/:root\s*{([^}]*)}/s);
  if (rootMatch) {
    const rootContent = rootMatch[1];
    const varMatches = rootContent.matchAll(/--([a-z-]+)\s*:\s*([^;]+);/g);
    for (const match of varMatches) {
      const varName = `--${match[1]}`;
      const value = match[2].trim();
      // Only store hex color values
      if (value.match(/^#[0-9A-Fa-f]{6}$/)) {
        lightModeVars[varName] = value;
      }
    }
  }
  
  // Parse .dark block (dark mode)
  const darkMatch = cssContent.match(/(?:\[data-theme="dark"\]|\.dark)\s*{([^}]*)}/s);
  if (darkMatch) {
    const darkContent = darkMatch[1];
    const varMatches = darkContent.matchAll(/--([a-z-]+)\s*:\s*([^;]+);/g);
    for (const match of varMatches) {
      const varName = `--${match[1]}`;
      const value = match[2].trim();
      // Only store hex color values
      if (value.match(/^#[0-9A-Fa-f]{6}$/)) {
        darkModeVars[varName] = value;
      }
    }
  }
  
  return { lightModeVars, darkModeVars };
}

/**
 * Main verification function
 */
function verifyContrastRatios() {
  console.log('='.repeat(70));
  console.log('Contrast Ratio Verification');
  console.log('Task 9.1 - Requirements 6.4, 10.1, 10.2, 10.3');
  console.log('='.repeat(70));
  console.log();
  
  // Read theme.css file
  const themeCssPath = path.join(__dirname, '../assets/theme.css');
  let cssContent;
  
  try {
    cssContent = fs.readFileSync(themeCssPath, 'utf-8');
  } catch (error) {
    console.error('✗ Failed to read theme.css:', error.message);
    process.exit(1);
  }
  
  const { lightModeVars, darkModeVars } = parseCSSVariables(cssContent);
  
  let allTestsPassed = true;
  const failures = [];
  
  // ========== LIGHT MODE TESTS ==========
  console.log('LIGHT MODE CONTRAST TESTS');
  console.log('='.repeat(70));
  console.log();
  
  console.log('Test 1: Primary text on main background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--text-primary'],
      lightModeVars['--bg-main']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      lightModeVars['--text-primary'],
      lightModeVars['--bg-main'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Primary text on main background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Primary text on main background (error)');
  }
  console.log();
  
  console.log('Test 2: Primary text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--text-primary'],
      lightModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      lightModeVars['--text-primary'],
      lightModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Primary text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Primary text on card background (error)');
  }
  console.log();
  
  console.log('Test 3: Secondary text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--text-secondary'],
      lightModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      lightModeVars['--text-secondary'],
      lightModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Secondary text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Secondary text on card background (error)');
  }
  console.log();
  
  console.log('Test 4: Secondary text on main background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--text-secondary'],
      lightModeVars['--bg-main']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      lightModeVars['--text-secondary'],
      lightModeVars['--bg-main'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Secondary text on main background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Secondary text on main background (error)');
  }
  console.log();
  
  console.log('Test 5: White text on primary button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#FFFFFF',
      lightModeVars['--color-brand-secondary']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#FFFFFF',
      lightModeVars['--color-brand-secondary'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: White text on primary button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: White text on primary button (error)');
  }
  console.log();
  
  console.log('Test 6: Dark text on success button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#0F172A',
      lightModeVars['--color-success']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#0F172A',
      lightModeVars['--color-success'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Dark text on success button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Dark text on success button (error)');
  }
  console.log();
  
  console.log('Test 7: Dark text on warning button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#0F172A',
      lightModeVars['--color-warning']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#0F172A',
      lightModeVars['--color-warning'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Dark text on warning button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Dark text on warning button (error)');
  }
  console.log();
  
  console.log('Test 8: Dark text on accent/promo badge (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#0F172A',
      lightModeVars['--color-brand-accent']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#0F172A',
      lightModeVars['--color-brand-accent'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Dark text on accent badge');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Dark text on accent badge (error)');
  }
  console.log();
  
  console.log('Test 9: Dark text on brand primary (navbar) (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#0F172A',
      lightModeVars['--color-brand-primary']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#0F172A',
      lightModeVars['--color-brand-primary'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Dark text on brand primary');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Dark text on brand primary (error)');
  }
  console.log();
  
  console.log('Test 10: Border on card background (UI component, min 3:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--border-color'],
      lightModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'ui');
    console.log(formatResult(
      lightModeVars['--border-color'],
      lightModeVars['--bg-card'],
      ratio,
      WCAG_AA_UI_COMPONENTS,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Border on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Border on card background (error)');
  }
  console.log();
  
  console.log('Test 11: Disabled text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      lightModeVars['--text-disabled'],
      lightModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      lightModeVars['--text-disabled'],
      lightModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Light mode: Disabled text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Light mode: Disabled text on card background (error)');
  }
  console.log();
  
  // ========== DARK MODE TESTS ==========
  console.log('DARK MODE CONTRAST TESTS');
  console.log('='.repeat(70));
  console.log();
  
  console.log('Test 12: Primary text on main background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--text-primary'],
      darkModeVars['--bg-main']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      darkModeVars['--text-primary'],
      darkModeVars['--bg-main'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Primary text on main background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Primary text on main background (error)');
  }
  console.log();
  
  console.log('Test 13: Primary text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--text-primary'],
      darkModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      darkModeVars['--text-primary'],
      darkModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Primary text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Primary text on card background (error)');
  }
  console.log();
  
  console.log('Test 14: Secondary text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--text-secondary'],
      darkModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      darkModeVars['--text-secondary'],
      darkModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Secondary text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Secondary text on card background (error)');
  }
  console.log();
  
  console.log('Test 15: Secondary text on main background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--text-secondary'],
      darkModeVars['--bg-main']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      darkModeVars['--text-secondary'],
      darkModeVars['--bg-main'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Secondary text on main background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Secondary text on main background (error)');
  }
  console.log();
  
  console.log('Test 16: White text on primary button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#FFFFFF',
      darkModeVars['--color-brand-secondary']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#FFFFFF',
      darkModeVars['--color-brand-secondary'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: White text on primary button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: White text on primary button (error)');
  }
  console.log();
  
  console.log('Test 17: Light text on success button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#F1F5F9',
      darkModeVars['--color-success']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#F1F5F9',
      darkModeVars['--color-success'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Light text on success button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Light text on success button (error)');
  }
  console.log();
  
  console.log('Test 18: Light text on warning button (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#F1F5F9',
      darkModeVars['--color-warning']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#F1F5F9',
      darkModeVars['--color-warning'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Light text on warning button');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Light text on warning button (error)');
  }
  console.log();
  
  console.log('Test 19: Light text on accent/promo badge (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#F1F5F9',
      darkModeVars['--color-brand-accent']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#F1F5F9',
      darkModeVars['--color-brand-accent'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Light text on accent badge');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Light text on accent badge (error)');
  }
  console.log();
  
  console.log('Test 20: Light text on brand primary (navbar) (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      '#F1F5F9',
      darkModeVars['--color-brand-primary']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      '#F1F5F9',
      darkModeVars['--color-brand-primary'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Light text on brand primary');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Light text on brand primary (error)');
  }
  console.log();
  
  console.log('Test 21: Border on card background (UI component, min 3:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--border-color'],
      darkModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'ui');
    console.log(formatResult(
      darkModeVars['--border-color'],
      darkModeVars['--bg-card'],
      ratio,
      WCAG_AA_UI_COMPONENTS,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Border on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Border on card background (error)');
  }
  console.log();
  
  console.log('Test 22: Disabled text on card background (min 4.5:1)');
  console.log('-'.repeat(70));
  try {
    const ratio = getContrastRatio(
      darkModeVars['--text-disabled'],
      darkModeVars['--bg-card']
    );
    const passes = meetsWCAG_AA(ratio, 'normal');
    console.log(formatResult(
      darkModeVars['--text-disabled'],
      darkModeVars['--bg-card'],
      ratio,
      WCAG_AA_NORMAL_TEXT,
      passes
    ));
    if (!passes) {
      allTestsPassed = false;
      failures.push('Dark mode: Disabled text on card background');
    }
  } catch (error) {
    console.log(`✗ Error: ${error.message}`);
    allTestsPassed = false;
    failures.push('Dark mode: Disabled text on card background (error)');
  }
  console.log();
  
  // ========== SUMMARY ==========
  console.log('='.repeat(70));
  console.log('SUMMARY');
  console.log('='.repeat(70));
  console.log();
  
  if (allTestsPassed) {
    console.log('✓ ALL TESTS PASSED');
    console.log('All color combinations meet WCAG AA contrast requirements.');
    console.log('Requirements 6.4, 10.1, 10.2, and 10.3 are satisfied.');
  } else {
    console.log('✗ SOME TESTS FAILED');
    console.log();
    console.log('Failed tests:');
    failures.forEach(failure => {
      console.log(`  - ${failure}`);
    });
    console.log();
    console.log('Please review the failures above and adjust colors accordingly.');
  }
  
  console.log('='.repeat(70));
  
  return allTestsPassed;
}

// Run verification
const success = verifyContrastRatios();
process.exit(success ? 0 : 1);
