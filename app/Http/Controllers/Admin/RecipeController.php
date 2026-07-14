<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
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

    public function store(Request $request): RecipeResource
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'image' => ['required', 'image', 'max:5120'],
        ]);

        $recipe = Recipe::create([
            'title' => $validated['title'],
            'user_id' => $validated['user_id'],
        ]);

        $recipe->addMediaFromRequest('image')->toMediaCollection('cover');

        return new RecipeResource($recipe->load('user'));
    }

    public function update(Request $request, Recipe $recipe): RecipeResource
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'image' => ['sometimes', 'image', 'max:5120'],
        ]);

        if (isset($validated['title'])) {
            $recipe->update(['title' => $validated['title']]);
        }

        if ($request->hasFile('image')) {
            $recipe->addMediaFromRequest('image')->toMediaCollection('cover');
        }

        return new RecipeResource($recipe->load('user'));
    }

    public function destroy(Recipe $recipe): \Illuminate\Http\Response
    {
        $recipe->steps()->delete();
        $recipe->ingredients()->detach();
        $recipe->delete();

        return response()->noContent();
    }
}
