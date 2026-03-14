<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PasswordPolicyTest extends TestCase
{
    /**
     * Password validation regex pattern
     */
    private string $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/';

    /**
     * Test valid passwords
     */
    public function test_valid_passwords(): void
    {
        $validPasswords = [
            'MyP@ssw0rd',
            'Secure#123',
            'Test@2024',
            'Admin!Pass1',
            'Complex$Pass9',
            'Strong&Key7',
            'Valid%123Abc',
            'Good@Password1',
        ];

        foreach ($validPasswords as $password) {
            $this->assertTrue(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be valid but was rejected"
            );
        }
    }

    /**
     * Test invalid passwords - no uppercase
     */
    public function test_password_requires_uppercase(): void
    {
        $passwords = [
            'myp@ssw0rd',
            'test@123',
            'password!1',
        ];

        foreach ($passwords as $password) {
            $this->assertFalse(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be invalid (no uppercase)"
            );
        }
    }

    /**
     * Test invalid passwords - no lowercase
     */
    public function test_password_requires_lowercase(): void
    {
        $passwords = [
            'MYP@SSW0RD',
            'TEST@123',
            'PASSWORD!1',
        ];

        foreach ($passwords as $password) {
            $this->assertFalse(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be invalid (no lowercase)"
            );
        }
    }

    /**
     * Test invalid passwords - no number
     */
    public function test_password_requires_number(): void
    {
        $passwords = [
            'MyP@ssword',
            'Test@Pass',
            'Password!',
        ];

        foreach ($passwords as $password) {
            $this->assertFalse(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be invalid (no number)"
            );
        }
    }

    /**
     * Test invalid passwords - no special character
     */
    public function test_password_requires_special_character(): void
    {
        $passwords = [
            'MyPassword1',
            'Test1234',
            'Password123',
        ];

        foreach ($passwords as $password) {
            $this->assertFalse(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be invalid (no special char)"
            );
        }
    }

    /**
     * Test password with all allowed special characters
     */
    public function test_all_special_characters_allowed(): void
    {
        $specialChars = ['@', '$', '!', '%', '*', '?', '&', '#'];

        foreach ($specialChars as $char) {
            $password = "Test{$char}123";
            $this->assertTrue(
                preg_match($this->passwordPattern, $password) === 1,
                "Password with '{$char}' should be valid"
            );
        }
    }

    /**
     * Test password with disallowed characters
     */
    public function test_disallowed_characters_rejected(): void
    {
        $passwords = [
            'Test^123',   // ^ not allowed
            'Test~123',   // ~ not allowed
            'Test+123',   // + not allowed
            'Test=123',   // = not allowed
            'Test 123',   // space not allowed
        ];

        foreach ($passwords as $password) {
            $this->assertFalse(
                preg_match($this->passwordPattern, $password) === 1,
                "Password '{$password}' should be invalid (disallowed char)"
            );
        }
    }
}
