<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController; 
use Illuminate\Support\Facades\Route;

//Public Routes (No Authentication Required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

//Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    //Order & Checkout Routes
    Route::post('/cart/add', [OrderController::class, 'addToCart']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
});
