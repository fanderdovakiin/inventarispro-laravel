<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(
        Auth::check() ? 'dashboard' : 'login'
    );
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ])->name('dashboard');

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ])->name('logout');

    // Route kategori harus berada di dalam grup auth.
    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    Route::resource('products', ProductController::class)
        ->except(['show']);

    Route::resource('suppliers', SupplierController::class);
    // Transaksi barang masuk
    Route::get('/stock/in', [
        StockInController::class,
        'create',
    ])->name('stock.in.create');

    Route::post('/stock/in', [
        StockInController::class,
        'store',
    ])->name('stock.in.store');

    // Transaksi barang keluar
    Route::get('/stock/out', [
        StockOutController::class,
        'create',
    ])->name('stock.out.create');

    Route::post('/stock/out', [
        StockOutController::class,
        'store',
    ])->name('stock.out.store');

    // Histori pergerakan stok
    Route::get('/stock/history', [
        StockMovementController::class,
        'index',
    ])->name('stock.history');
});
