<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlatController;


// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Categories
    Route::apiResource('categories', CategoryController::class);

    // Plats
    Route::apiResource('plats', PlatController::class);

    //categorie / plat

    Route::post('categories/{category}/plats', [PlatController::class, 'storeByCategory']);
});
