<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Preservation Property Tests for Audit Login Tracking Bugfix
 * 
 * These tests verify that the bugfix does NOT change existing behavior for:
 * - Failed login attempts (should NOT create audit logs)
 * - Existing audit actions (should CONTINUE to create audit logs)
 * 
 * **Validates: Requirements 3.1, 3.2, 3.3, 3.4, 3.5**
 * 
 * IMPORTANT: These tests should PASS on UNFIXED code, confirming baseline behavior.
 * After the fix is implemented, these tests should STILL PASS, confirming no regressions.
 */
class AuditLoginTrackingPreservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 3: Preservation - Failed Login Behavior Unchanged
     * 
     * **Validates: Requirements 3.3**
     * 
     * Property: For any login attempt that fails (incorrect credentials, unverified email,
     * inactive account), the system SHALL continue to return the appropriate error response
     * without creating an audit log entry.
     * 
     * Test Strategy: Generate multiple failed login scenarios and verify that:
     * 1. The appropriate error response is returned
     * 2. NO audit log entry is created
     * 
     * Expected on UNFIXED code: PASSES - failed logins don't create audit logs
     * Expected after FIX: PASSES - failed logins still don't create audit logs
     */
    public function test_property_failed_login_incorrect_credentials_no_audit_log(): void
    {
        // Property-based test: Generate multiple test cases with incorrect credentials
        $testCases = $this->generateFailedLoginScenarios();

        foreach ($testCases as $scenario) {
            // Clear audit logs before each test case
            AuditLog::query()->delete();

            // Arrange: Create user with valid credentials
            $user = User::factory()->create([
                'email' => $scenario['email'],
                'password' => Hash::make($scenario['correct_password']),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);

            $initialAuditCount = AuditLog::count();

            // Act: Attempt login with INCORRECT password
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => $scenario['email'],
                'password' => $scenario['incorrect_password'],
            ]);

            // Assert: Login failed with 422 error
            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['email']);

            // Assert: NO audit log entry was created
            $auditLogs = AuditLog::where('action', 'login')
                ->where('user_id', $user->id)
                ->get();

            $this->assertCount(
                0,
                $auditLogs,
                "Expected NO audit log entry for failed login (incorrect credentials), but found {$auditLogs->count()}. " .
                "Failed logins should not create audit logs."
            );

            // Assert: Total audit log count unchanged
            $this->assertEquals(
                $initialAuditCount,
                AuditLog::count(),
                'Failed login should not create any audit log entries'
            );
        }
    }

    /**
     * Test that failed login with unverified email does not create audit log
     */
    public function test_property_failed_login_unverified_email_no_audit_log(): void
    {
        $testCases = [
            ['email' => 'unverified1@example.com', 'password' => 'Test@123'],
            ['email' => 'unverified2@example.com', 'password' => 'Pass!456'],
            ['email' => 'unverified3@example.com', 'password' => 'Secure#789'],
        ];

        foreach ($testCases as $scenario) {
            // Clear audit logs
            AuditLog::query()->delete();

            // Arrange: Create user with UNVERIFIED email
            $user = User::factory()->create([
                'email' => $scenario['email'],
                'password' => Hash::make($scenario['password']),
                'email_verified_at' => null, // Email NOT verified
                'is_active' => true,
            ]);

            $initialAuditCount = AuditLog::count();

            // Act: Attempt login with unverified email
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => $scenario['email'],
                'password' => $scenario['password'],
            ]);

            // Assert: Login failed with 403 error
            $response->assertStatus(403);
            $response->assertJson([
                'success' => false,
                'message' => 'Please verify your email address before logging in.',
            ]);

            // Assert: NO audit log entry was created
            $auditLogs = AuditLog::where('action', 'login')
                ->where('user_id', $user->id)
                ->get();

            $this->assertCount(
                0,
                $auditLogs,
                "Expected NO audit log entry for failed login (unverified email), but found {$auditLogs->count()}. " .
                "Failed logins should not create audit logs."
            );

            // Assert: Total audit log count unchanged
            $this->assertEquals(
                $initialAuditCount,
                AuditLog::count(),
                'Failed login with unverified email should not create any audit log entries'
            );
        }
    }

    /**
     * Test that failed login with inactive account does not create audit log
     */
    public function test_property_failed_login_inactive_account_no_audit_log(): void
    {
        $testCases = [
            ['email' => 'inactive1@example.com', 'password' => 'Test@123'],
            ['email' => 'inactive2@example.com', 'password' => 'Pass!456'],
            ['email' => 'inactive3@example.com', 'password' => 'Secure#789'],
        ];

        foreach ($testCases as $scenario) {
            // Clear audit logs
            AuditLog::query()->delete();

            // Arrange: Create user with INACTIVE account
            $user = User::factory()->create([
                'email' => $scenario['email'],
                'password' => Hash::make($scenario['password']),
                'email_verified_at' => now(),
                'is_active' => false, // Account INACTIVE
            ]);

            $initialAuditCount = AuditLog::count();

            // Act: Attempt login with inactive account
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => $scenario['email'],
                'password' => $scenario['password'],
            ]);

            // Assert: Login failed with 403 error
            $response->assertStatus(403);
            $response->assertJson([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact support.',
            ]);

            // Assert: NO audit log entry was created
            $auditLogs = AuditLog::where('action', 'login')
                ->where('user_id', $user->id)
                ->get();

            $this->assertCount(
                0,
                $auditLogs,
                "Expected NO audit log entry for failed login (inactive account), but found {$auditLogs->count()}. " .
                "Failed logins should not create audit logs."
            );

            // Assert: Total audit log count unchanged
            $this->assertEquals(
                $initialAuditCount,
                AuditLog::count(),
                'Failed login with inactive account should not create any audit log entries'
            );
        }
    }

    /**
     * Generate test scenarios for failed login cases with incorrect credentials
     */
    private function generateFailedLoginScenarios(): array
    {
        return [
            [
                'email' => 'user1@example.com',
                'correct_password' => 'Test@123',
                'incorrect_password' => 'WrongPass!',
            ],
            [
                'email' => 'user2@example.com',
                'correct_password' => 'Secure#456',
                'incorrect_password' => 'BadPassword1',
            ],
            [
                'email' => 'user3@example.com',
                'correct_password' => 'Valid$789',
                'incorrect_password' => 'IncorrectPass@',
            ],
            [
                'email' => 'user4@example.com',
                'correct_password' => 'Strong&2024',
                'incorrect_password' => 'Weak123!',
            ],
        ];
    }

    /**
     * Property 2: Preservation - Existing Audit Logging Unchanged
     * 
     * **Validates: Requirements 3.1, 3.2, 3.5**
     * 
     * Property: For any audited action that is NOT a login event (create_sale_from_order,
     * update_order_status, resolve_alert), the system SHALL continue to create audit log
     * entries exactly as before, preserving all existing audit logging behavior.
     * 
     * Test Strategy: Directly call AuditLog::log() with the same parameters used by
     * existing controllers to verify the audit logging system continues to work correctly.
     * 
     * Expected on UNFIXED code: PASSES - existing audit actions create logs
     * Expected after FIX: PASSES - existing audit actions still create logs
     */
    public function test_property_existing_audit_actions_continue_to_work(): void
    {
        // Arrange: Create a user and authenticate (required for audit logs)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Test cases representing existing audit actions in the codebase
        $testCases = [
            [
                'action' => 'update_order_status',
                'model_type' => 'Order',
                'model_id' => 1,
                'old_values' => ['status' => 'pending'],
                'new_values' => ['status' => 'completed'],
                'description' => 'Order status changed from pending to completed',
            ],
            [
                'action' => 'create_sale_from_order',
                'model_type' => 'Sale',
                'model_id' => 1,
                'old_values' => null,
                'new_values' => ['order_id' => 1, 'invoice_number' => 'INV-20240101-0001'],
                'description' => 'Sale created from Order #ORD-001',
            ],
            [
                'action' => 'resolve_alert',
                'model_type' => 'StockAlert',
                'model_id' => 1,
                'old_values' => null,
                'new_values' => null,
                'description' => 'Resolved stock alert',
            ],
        ];

        foreach ($testCases as $scenario) {
            // Clear audit logs before each test case
            AuditLog::query()->delete();

            $initialAuditCount = AuditLog::count();

            // Act: Call AuditLog::log() with the same parameters used by existing controllers
            $auditLog = AuditLog::log(
                $scenario['action'],
                $scenario['model_type'],
                $scenario['model_id'],
                $scenario['old_values'],
                $scenario['new_values'],
                $scenario['description']
            );

            // Assert: Audit log entry was created
            $this->assertNotNull($auditLog, "Audit log should be created for action {$scenario['action']}");
            $this->assertEquals($scenario['action'], $auditLog->action);
            $this->assertEquals($scenario['model_type'], $auditLog->model_type);
            $this->assertEquals($scenario['model_id'], $auditLog->model_id);
            $this->assertEquals($scenario['old_values'], $auditLog->old_values);
            $this->assertEquals($scenario['new_values'], $auditLog->new_values);
            $this->assertEquals($scenario['description'], $auditLog->description);
            $this->assertNotNull($auditLog->ip_address, 'Audit log should capture IP address');
            $this->assertNotNull($auditLog->created_at, 'Audit log should have timestamp');

            // Assert: Exactly one audit log was added
            $this->assertEquals(
                $initialAuditCount + 1,
                AuditLog::count(),
                "Exactly one audit log entry should be created for action {$scenario['action']}"
            );
        }
    }

    /**
     * Test that AuditLog::log() method signature and behavior remain unchanged
     * 
     * This test verifies that the static log() method continues to work with the
     * same parameters and produces the same results as before the fix.
     */
    public function test_property_audit_log_method_signature_unchanged(): void
    {
        // Arrange: Create a user and authenticate (required for audit logs)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Clear audit logs
        AuditLog::query()->delete();

        // Test with all parameters
        $log1 = AuditLog::log(
            'test_action',
            'TestModel',
            123,
            ['old' => 'value'],
            ['new' => 'value'],
            'Test description'
        );

        $this->assertInstanceOf(AuditLog::class, $log1);
        $this->assertEquals('test_action', $log1->action);
        $this->assertEquals('TestModel', $log1->model_type);
        $this->assertEquals(123, $log1->model_id);
        $this->assertEquals(['old' => 'value'], $log1->old_values);
        $this->assertEquals(['new' => 'value'], $log1->new_values);
        $this->assertEquals('Test description', $log1->description);

        // Test with minimal parameters (nulls where allowed)
        $log2 = AuditLog::log('minimal_action', 'MinimalModel', null, null, null, null);

        $this->assertInstanceOf(AuditLog::class, $log2);
        $this->assertEquals('minimal_action', $log2->action);
        $this->assertEquals('MinimalModel', $log2->model_type);
        $this->assertNull($log2->model_id);
        $this->assertNull($log2->old_values);
        $this->assertNull($log2->new_values);
        $this->assertNull($log2->description);

        // Verify both logs were created
        $this->assertEquals(2, AuditLog::count());
    }

    /**
     * Test that multiple audit log entries can be created in sequence
     * 
     * This verifies that the audit logging system can handle multiple actions
     * in sequence without interference, which is critical for preserving
     * existing functionality.
     */
    public function test_property_multiple_audit_actions_in_sequence(): void
    {
        // Arrange: Create a user and authenticate (required for audit logs)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Clear audit logs
        AuditLog::query()->delete();

        $actions = [
            'update_order_status',
            'create_sale_from_order',
            'resolve_alert',
            'update_order_status',
            'resolve_alert',
        ];

        // Create multiple audit logs in sequence
        foreach ($actions as $index => $action) {
            AuditLog::log($action, 'TestModel', $index, null, null, "Test {$action}");
        }

        // Assert: All audit logs were created
        $this->assertEquals(count($actions), AuditLog::count());

        // Assert: Each action was logged correctly
        foreach ($actions as $index => $action) {
            $log = AuditLog::where('action', $action)
                ->where('model_id', $index)
                ->first();

            $this->assertNotNull($log, "Audit log for {$action} should exist");
            $this->assertEquals($action, $log->action);
        }
    }
}
