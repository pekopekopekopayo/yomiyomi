<?php

use App\Http\Controllers\Api\Admin\RecipeController as AdminRecipeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::apiResource('recipes', RecipeController::class)
    ->only(['index', 'show']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('recipes', AdminRecipeController::class);
});
