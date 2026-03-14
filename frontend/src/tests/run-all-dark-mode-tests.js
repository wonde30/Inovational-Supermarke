/**
 * Master Test Runner for Dark Mode Verification
 * Task 8.1: Verify dark mode color variants
 * Requirements: 9.1, 9.4
 * 
 * This script runs all dark mode verification tests and generates a summary report
 */

import { execSync } from 'child_process';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

console.log('╔' + '═'.repeat(68) + '╗');
console.log('║' + ' '.repeat(68) + '║');
console.log('║' + '  Dark Mode Verification - Master Test Suite'.padEnd(68) + '║');
console.log('║' + '  Task 8.1 - Requirements 9.1, 9.4'.padEnd(68) + '║');
console.log('║' + ' '.repeat(68) + '║');
console.log('╚' + '═'.repeat(68) + '╝');
console.log();

const tests = [
  {
    name: 'CSS Variables Verification',
    script: 'verify-dark-mode.js',
    description: 'Verifies all CSS variables have dark mode equivalents'
  },
  {
    name: 'Theme Toggle Functionality',
    script: 'verify-theme-toggle.js',
    description: 'Verifies theme toggle and localStorage persistence'
  }
];

const results = [];

tests.forEach((test, index) => {
  console.log(`\n[${ index + 1}/${tests.length}] Running: ${test.name}`);
  console.log(`Description: ${test.description}`);
  console.log('-'.repeat(70));
  
  try {
    const scriptPath = path.join(__dirname, test.script);
    execSync(`node "${scriptPath}"`, { 
      stdio: 'inherit',
      cwd: path.join(__dirname, '..')
    });
    
    results.push({
      name: test.name,
      status: 'PASS',
      error: null
    });
    
    console.log(`✓ ${test.name}: PASSED`);
  } catch (error) {
    results.push({
      name: test.name,
      status: 'FAIL',
      error: error.message
    });
    
    console.log(`✗ ${test.name}: FAILED`);
  }
});

console.log();
console.log('╔' + '═'.repeat(68) + '╗');
console.log('║' + ' '.repeat(68) + '║');
console.log('║' + '  FINAL SUMMARY'.padEnd(68) + '║');
console.log('║' + ' '.repeat(68) + '║');
console.log('╚' + '═'.repeat(68) + '╝');
console.log();

const passedTests = results.filter(r => r.status === 'PASS').length;
const failedTests = results.filter(r => r.status === 'FAIL').length;
const totalTests = results.length;

console.log(`Total Tests: ${totalTests}`);
console.log(`Passed: ${passedTests}`);
console.log(`Failed: ${failedTests}`);
console.log();

results.forEach(result => {
  const icon = result.status === 'PASS' ? '✓' : '✗';
  const status = result.status === 'PASS' ? 'PASS' : 'FAIL';
  console.log(`${icon} ${result.name}: ${status}`);
  if (result.error) {
    console.log(`  Error: ${result.error}`);
  }
});

console.log();

if (failedTests === 0) {
  console.log('╔' + '═'.repeat(68) + '╗');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('║' + '  ✓ ALL TESTS PASSED'.padEnd(68) + '║');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('║' + '  Dark mode color variants are properly implemented.'.padEnd(68) + '║');
  console.log('║' + '  Theme toggle functionality works correctly.'.padEnd(68) + '║');
  console.log('║' + '  localStorage persistence is working correctly.'.padEnd(68) + '║');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('║' + '  Requirements 9.1 and 9.4 are SATISFIED.'.padEnd(68) + '║');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('╚' + '═'.repeat(68) + '╝');
  console.log();
  console.log('Task 8.1: COMPLETED ✓');
  console.log();
  process.exit(0);
} else {
  console.log('╔' + '═'.repeat(68) + '╗');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('║' + '  ✗ SOME TESTS FAILED'.padEnd(68) + '║');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('║' + '  Please review the errors above and fix the issues.'.padEnd(68) + '║');
  console.log('║' + ' '.repeat(68) + '║');
  console.log('╚' + '═'.repeat(68) + '╝');
  console.log();
  process.exit(1);
}
