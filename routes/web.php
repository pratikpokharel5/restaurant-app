<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;

Route::redirect('/', '/categories');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        'categories' => CategoryController::class,
        'menus' => MenuController::class,
    ]);

    Route::resource('orders', OrderController::class)->only(['index', 'edit', 'update']);
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    Route::resource('payments', PaymentController::class)->only(['index']);
});
