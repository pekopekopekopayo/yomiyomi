<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::latest()->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    public function create(): View
    {
        return view('admin.recipes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request, imageRequired: true);

        $recipe = DB::transaction(function () use ($request, $validated) {
            $recipe = Recipe::create([
                'title' => $validated['title'],
                'user_id' => $request->user()->id,
            ]);

            $recipe->addMediaFromRequest('image')->toMediaCollection('cover');
            $this->syncIngredients($recipe, $validated['ingredients'] ?? []);
            $this->syncSteps($recipe, $validated['steps'] ?? []);

            return $recipe;
        });

        return redirect()->route('admin.recipes.show', $recipe);
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load(['user', 'ingredients', 'steps']);

        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe): View
    {
        $recipe->load(['ingredients', 'steps']);

        return view('admin.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $validated = $this->validateRequest($request, imageRequired: false);

        DB::transaction(function () use ($request, $recipe, $validated) {
            $recipe->update(['title' => $validated['title']]);

            if ($request->hasFile('image')) {
                $recipe->addMediaFromRequest('image')->toMediaCollection('cover');
            }

            $this->syncIngredients($recipe, $validated['ingredients'] ?? []);
            $this->syncSteps($recipe, $validated['steps'] ?? []);
        });

        return redirect()->route('admin.recipes.show', $recipe);
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        DB::transaction(function () use ($recipe) {
            $recipe->steps()->delete();
            $recipe->ingredients()->detach();
            $recipe->delete();
        });

        return redirect()->route('admin.recipes.index');
    }

    private function validateRequest(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => [$imageRequired ? 'required' : 'sometimes', 'image', 'max:5120'],
            'ingredients' => ['array'],
            'ingredients.*.name' => ['required', 'string', 'max:100'],
            'ingredients.*.amount' => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required', 'string', 'max:20'],
            'steps' => ['array'],
            'steps.*.position' => ['required', 'integer', 'min:1'],
            'steps.*.description' => ['required', 'string'],
        ]);
    }

    private function syncIngredients(Recipe $recipe, array $ingredients): void
    {
        $recipe->ingredients()->detach();

        foreach ($ingredients as $data) {
            $ingredient = Ingredient::firstOrCreate(['name' => $data['name']]);
            $recipe->ingredients()->attach($ingredient->id, [
                'amount' => $data['amount'],
                'unit' => $data['unit'],
            ]);
        }
    }

    private function syncSteps(Recipe $recipe, array $steps): void
    {
        $recipe->steps()->delete();

        foreach ($steps as $data) {
            $recipe->steps()->create([
                'position' => $data['position'],
                'description' => $data['description'],
            ]);
        }
    }
}
