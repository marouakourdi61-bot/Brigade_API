<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;



// Auth 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // client
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Routes client uniquement
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}/plats', [CategoryController::class, 'showPlates']);

    Route::get('plats', [PlatController::class, 'index']);
    Route::get('plats/{plat}', [PlatController::class, 'show']);

   
});

// admin 
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {

    // Categories 
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Plats 
    Route::post('plats', [PlatController::class, 'store']);
    Route::put('plats/{plat}', [PlatController::class, 'update']);
    Route::delete('plats/{plat}', [PlatController::class, 'destroy']);

    // Ajouter un plat à une catégorie
    Route::post('categories/{category}/plats', [PlatController::class, 'storeByCategory']);

  
});