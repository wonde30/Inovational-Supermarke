<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            return $this->error('Please verify your email address before logging in.', 403);
        }

        // Check if user is active
        if (!$user->is_active) {
            return $this->error('Your account has been deactivated. Please contact support.', 403);
        }

        // Create token with expiration
        $expiresAt = now()->addMinutes((int) config('sanctum.expiration', 1440));
        $token = $user->createToken('auth-token', ['*'], $expiresAt)->plainTextToken;

        // Log the successful login (temporarily set auth user for audit logging)
        Auth::setUser($user);
        AuditLog::log('login', 'User', $user->id, null, null, 'User logged in successfully');

        return $this->success([
            'user' => $user,
            'token' => $token,
            'expires_at' => $expiresAt->toISOString(),
        ], 'Login successful');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logged out successfully');
    }

    public function me(Request $request)
    {
        return $this->success($request->user(), 'User retrieved successfully');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).'
        ]);

        $user = User::create([
            'name' => $this->sanitizeInput($request->name),
            'email' => $this->sanitizeInput($request->email),
            'phone' => $this->sanitizeInput($request->phone),
            'password' => Hash::make($request->password),
            'role' => User::ROLE_CUSTOMER,
            'is_active' => true,
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        return $this->success([
            'user' => $user,
            'message' => 'Registration successful. Please check your email to verify your account.',
        ], 'Registration successful. Please verify your email.', 201);
    }

    /**
     * Verify email address
     */
    /**
     * Verify user email address
     * 
     * GET /api/v1/auth/verify-email/{id}/{hash}
     * 
     * @param Request $request
     * @param int $id
     * @param string $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        try {
            // Find user
            $user = User::findOrFail($id);

            // Verify hash
            if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
                Log::warning('Email verification failed - invalid hash', [
                    'user_id' => $id,
                    'provided_hash' => substr($hash, 0, 10) . '...',
                ]);
                
                // Redirect to frontend with error
                return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=error&message=invalid_link');
            }

            // Verify signature (Laravel's signed URL verification)
            if (!$request->hasValidSignature()) {
                Log::warning('Email verification failed - invalid signature', [
                    'user_id' => $id,
                ]);
                
                return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=error&message=expired_link');
            }

            // Check if already verified
            if ($user->hasVerifiedEmail()) {
                Log::info('Email already verified', [
                    'user_id' => $user->id,
                ]);
                
                // Redirect to frontend - already verified
                return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=already&message=already_verified');
            }

            // Mark as verified
            $user->markEmailAsVerified();
            
            Log::info('Email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            // Redirect to frontend with success
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=success&message=email_verified');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Email verification failed - user not found', [
                'user_id' => $id ?? null,
            ]);
            
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=error&message=user_not_found');
            
        } catch (\Exception $e) {
            Log::error('Email verification failed', [
                'error' => $e->getMessage(),
                'user_id' => $id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?verified=error&message=verification_failed');
        }
    }

    /**
     * Resend email verification
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('User not found.', 404);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->error('Email already verified.', 400);
        }

        $user->sendEmailVerificationNotification();

        return $this->success(null, 'Verification email sent.');
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token with expiration
        $expiresAt = now()->addMinutes(config('sanctum.expiration', 1440));
        $token = $user->createToken('auth-token', ['*'], $expiresAt)->plainTextToken;

        return $this->success([
            'token' => $token,
            'expires_at' => $expiresAt->toISOString(),
        ], 'Token refreshed successfully');
    }

    /**
     * Send password reset link
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Don't reveal if user exists or not for security
            return $this->success(null, 'If an account exists with this email, you will receive a password reset link.');
        }

        // Generate a simple token
        $token = \Illuminate\Support\Str::random(64);
        
        // Store token in database
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => \Illuminate\Support\Facades\Hash::make($token),
                'created_at' => now()
            ]
        );

        // Try to send email, but don't fail if it doesn't work
        try {
            $user->sendPasswordResetNotification($token);
        } catch (\Exception $e) {
            // Log the error but don't expose it to the user
            \Illuminate\Support\Facades\Log::error('Password reset email failed: ' . $e->getMessage());
        }

        return $this->success(null, 'If an account exists with this email, you will receive a password reset link.');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('Invalid reset token or email.', 400);
        }

        // Get the token from database
        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return $this->error('Invalid or expired reset token.', 400);
        }

        // Check if token is expired (24 hours)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
            return $this->error('Reset token has expired.', 400);
        }

        // Verify token
        if (!\Illuminate\Support\Facades\Hash::check($request->token, $resetRecord->token)) {
            return $this->error('Invalid reset token.', 400);
        }

        // Update password (will be automatically hashed by Laravel due to 'hashed' cast)
        $user->password = $request->password;
        $user->save();

        // Delete the token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Revoke all existing tokens
        $user->tokens()->delete();

        return $this->success(null, 'Password reset successfully. Please login with your new password.');
    }

    /**
     * Verify reset token
     */
    public function verifyResetToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('Invalid reset token or email.', 400);
        }

        // Get the token from database
        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return $this->error('Invalid or expired reset token.', 400);
        }

        // Check if token is expired (24 hours)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
            return $this->error('Reset token has expired.', 400);
        }

        // Verify token (token is hashed in database)
        if (!Hash::check($request->token, $resetRecord->token)) {
            return $this->error('Invalid reset token.', 400);
        }

        return $this->success(null, 'Token is valid.');
    }

    /**
     * Update user language preference
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,am,or'
        ]);

        $user = $request->user();
        $user->language = $request->language;
        $user->save();

        return $this->success([
            'language' => $user->language,
            'message' => 'Language preference updated successfully'
        ], 'Language updated successfully');
    }

    /**
     * Get available languages
     */
    public function getLanguages()
    {
        return $this->success([
            'languages' => [
                ['code' => 'en', 'name' => 'English', 'nativeName' => 'English', 'flag' => 'ENG'],
                ['code' => 'am', 'name' => 'Amharic', 'nativeName' => 'አማርኛ', 'flag' => 'AMH'],
                ['code' => 'or', 'name' => 'Oromo', 'nativeName' => 'Afaan Oromoo', 'flag' => 'ORM']
            ]
        ], 'Languages retrieved successfully');
    }


    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
        ]);

        $user = $request->user();

        if ($request->has('name')) {
            $user->name = $this->sanitizeInput($request->name);
        }

        if ($request->has('phone')) {
            $user->phone = $this->sanitizeInput($request->phone);
        }

        $user->save();

        // Log the profile update
        AuditLog::log('update', 'User', $user->id, null, null, 'User profile updated');

        return $this->success([
            'user' => $user,
        ], 'Profile updated successfully');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).'
        ]);

        $user = $request->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error('Current password is incorrect.', 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log the password change
        AuditLog::log('update', 'User', $user->id, null, null, 'User password changed');

        // Revoke all existing tokens except current one
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $user->tokens()->where('id', '!=', $currentTokenId)->delete();

        return $this->success(null, 'Password updated successfully. Other sessions have been logged out.');
    }

    /**
     * Sanitize user input to prevent XSS
     */
    private function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}
