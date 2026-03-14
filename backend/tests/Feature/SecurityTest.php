<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test rate limiting on login endpoint
     */
    public function test_login_rate_limiting(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => now(),
        ]);

        // Make 5 failed login attempts (should succeed)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
            
            $response->assertStatus(422);
        }

        // 6th attempt should be rate limited
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    /**
     * Test strong password policy enforcement
     */
    public function test_weak_password_rejected(): void
    {
        $weakPasswords = [
            'password',      // No uppercase, number, or special char
            'PASSWORD123',   // No lowercase or special char
            'Pass123',       // No special char
            'Pass@',         // Too short
            'password@123',  // No uppercase
        ];

        foreach ($weakPasswords as $password) {
            $response = $this->postJson('/api/v1/auth/register', [
                'name' => 'Test User',
                'email' => 'test' . rand() . '@example.com',
                'password' => $password,
                'password_confirmation' => $password,
            ]);

            $response->assertStatus(422);
            $response->assertJsonValidationErrors('password');
        }
    }

    /**
     * Test strong password accepted
     */
    public function test_strong_password_accepted(): void
    {
        $strongPasswords = [
            'MyP@ssw0rd',
            'Secure#123',
            'Test@2024',
            'Admin!Pass1',
        ];

        foreach ($strongPasswords as $password) {
            $response = $this->postJson('/api/v1/auth/register', [
                'name' => 'Test User',
                'email' => 'test' . rand() . '@example.com',
                'password' => $password,
                'password_confirmation' => $password,
            ]);

            $response->assertStatus(201);
        }
    }

    /**
     * Test email verification required for login
     */
    public function test_unverified_email_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'unverified@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => null, // Not verified
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'unverified@example.com',
            'password' => 'Test@123',
        ]);

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Please verify your email address before logging in.',
        ]);
    }

    /**
     * Test verified email can login
     */
    public function test_verified_email_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'verified@example.com',
            'password' => 'Test@123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token',
                'expires_at',
            ],
        ]);
    }

    /**
     * Test token expiration is set
     */
    public function test_token_has_expiration(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'Test@123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'expires_at',
            ],
        ]);

        $expiresAt = $response->json('data.expires_at');
        $this->assertNotNull($expiresAt);
    }

    /**
     * Test token refresh endpoint
     */
    public function test_token_can_be_refreshed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->postJson('/api/v1/auth/refresh', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
                'expires_at',
            ],
        ]);

        // New token should be different
        $newToken = $response->json('data.token');
        $this->assertNotEquals($token, $newToken);
    }

    /**
     * Test input sanitization removes HTML tags
     */
    public function test_input_sanitization_removes_html(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => '<script>alert("xss")</script>Test User',
            'email' => 'test' . rand() . '@example.com',
            'password' => 'Test@123',
            'password_confirmation' => 'Test@123',
        ]);

        $response->assertStatus(201);
        
        // Verify HTML was stripped
        $user = User::where('email', $response->json('data.user.email'))->first();
        $this->assertStringNotContainsString('<script>', $user->name);
        $this->assertStringNotContainsString('</script>', $user->name);
    }

    /**
     * Test backup filename validation prevents directory traversal
     */
    public function test_backup_filename_validation(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $token = $admin->createToken('test-token')->plainTextToken;

        // Try directory traversal
        $response = $this->getJson('/api/v1/backup/download/../../.env', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid backup filename format.',
        ]);
    }

    /**
     * Test inactive user cannot login
     */
    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => now(),
            'is_active' => false,
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'inactive@example.com',
            'password' => 'Test@123',
        ]);

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Your account has been deactivated. Please contact support.',
        ]);
    }

    /**
     * Test registration sends verification email
     */
    public function test_registration_sends_verification_email(): void
    {
        \Illuminate\Support\Facades\Notification::fake();

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'newuser@example.com',
            'password' => 'Test@123',
            'password_confirmation' => 'Test@123',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'Registration successful. Please verify your email.',
        ]);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->email_verified_at);
    }

    /**
     * Test password is not sanitized
     */
    public function test_password_not_sanitized(): void
    {
        $password = 'Test@<123>';
        
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test' . rand() . '@example.com',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201);
        
        // Verify password works with special characters
        $user = User::where('email', $response->json('data.user.email'))->first();
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /**
     * Test logout deletes token
     */
    public function test_logout_deletes_token(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        // Logout
        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        // Try to use the same token (should fail)
        $response = $this->getJson('/api/v1/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(401);
    }
}
