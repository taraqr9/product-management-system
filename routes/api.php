<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user/store', [UserController::class, 'store'])->name('user.create');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

    Route::resource('products', ProductController::class);
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/payments', [PaymentController::class, 'process'])->name('payments.process');

    Route::post('/logout', [AuthController::class, 'logout']);
});
