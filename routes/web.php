<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineNotifyController;
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
    Route::post('home', [HomeController::class, 'saveSetting'])->name('saveSetting');
    Route::prefix('setting/')->name('setting.')->group(function () {
        Route::get('nueip', [NueipController::class, 'index'])->name('nueip');
        Route::post('nueip', [NueipController::class, 'save']);
        Route::get('blacklist-days', [HomeController::class, 'index']);
        Route::prefix('line-notify/')->name('line-notify.')->group(function () {
            Route::get('', [LineNotifyController::class, 'index'])->name('index');
            Route::get('bind', [LineNotifyController::class, 'bind'])->name('bind');
            Route::delete('', [LineNotifyController::class, 'del'])->name('del');
        });
    });
});

Route::prefix('callback/')->group(function () {
    Route::get('line-notify', [LineNotifyController::class, 'callback']);
});
