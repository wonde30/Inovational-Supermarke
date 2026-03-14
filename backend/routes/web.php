<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Welcome to Smart SuperMarket API',
        'data' => [
            'name' => 'Smart SuperMarket Management System',
            'version' => '1.0.0'
        ]
    ]);
});

// Email verification route (must be in web.php for proper redirects)
Route::get('/api/v1/auth/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->name('verification.verify');
