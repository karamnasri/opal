<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/migrate', function () {
    Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
    $output = Illuminate\Support\Facades\Artisan::output();

    return response()->json([
        'status' => 'success',
        'message' => 'Migration and seeding completed successfully',
        'output' => $output,
    ]);
});
