<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('static.welcome');
});

Route::get('/dashboard', function () {
    return view('app.client.dashboard');
})->middleware(['auth:web'])->name('dashboard');

Route::prefix('qr-code')->name('qr-code.')->group(function () {
    Route::get('/', App\Http\Controllers\Qrcode\ShowController::class)->name('index');
    Route::post('/create', App\Http\Controllers\Qrcode\CreateController::class)->name('create');

    Route::get('/scan', App\Http\Controllers\Qrcode\ScannerController::class)->name('scan');
});

require __DIR__.'/auth.php';
