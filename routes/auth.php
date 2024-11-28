<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
|
|
*/

// User Registration
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('reverify', [AuthController::class, 'reverify']);
//TODO: Add resend email to for verification
