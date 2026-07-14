<?php

use App\Http\Controllers\Admin\RecipeController;
use Illuminate\Support\Facades\Route;

// TODO: 나중에 JWT 미들웨어 + admin 미들웨어 붙일 것
Route::prefix('admin')->group(function () {
    Route::apiResource('recipes', RecipeController::class);
});
