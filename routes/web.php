<?php

use App\Http\Controllers\QrcodeController;
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
    return view('auth.client.dashboard');
})->middleware(['auth:web'])->name('dashboard');

Route::get('/qr-code', App\Http\Controllers\Qrcode\ShowController::class)->name('qr-code');
Route::post('/qr-code', App\Http\Controllers\Qrcode\CreateController::class);

require __DIR__.'/auth.php';
