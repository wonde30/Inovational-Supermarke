<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Find or create user
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'phone' => '', // Will need to collect later if required
                    'password' => Hash::make(uniqid()), // Random password
                    'email_verified_at' => now(),
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Update google_id if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'email_verified_at' => $user->email_verified_at ?? now(),
                    ]);
                }
            }
            
            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Redirect to frontend callback with token and user data
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            $userData = urlencode(json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]));
            
            return redirect("{$frontendUrl}/auth/social/callback?token={$token}&user={$userData}");
            
        } catch (\Exception $e) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            $errorMessage = urlencode('Google authentication failed: ' . $e->getMessage());
            return redirect("{$frontendUrl}/auth/social/callback?error={$errorMessage}");
        }
    }
}
