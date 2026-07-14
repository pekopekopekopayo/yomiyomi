<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RecipeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $recipes = Recipe::latest()->paginate(20);

        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe): RecipeResource
    {
        $recipe->load(['user', 'ingredients', 'steps']);

        return new RecipeResource($recipe);
    }
}
