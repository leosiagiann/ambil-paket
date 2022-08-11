<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgenController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
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

Route::name('index')->prefix('')->group(function () {
    Route::group(['middleware' => 'isGuest'], function () {
        Route::get('', [GuestController::class, 'index']);
    });
});

Route::name('customer.')->prefix('customer')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'customer'], function () {
            Route::get('', [CustomerController::class, 'index'])->name('index');
            Route::get('kirim-paket', [ItemController::class, 'index'])->name('item');
            Route::get('lacak-paket', [ItemController::class, 'lacakPaket'])->name('lacak-paket');
            Route::get('riwayat-pengiriman', [ItemController::class, 'riwayatPengiriman'])->name('riwayat-pengiriman');
            Route::get('profile', [ProfileController::class, 'index'])->name('profile');
            Route::put('edit-profile', [ProfileController::class, 'update'])->name('edit-profile');
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
            Route::get('customer', [AdminController::class, 'customer'])->name('customer');
            Route::get('customer/activate/{customer}', [AdminController::class, 'activateCustomer'])->name('customer.activate');
            Route::get('customer/deactivate/{customer}', [AdminController::class, 'deactivateCustomer'])->name('customer.deactivate');
            Route::delete('customer/{customer}', [AdminController::class, 'destroyCustomer'])->name('customer.destroy');
        });
    });
});

Route::name('super_admin.')->prefix('super_admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'super_admin'], function () {
            Route::get('', [SuperAdminController::class, 'index'])->name('index');
            Route::get('admin', [SuperAdminController::class, 'admin'])->name('admin');
            Route::get('admin/activate/{admin}', [SuperAdminController::class, 'activateAdmin'])->name('admin.activate');
            Route::get('admin/deactivate/{admin}', [SuperAdminController::class, 'deactivateAdmin'])->name('admin.deactivate');
            Route::put('admin/{admin}', [SuperAdminController::class, 'updateAdmin'])->name('admin.update');
            Route::delete('admin/{admin}', [SuperAdminController::class, 'destroyAdmin'])->name('admin.destroy');
            Route::get('finance', [SuperAdminController::class, 'finance'])->name('finance');
            Route::delete('finance/{finance}', [SuperAdminController::class, 'destroyFinance'])->name('finance.destroy');
            Route::put('finance/{finance}', [SuperAdminController::class, 'updateFinance'])->name('finance.update');
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