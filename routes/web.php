<?php

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::post('/migrate', function (Request $request) {
    $secret = env('DATABASE_MIGRATE_SECRET');
    if ($request->header('X-MIGRATION-Secret') !== $secret) {
        abort(403, 'Unauthorized action.');
    }

    // Prevent this in production
    if (app()->environment('production')) {
        abort(403, 'This operation is not allowed in production.');
    }

    Artisan::call('migrate:fresh', ['--seed' => true]);
    $output = Artisan::output();

    Track::create([
        'action' => 'migration',
        'ip_address' => $request->ip(),
        'details' => $output,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Migration and seeding completed successfully',
        'output' => $output,
    ]);
});

Route::post('/git/pull', function (Illuminate\Http\Request $request) {
    $secret = env('GIT_PULL_SECRET');
    if ($request->header('X-Git-Secret') !== $secret) {
        abort(403, 'Unauthorized action.');
    }

    $output = [];
    $status = null;
    exec('git pull 2>&1', $output, $status);

    Track::create([
        'action' => 'git_pull',
        'ip_address' => $request->ip(),
        'details' => implode("\n", $output),
    ]);

    return response()->json([
        'status' => $status === 0 ? 'success' : 'error',
        'message' => implode("\n", $output),
    ]);
});
