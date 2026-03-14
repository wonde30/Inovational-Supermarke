<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Bug Condition Exploration Test for Audit Login Tracking
 * 
 * This test encodes the EXPECTED behavior: successful logins SHOULD create audit logs.
 * On UNFIXED code, this test will FAIL, proving the bug exists.
 * After the fix is implemented, this test will PASS, validating the fix.
 */
class AuditLoginTrackingBugTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 1: Bug Condition - Login Events Are Audited
     * 
     * **Validates: Requirements 2.1, 2.2, 2.3**
     * 
     * CRITICAL: This test MUST FAIL on unfixed code - failure confirms the bug exists.
     * 
     * Property: For any login request where the user successfully authenticates
     * (valid credentials, verified email, active account), the system SHALL create
     * an audit log entry with action "login", the user's ID, IP address, and timestamp.
     * 
     * Test Strategy: Generate multiple successful login scenarios with different users
     * and verify that each creates exactly one audit log entry with correct attributes.
     * 
     * Expected on UNFIXED code: FAILS - no audit log entries created
     * Expected after FIX: PASSES - audit log entries exist with correct data
     */
    public function test_property_successful_login_creates_audit_log(): void
    {
        // Property-based test: Generate multiple test cases
        $testCases = $this->generateSuccessfulLoginScenarios();

        foreach ($testCases as $scenario) {
            // Clear audit logs before each test case
            AuditLog::query()->delete();

            // Arrange: Create user with valid credentials, verified email, active account
            $user = User::factory()->create([
                'email' => $scenario['email'],
                'password' => Hash::make($scenario['password']),
                'email_verified_at' => now(), // Email verified
                'is_active' => true,          // Account active
            ]);

            $initialAuditCount = AuditLog::count();

            // Act: Perform successful login
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => $scenario['email'],
                'password' => $scenario['password'],
            ], [
                'REMOTE_ADDR' => $scenario['ip_address'],
            ]);

            // Assert: Login succeeded
            $response->assertStatus(200);
            $response->assertJsonStructure([
                'data' => ['user', 'token', 'expires_at'],
            ]);

            // Assert: Audit log entry was created (THIS WILL FAIL ON UNFIXED CODE)
            $auditLogs = AuditLog::where('action', 'login')
                ->where('user_id', $user->id)
                ->get();

            $this->assertCount(
                1,
                $auditLogs,
                "Expected exactly 1 audit log entry for successful login by user {$user->email}, but found {$auditLogs->count()}. " .
                "This failure confirms the bug: successful logins do not create audit log entries."
            );

            // Assert: Audit log has correct attributes
            $auditLog = $auditLogs->first();
            $this->assertEquals('login', $auditLog->action, 'Audit log action should be "login"');
            $this->assertEquals($user->id, $auditLog->user_id, 'Audit log should reference the logged-in user');
            $this->assertEquals('User', $auditLog->model_type, 'Audit log model_type should be "User"');
            $this->assertEquals($scenario['ip_address'], $auditLog->ip_address, 'Audit log should capture the request IP address');
            $this->assertNotNull($auditLog->created_at, 'Audit log should have a timestamp');
            
            // Assert: Exactly one audit log was added
            $this->assertEquals(
                $initialAuditCount + 1,
                AuditLog::count(),
                'Exactly one audit log entry should be created per successful login'
            );
        }
    }

    /**
     * Generate test scenarios for successful login cases
     * 
     * This simulates property-based testing by generating multiple diverse test cases
     * covering different users, passwords, and IP addresses.
     * 
     * @return array Array of test scenarios with email, password, and IP address
     */
    private function generateSuccessfulLoginScenarios(): array
    {
        return [
            [
                'email' => 'user1@example.com',
                'password' => 'Test@123',
                'ip_address' => '192.168.1.100',
            ],
            [
                'email' => 'admin@example.com',
                'password' => 'Admin!Pass1',
                'ip_address' => '10.0.0.50',
            ],
            [
                'email' => 'customer@test.com',
                'password' => 'Secure#456',
                'ip_address' => '172.16.0.1',
            ],
            [
                'email' => 'manager@company.com',
                'password' => 'Manager$789',
                'ip_address' => '203.0.113.42',
            ],
            [
                'email' => 'staff@shop.com',
                'password' => 'Staff&2024',
                'ip_address' => '198.51.100.25',
            ],
        ];
    }

    /**
     * Test that multiple successful logins create multiple audit log entries
     * 
     * This test verifies the property holds across multiple sequential logins
     * by the same user, ensuring each login event is logged separately.
     */
    public function test_property_multiple_logins_create_multiple_audit_logs(): void
    {
        // Arrange: Create user
        $user = User::factory()->create([
            'email' => 'multilogin@example.com',
            'password' => Hash::make('Test@123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $initialAuditCount = AuditLog::where('action', 'login')->count();

        // Act: Perform 3 successful logins
        $loginCount = 3;
        for ($i = 0; $i < $loginCount; $i++) {
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'multilogin@example.com',
                'password' => 'Test@123',
            ]);

            $response->assertStatus(200);
        }

        // Assert: 3 audit log entries were created (THIS WILL FAIL ON UNFIXED CODE)
        $auditLogs = AuditLog::where('action', 'login')
            ->where('user_id', $user->id)
            ->get();

        $this->assertCount(
            $loginCount,
            $auditLogs,
            "Expected {$loginCount} audit log entries for {$loginCount} successful logins, but found {$auditLogs->count()}. " .
            "This failure confirms the bug: successful logins do not create audit log entries."
        );
    }

    /**
     * Test that audit log captures correct IP address for each login
     * 
     * This test verifies that the IP address is correctly captured in the audit log,
     * which is critical for security tracking and fraud prevention.
     */
    public function test_property_audit_log_captures_ip_address(): void
    {
        $testIPs = [
            '192.168.1.100',
            '10.0.0.50',
            '172.16.0.1',
        ];

        foreach ($testIPs as $ipAddress) {
            // Clear audit logs
            AuditLog::query()->delete();

            // Arrange: Create user
            $user = User::factory()->create([
                'email' => "user-{$ipAddress}@example.com",
                'password' => Hash::make('Test@123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);

            // Act: Login from specific IP
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => $user->email,
                'password' => 'Test@123',
            ], [
                'REMOTE_ADDR' => $ipAddress,
            ]);

            $response->assertStatus(200);

            // Assert: Audit log captures the correct IP (THIS WILL FAIL ON UNFIXED CODE)
            $auditLog = AuditLog::where('action', 'login')
                ->where('user_id', $user->id)
                ->first();

            $this->assertNotNull(
                $auditLog,
                "Expected audit log entry for login from IP {$ipAddress}, but none found. " .
                "This failure confirms the bug: successful logins do not create audit log entries."
            );

            if ($auditLog) {
                $this->assertEquals(
                    $ipAddress,
                    $auditLog->ip_address,
                    "Audit log should capture the request IP address {$ipAddress}"
                );
            }
        }
    }
}
