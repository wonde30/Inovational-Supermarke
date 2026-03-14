<?php

/**
 * Test Phone Number Formatting
 * 
 * This script tests the phone number formatting logic
 * to ensure it works correctly with various input formats.
 */

function formatPhoneNumber(string $phone): string
{
    // Remove all spaces, dashes, and parentheses
    $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
    
    // If phone starts with 0, replace with +251
    if (substr($phone, 0, 1) === '0') {
        $phone = '+251' . substr($phone, 1);
    }
    
    // If phone doesn't start with +, add +251
    if (substr($phone, 0, 1) !== '+') {
        // Check if it starts with 251
        if (substr($phone, 0, 3) === '251') {
            $phone = '+' . $phone;
        } else {
            $phone = '+251' . $phone;
        }
    }
    
    return $phone;
}

// Test cases
$testCases = [
    '0911234567' => '+251911234567',
    '911234567' => '+251911234567',
    '251911234567' => '+251911234567',
    '+251911234567' => '+251911234567',
    '0911 234 567' => '+251911234567',
    '0911-234-567' => '+251911234567',
    '(0911) 234 567' => '+251911234567',
    '0712345678' => '+251712345678',
    '712345678' => '+251712345678',
];

echo "Phone Number Formatting Test\n";
echo str_repeat("=", 60) . "\n\n";

$passed = 0;
$failed = 0;

foreach ($testCases as $input => $expected) {
    $result = formatPhoneNumber($input);
    $status = $result === $expected ? '✓ PASS' : '✗ FAIL';
    
    if ($result === $expected) {
        $passed++;
    } else {
        $failed++;
    }
    
    echo sprintf(
        "%-20s => %-20s [Expected: %-20s] %s\n",
        $input,
        $result,
        $expected,
        $status
    );
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "Results: {$passed} passed, {$failed} failed\n";

if ($failed === 0) {
    echo "✓ All tests passed!\n";
} else {
    echo "✗ Some tests failed!\n";
}
