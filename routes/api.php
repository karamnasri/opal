<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DesignController;
use App\Http\Controllers\Api\V1\LikeController;
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


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::prefix('designs')->group(function () {
    Route::get('/', [DesignController::class, 'index']);
    Route::get('/liked', [DesignController::class, 'liked']);
});

Route::prefix('likes')->group(function () {
    Route::post('/toggle', [LikeController::class, 'toggle']);
});
