<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ColorImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

// Category Routes
Route::apiResource('categories', CategoryController::class);

// Product Routes
Route::apiResource('products', ProductController::class);
Route::post('/products/{product}/images', [ProductImageController::class, 'store']);
Route::get('/top-discounted-products', [ProductController::class, 'getTopDiscountedProducts']);

// Product Image Routes
Route::apiResource('product-images', ProductImageController::class);

// Product Color Routes
Route::apiResource('product-colors', ProductColorController::class);

// Color Image Routes
Route::apiResource('color-images', ColorImageController::class);

// Order Routes
Route::apiResource('orders', OrderController::class);
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);

// User Routes
Route::apiResource('users', AuthController::class);

// Message Routes
Route::apiResource('messages', MessageController::class);

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/user', [AuthController::class, 'index']);

// Debug Route
Route::get('/debug-test', function () {
    return 'Debug route OK';
});