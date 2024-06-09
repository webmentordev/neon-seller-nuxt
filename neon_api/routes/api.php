<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Private admin / dashboard Routes
Route::middleware(['auth:sanctum'])->prefix('auth')->group(function() {
    Route::get('/user', [AuthController::class, 'index']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::patch('/category/update/{category:slug}', [CategoryController::class, 'status']);
    
    Route::get('/contacts', [ContactController::class, 'index']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/product/create', [ProductController::class, 'store']);

    Route::get('/prices', [PriceController::class, 'index']);
    Route::post('/price/create', [PriceController::class, 'store']);
});

// Public Routes
Route::post('/contact/create', [ContactController::class, 'store']);

Route::get('/products', [ProductController::class, 'active']);
Route::get('/product/{product:slug}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'active']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'store']);