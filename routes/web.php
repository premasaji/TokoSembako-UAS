<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CashierTransactionController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return redirect('/login');
});

// ================= LOGIN =================

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ADMIN =================

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/history',[AdminProductController::class,'history'])
    ->name('admin.history');

    Route::get('/admin/history/{id}',[AdminProductController::class,'historyDetail'])
    ->name('admin.history.detail');

    Route::get('/admin/dashboard', [AdminProductController::class, 'dashboard'])
        ->name('admin.dashboard');
    Route::post('/admin/product/store', [AdminProductController::class, 'store'])
        ->name('product.store');
    Route::get('/admin/product/{product}/edit', [AdminProductController::class, 'edit'])
        ->name('product.edit');
    Route::put('/admin/product/{product}', [AdminProductController::class, 'update'])
        ->name('product.update');
    Route::delete('/admin/product/{product}', [AdminProductController::class, 'destroy'])
        ->name('product.destroy');

        Route::delete('/admin/history/{id}', [AdminProductController::class,'destroyHistory'])
    ->name('admin.history.destroy');
});

// ================= KASIR =================

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/cashier', [CashierTransactionController::class, 'index'])
        ->name('cashier.index');
    Route::post('/cart/add/{id}', [CashierTransactionController::class, 'add'])
        ->name('cart.add');
    Route::post('/cart/plus/{id}', [CashierTransactionController::class, 'plus'])
        ->name('cart.plus');
    Route::post('/cart/minus/{id}', [CashierTransactionController::class, 'minus'])
        ->name('cart.minus');
    Route::post('/cart/remove/{id}', [CashierTransactionController::class, 'remove'])
        ->name('cart.remove');
    Route::post('/checkout', [CashierTransactionController::class, 'checkout'])
        ->name('checkout');
    Route::get('/receipt/{id}', [CashierTransactionController::class, 'receipt'])
        ->name('receipt');
});


//================== Riwayat ==================


Route::get('/history',[HistoryController::class,'index'])->name('history.index');
Route::get('/history/{order}',[HistoryController::class,'show'])->name('history.show');
