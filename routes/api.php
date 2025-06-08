<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ColorImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Product Routes
    Route::apiResource('products', ProductController::class);
    Route::post('/products/{product}/images', [ProductImageController::class, 'store']);
    Route::get('/top-discounted-products', [ProductController::class, 'getTopDiscountedProducts']);
//Orders
    Route::apiResource('orders', OrderController::class);

    // Category Routes
    Route::apiResource('categories', CategoryController::class);

    
    // Product Image Routes
    Route::apiResource('product-images', ProductImageController::class);

    // Product Color Routes
    Route::apiResource('product-colors', ProductColorController::class);

    // Color Image Routes
    Route::apiResource('color-images', ColorImageController::class);
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

    Route::get('/debug-test', function () {
        return 'Debug route OK';
    });
