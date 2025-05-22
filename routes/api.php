<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class)
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('products',  ProductController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::apiResource('categories', CategoryController::class)
        ->only(['index', 'show']);
Route::apiResource('products', ProductController::class)
        ->only(['index', 'show']);
