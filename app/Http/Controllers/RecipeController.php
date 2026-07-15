<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Contracts\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::latest()->paginate(20);

        return view('recipes.index', compact('recipes'));
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load(['user', 'ingredients', 'steps']);

        return view('recipes.show', compact('recipe'));
    }
}
