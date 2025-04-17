<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\DesignController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\PayController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\SubscriptionController;

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

Route::prefix('likes')->group(function () {
    Route::post('/toggle', [LikeController::class, 'toggle']);
});

Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
});

Route::prefix('customers')->group(function () {
    Route::post('/', [CustomerController::class, 'upsert']);
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::delete('/remove', [CartController::class, 'remove']);
    Route::post('/empty', [CartController::class, 'empty']);
});

Route::prefix('subscriptions')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index']);
});

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('/', [NotificationController::class, 'read']);
});

Route::prefix('pays')->group(function () {
    Route::get('/', [PayController::class, 'points']);
});

Route::prefix('purchases')->group(function () {
    Route::get('/', [PurchaseController::class, 'index']);
    Route::get('/download/{design}', [PurchaseController::class, 'download'])->name('design.download')->middleware(['signed']);
});
