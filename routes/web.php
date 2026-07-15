<?php

use App\Http\Controllers\Admin\RecipeController as AdminRecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('recipes.index'));

Route::resource('recipes', RecipeController::class)->only(['index', 'show']);

Route::get('/dashboard', fn () => redirect()->route('admin.recipes.index'))
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('recipes', AdminRecipeController::class);
});

require __DIR__.'/auth.php';
