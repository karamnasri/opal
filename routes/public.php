<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\DesignController;
use App\Http\Controllers\Api\V1\CategoryController;


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
    Route::get('/', [DesignController::class, 'index'])->name('designs.index');
});

Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
});
