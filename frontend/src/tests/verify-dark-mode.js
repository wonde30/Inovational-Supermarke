/**
 * Dark Mode Color Variants Verification Script
 * Task 8.1: Verify dark mode color variants
 * Requirements: 9.1, 9.4
 * 
 * This script verifies:
 * 1. All CSS variables have dark mode equivalents
 * 2. Dark mode values are different from light mode values
 * 3. All required color variables are defined
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Required CSS variables from requirements
const requiredVariables = [
  // Brand Colors
  '--color-brand-primary',
  '--color-brand-secondary',
  '--color-brand-accent',
  
  // Semantic Colors
  '--color-success',
  '--color-warning',
  '--color-active',
  
  // Backgrounds
  '--bg-main',
  '--bg-card',
  '--bg-section',
  '--bg-hover',
  
  // Text Colors
  '--text-primary',
  '--text-secondary',
  '--text-disabled',
  
  // Borders
  '--border-color'
];

// Expected color values from requirements
const expectedLightModeColors = {
  '--color-brand-primary': '#16A34A',
  '--color-brand-secondary': '#2563EB',
  '--color-brand-accent': '#F97316',
  '--color-success': '#22C55E',
  '--color-warning': '#F59E0B',
  '--color-active': '#15803D',
  '--bg-main': '#F8FAFC',
  '--bg-card': '#FFFFFF',
  '--bg-section': '#F1F5F9',
  '--bg-hover': '#E8F5E9',
  '--text-primary': '#0F172A',
  '--text-secondary': '#475569',
  '--text-disabled': '#94A3B8',
  '--border-color': '#E2E8F0'
};

// Expected dark mode color values from design
const expectedDarkModeColors = {
  '--color-brand-primary': '#22C55E',
  '--color-brand-secondary': '#3B82F6',
  '--color-brand-accent': '#FB923C',
  '--color-success': '#4ADE80',
  '--color-warning': '#FBBF24',
  '--color-active': '#22C55E',
  '--bg-main': '#0F172A',
  '--bg-card': '#1E293B',
  '--bg-section': '#334155',
  '--bg-hover': '#1E3A28',
  '--text-primary': '#F1F5F9',
  '--text-secondary': '#CBD5E1',
  '--text-disabled': '#64748B',
  '--border-color': '#334155'
};

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
      // Skip variables that reference other variables
      if (!value.includes('var(')) {
        lightModeVars[varName] = value;
      }
    }
  }
  
  // Parse .dark block (dark mode)
  const darkMatch = cssContent.match(/\.dark\s*{([^}]*)}/s);
  if (darkMatch) {
    const darkContent = darkMatch[1];
    const varMatches = darkContent.matchAll(/--([a-z-]+)\s*:\s*([^;]+);/g);
    for (const match of varMatches) {
      const varName = `--${match[1]}`;
      const value = match[2].trim();
      // Skip variables that reference other variables
      if (!value.includes('var(')) {
        darkModeVars[varName] = value;
      }
    }
  }
  
  return { lightModeVars, darkModeVars };
}

function normalizeColor(color) {
  // Normalize color to uppercase for comparison
  return color.toUpperCase().trim();
}

function verifyDarkModeVariants() {
  console.log('='.repeat(70));
  console.log('Dark Mode Color Variants Verification');
  console.log('Task 8.1 - Requirements 9.1, 9.4');
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
  
  console.log('Test 1: Verify all required variables are defined');
  console.log('-'.repeat(70));
  
  let allVariablesDefined = true;
  const missingVariables = [];
  
  requiredVariables.forEach(varName => {
    const hasLight = varName in lightModeVars;
    const hasDark = varName in darkModeVars;
    
    if (hasLight && hasDark) {
      console.log(`✓ ${varName}: Defined in both light and dark mode`);
    } else {
      allVariablesDefined = false;
      missingVariables.push(varName);
      if (!hasLight) {
        console.log(`✗ ${varName}: Missing in light mode`);
      }
      if (!hasDark) {
        console.log(`✗ ${varName}: Missing in dark mode`);
      }
    }
  });
  
  console.log();
  console.log('Test 2: Verify light mode colors match requirements');
  console.log('-'.repeat(70));
  
  let lightModeCorrect = true;
  const lightModeErrors = [];
  
  Object.entries(expectedLightModeColors).forEach(([varName, expectedValue]) => {
    const actualValue = lightModeVars[varName];
    const normalizedExpected = normalizeColor(expectedValue);
    const normalizedActual = actualValue ? normalizeColor(actualValue) : '';
    
    if (normalizedActual === normalizedExpected) {
      console.log(`✓ ${varName}: ${actualValue}`);
    } else {
      lightModeCorrect = false;
      lightModeErrors.push({ varName, expected: expectedValue, actual: actualValue });
      console.log(`✗ ${varName}: Expected ${expectedValue}, got ${actualValue || 'undefined'}`);
    }
  });
  
  console.log();
  console.log('Test 3: Verify dark mode colors match requirements');
  console.log('-'.repeat(70));
  
  let darkModeCorrect = true;
  const darkModeErrors = [];
  
  Object.entries(expectedDarkModeColors).forEach(([varName, expectedValue]) => {
    const actualValue = darkModeVars[varName];
    const normalizedExpected = normalizeColor(expectedValue);
    const normalizedActual = actualValue ? normalizeColor(actualValue) : '';
    
    if (normalizedActual === normalizedExpected) {
      console.log(`✓ ${varName}: ${actualValue}`);
    } else {
      darkModeCorrect = false;
      darkModeErrors.push({ varName, expected: expectedValue, actual: actualValue });
      console.log(`✗ ${varName}: Expected ${expectedValue}, got ${actualValue || 'undefined'}`);
    }
  });
  
  console.log();
  console.log('Test 4: Verify dark mode values differ from light mode');
  console.log('-'.repeat(70));
  
  let valuesDiffer = true;
  const sameValueErrors = [];
  
  requiredVariables.forEach(varName => {
    const lightValue = lightModeVars[varName];
    const darkValue = darkModeVars[varName];
    
    if (lightValue && darkValue) {
      const normalizedLight = normalizeColor(lightValue);
      const normalizedDark = normalizeColor(darkValue);
      
      if (normalizedLight !== normalizedDark) {
        console.log(`✓ ${varName}: Light (${lightValue}) ≠ Dark (${darkValue})`);
      } else {
        valuesDiffer = false;
        sameValueErrors.push({ varName, value: lightValue });
        console.log(`✗ ${varName}: Same value in both modes (${lightValue})`);
      }
    }
  });
  
  console.log();
  console.log('='.repeat(70));
  console.log('SUMMARY');
  console.log('='.repeat(70));
  
  const allTestsPassed = allVariablesDefined && lightModeCorrect && darkModeCorrect && valuesDiffer;
  
  console.log(`Test 1 - All variables defined: ${allVariablesDefined ? '✓ PASS' : '✗ FAIL'}`);
  console.log(`Test 2 - Light mode colors correct: ${lightModeCorrect ? '✓ PASS' : '✗ FAIL'}`);
  console.log(`Test 3 - Dark mode colors correct: ${darkModeCorrect ? '✓ PASS' : '✗ FAIL'}`);
  console.log(`Test 4 - Values differ between modes: ${valuesDiffer ? '✓ PASS' : '✗ FAIL'}`);
  console.log();
  
  if (allTestsPassed) {
    console.log('✓ ALL TESTS PASSED');
    console.log('Dark mode color variants are properly implemented.');
    console.log('Requirements 9.1 and 9.4 are satisfied.');
  } else {
    console.log('✗ SOME TESTS FAILED');
    console.log('Please review the errors above and update theme.css accordingly.');
  }
  
  console.log('='.repeat(70));
  
  return allTestsPassed;
}

// Run verification
const success = verifyDarkModeVariants();
process.exit(success ? 0 : 1);
