<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {

    // User Registration
    Route::post('register', [AuthController::class, 'register']);

    // User Login
    Route::post('login', [AuthController::class, 'login']);

    // Logout (using token or session)
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

    // Email Verification
    Route::post('verify-email', [VerificationController::class, 'sendVerificationCode']);
    Route::post('verify-email/{user}', [VerificationController::class, 'verifyEmail'])->name('email.verify');

    // Password Reset
    Route::post('password/email', [PasswordResetController::class, 'sendPasswordResetLink']);
    Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);

    // Social Authentication (Google, Facebook, etc.)
    Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
    Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
});
