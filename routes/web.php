<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgenController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SuperAdminController;
use App\Models\Role;
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

Route::prefix('')->group(function () {
    Route::get('', [GuestController::class, 'index'])->name('index')->middleware('isGuest');
});

Route::name('customer.')->prefix('customer')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'customer'], function () {
            Route::get('', [CustomerController::class, 'index'])->name('index');
            Route::get('kirim-paket', [ItemController::class, 'index'])->name('item');
            Route::get('lacak-paket', [ItemController::class, 'lacakPaket'])->name('lacak-paket');
            Route::get('sejarah-pengiriman', [ItemController::class, 'sejarahPengiriman'])->name('sejarah-pengiriman');
        });
    });
});

Route::name('agen.')->prefix('agen')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'agen'], function () {
            Route::get('', [AgenController::class, 'index'])->name('index');
        });
    });
});

Route::name('finance.')->prefix('finance')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'finance'], function () {
            Route::get('', [FinanceController::class, 'index'])->name('index');
        });
    });
});

Route::name('admin.')->prefix('admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'admin'], function () {
            Route::get('', [AdminController::class, 'index'])->name('index');
        });
    });
});

Route::name('super_admin.')->prefix('super_admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'super_admin'], function () {
            Route::get('', [SuperAdminController::class, 'index'])->name('index');
        });
    });
});

Route::name('auth.')->prefix('auth')->group(function () {
    Route::group(['middleware' => 'isGuest'], function () {
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('store');
        Route::get('register', [RegisterController::class, 'index'])->name('register');
        Route::post('register', [RegisterController::class, 'store'])->name('store');
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});