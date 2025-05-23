<?php

use App\Enums\TokenAbilityEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use App\Http\Controllers\Api\V1\Auth\VerifyController;

/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
|
|
*/

// User Registration
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('refresh', [AuthController::class, 'refresh'])->middleware(['auth:sanctum', 'refresh.token']);
Route::get('user',  [AuthController::class, 'user'])->middleware(['auth:sanctum', 'access.token']);


Route::middleware(['auth:sanctum', 'access.token'])->group(function () {
    Route::post('verify', [VerifyController::class, 'verify']);
    Route::post('reverify', [VerifyController::class, 'reverify'])->middleware('throttle:2,5');
});

Route::post('/password/reset-link', [PasswordResetController::class, 'sendResetLink']);
Route::get('/password/reset', [PasswordResetController::class, 'validateResetToken']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);


Route::get('login/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleCallback']);
