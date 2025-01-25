<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DesignController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SubscriptionController;
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
    Route::get('/', [DesignController::class, 'index'])->name('designs.index');
    Route::get('/search', [DesignController::class, 'search'])->name('designs.search');
    Route::get('/all', fn(Request $req) => redirect()->route('designs.index', $req->query()));
});

Route::prefix('likes')->group(function () {
    Route::post('/toggle', [LikeController::class, 'toggle']);
});

Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::delete('/remove', [CartController::class, 'remove']);
    Route::post('/empty', [CartController::class, 'empty']);
});

Route::prefix('subscription')->group(function () {

    Route::get('/', [SubscriptionController::class, 'index']);
    Route::post('/', [SubscriptionController::class, 'store']);
});

Route::prefix('customers')->group(function () {
    Route::post('/', [CustomerController::class, 'upsert']);
});
