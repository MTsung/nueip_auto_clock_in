<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NueipController;
use Illuminate\Support\Facades\Auth;
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
    return redirect(route('home'));
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::prefix('setting/')->name('setting.')->group(function () {
        Route::get('nueip', [NueipController::class, 'index'])->name('nueip');
        Route::post('nueip', [NueipController::class, 'save']);
        Route::get('blacklist-days', [HomeController::class, 'index']);
        Route::get('line-notify', [HomeController::class, 'index']);
    });
    Route::get('logs', [LogController::class, 'index'])->name('logs');
});

Route::prefix('callback/')->group(function () {
    Route::post('line-notify', [HomeController::class, 'index']);
});
