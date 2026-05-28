<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;

// Route::post('/auth/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::get('/user', function (Request $request) {
//         return [
//             'message' => 'User retrieved successfully.',
//             'data' => $request->user(),
//         ];
//     });

//     Route::apiResource('categories', CategoryController::class);
//     Route::apiResource('menus', MenuController::class);

//     Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store', 'update']);
//     Route::apiResource('payments', PaymentController::class)->only(['index', 'store']);
//     Route::apiResource('customers', CustomerController::class)->only(['index', 'show']);
// });
