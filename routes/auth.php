<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;

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
Route::post('verify', [AuthController::class, 'verify']);
Route::post('reverify', [AuthController::class, 'reverify']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('login/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleCallback']);
