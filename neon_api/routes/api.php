<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('auth')->group(function() {
    Route::get('/user', [AuthController::class, 'index']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::patch('/category/update/{category:slug}', [CategoryController::class, 'status']);
});

Route::get('/categories', [CategoryController::class, 'active']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'store']);