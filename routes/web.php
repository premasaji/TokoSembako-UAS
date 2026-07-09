<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CashierTransactionController;

Route::get('/', function () {
    return redirect('/login');
});

// ================= LOGIN =================

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ADMIN =================

Route::middleware(['auth', 'role:admin'])->group(function () {

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
});

// ================= KASIR =================

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/cashier', [CashierTransactionController::class, 'index'])
        ->name('cashier.index');

    Route::post('/cashier/checkout',
    [CashierTransactionController::class,'checkout'])
    ->name('cashier.checkout');
    
    Route::get('/cashier/receipt/{order}',
    [CashierTransactionController::class,'receipt'])
    ->name('cashier.receipt');
});