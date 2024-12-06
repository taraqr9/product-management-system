<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user/create', [AuthController::class, 'createUser'])->name('user.create');
    Route::delete('/user/delete/{id}', [AuthController::class, 'deleteUser'])->name('user.delete');

    Route::resource('products', ProductController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});

