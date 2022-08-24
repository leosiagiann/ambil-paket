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
            Route::get('profile', [ProfileController::class, 'index'])->name('profile');
            Route::put('edit-profile', [ProfileController::class, 'update'])->name('edit-profile');

            Route::get('kirim-paket', [ItemController::class, 'index'])->name('item');
            Route::get('kirim-paket/create', [ItemController::class, 'createItem'])->name('item.create');
            Route::post('kirim-paket/create', [ItemController::class, 'storeItem'])->name('item.store');
            Route::post('kirim-paket/payment/{item}', [ItemController::class, 'paymentItem'])->name('item.payment');
            Route::post('kirim-paket/Yes/{item}', [ItemController::class, 'confirmYes'])->name('item.confirmYes');
            Route::post('kirim-paket/No/{item}', [ItemController::class, 'confirmNo'])->name('item.confirmNo');
            Route::get('lacak-paket', [ItemController::class, 'lacakPaket'])->name('lacak-paket');
            Route::post('lacak-paket', [ItemController::class, 'lacakPaketResi'])->name('lacak-paket-resi');
            Route::get('riwayat-pengiriman', [ItemController::class, 'riwayatPengiriman'])->name('riwayat-pengiriman');
        });
    });
});

Route::name('agen.')->prefix('agen')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'agen'], function () {
            Route::get('', [AgenController::class, 'index'])->name('index');
            Route::get('konfirmasi-paket', [AgenController::class, 'confirmPaket'])->name('confirm');
            Route::get('konfirmasi-paket/process/{item}', [AgenController::class, 'processPaket'])->name('confirm.process');
            Route::get('konfirmasi-paket/notProcess/{item}', [AgenController::class, 'notProcessPaket'])->name('confirm.notProcess');
            Route::post('reject-paket/{item}', [AgenController::class, 'rejectConfirm'])->name('confirm.reject');
            Route::post('accept-paket/{item}', [AgenController::class, 'acceptConfirm'])->name('confirm.accept');


            Route::get('riwayat-pengiriman', [AgenController::class, 'riwayatPengiriman'])->name('riwayat-pengiriman');

            Route::get('info-paket', [AgenController::class, 'infoPaket'])->name('info-paket');
            Route::post('info-paket/{item}', [AgenController::class, 'tambahPosisi'])->name('tambah-posisi-paket');
            Route::post('info-paket/finish/{item}', [AgenController::class, 'finishPosisi'])->name('finish-posisi-paket');
        });
    });
});

Route::name('finance.')->prefix('finance')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'finance'], function () {
            Route::get('', [FinanceController::class, 'index'])->name('index');

            Route::get('agen', [FinanceController::class, 'agen'])->name('agen');
            Route::get('agen/{agen}', [FinanceController::class, 'createBank'])->name('agen.createBank');
            Route::post('agen/{agen}', [FinanceController::class, 'storeBank'])->name('agen.storeBank');
            Route::get('agen/edit-bank/{bank}', [FinanceController::class, 'editBank'])->name('agen.editBank');
            Route::put('agen/edit-bank/{bank}', [FinanceController::class, 'updateBank'])->name('agen.updateBank');
            Route::delete('agen/{bank}', [FinanceController::class, 'destroyBank'])->name('agen.destroyBank');

            Route::get('item', [FinanceController::class, 'item'])->name('item');
            Route::get('item/done', [FinanceController::class, 'itemDone'])->name('item.done');
            Route::get('item/cancel', [FinanceController::class, 'itemCancel'])->name('item.cancel');
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

            Route::get('agen', [AdminController::class, 'agen'])->name('agen');
            Route::get('agen/activate/{agen}', [AdminController::class, 'activateAgen'])->name('agen.activate');
            Route::get('agen/deactivate/{agen}', [AdminController::class, 'deactivateAgen'])->name('agen.deactivate');
            Route::delete('agen/{agen}', [AdminController::class, 'destroyAgen'])->name('agen.destroy');

            Route::get('item', [AdminController::class, 'item'])->name('item');
            Route::get('item-pengiriman', [AdminController::class, 'pengirimanItem'])->name('item.pengiriman');
            Route::get('item-pengiriman/{item}', [AdminController::class, 'generateResi'])->name('item.generateResi');

            Route::get('riwayat-pengiriman', [AdminController::class, 'riwayatPengiriman'])->name('riwayat-pengiriman');
        });
    });
});

Route::name('super_admin.')->prefix('super_admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'super_admin'], function () {
            Route::get('', [SuperAdminController::class, 'index'])->name('index');


            Route::get('admin', [SuperAdminController::class, 'admin'])->name('admin');
            Route::get('admin/create', [SuperAdminController::class, 'createAdmin'])->name('admin.create');
            Route::post('admin/create', [SuperAdminController::class, 'storeAdmin'])->name('admin.store');
            Route::get('admin/activate/{admin}', [SuperAdminController::class, 'activateAdmin'])->name('admin.activate');
            Route::get('admin/deactivate/{admin}', [SuperAdminController::class, 'deactivateAdmin'])->name('admin.deactivate');
            Route::get('admin/{admin}', [SuperAdminController::class, 'editAdmin'])->name('admin.edit');
            Route::put('admin/{admin}', [SuperAdminController::class, 'updateAdmin'])->name('admin.update');
            Route::delete('admin/{admin}', [SuperAdminController::class, 'destroyAdmin'])->name('admin.destroy');

            Route::get('finance', [SuperAdminController::class, 'finance'])->name('finance');
            Route::get('finance/create', [SuperAdminController::class, 'createFinance'])->name('finance.create');
            Route::post('finance/create', [SuperAdminController::class, 'storeFinance'])->name('finance.store');
            Route::get('finance/activate/{finance}', [SuperAdminController::class, 'activateFinance'])->name('finance.activate');
            Route::get('finance/deactivate/{finance}', [SuperAdminController::class, 'deactivateFinance'])->name('finance.deactivate');
            Route::get('finance/{finance}', [SuperAdminController::class, 'editFinance'])->name('finance.edit');
            Route::put('finance/{finance}', [SuperAdminController::class, 'updateFinance'])->name('finance.update');
            Route::delete('finance/{finance}', [SuperAdminController::class, 'destroyFinance'])->name('finance.destroy');

            Route::get('item', [SuperAdminController::class, 'item'])->name('item');
            Route::get('item/done', [SuperAdminController::class, 'itemDone'])->name('item.done');
            Route::get('item/cancel', [SuperAdminController::class, 'itemCancel'])->name('item.cancel');
            
            Route::get('customer', [SuperAdminController::class, 'customer'])->name('customer');
            Route::get('customer/activate/{customer}', [SuperAdminController::class, 'activateCustomer'])->name('customer.activate');
            Route::get('customer/deactivate/{customer}', [SuperAdminController::class, 'deactivateCustomer'])->name('customer.deactivate');
            Route::delete('customer/{customer}', [SuperAdminController::class, 'destroyCustomer'])->name('customer.destroy');

            Route::get('agen', [SuperAdminController::class, 'agen'])->name('agen');
            Route::get('agen/activate/{agen}', [SuperAdminController::class, 'activateAgen'])->name('agen.activate');
            Route::get('agen/deactivate/{agen}', [SuperAdminController::class, 'deactivateAgen'])->name('agen.deactivate');
            Route::delete('agen/{agen}', [SuperAdminController::class, 'destroyAgen'])->name('agen.destroy');
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