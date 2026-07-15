<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">레시피 수정</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @php
                $existingIngredients = $recipe->ingredients->map(fn ($i) => [
                    'name' => $i->name,
                    'amount' => (float) $i->pivot->amount,
                    'unit' => $i->pivot->unit,
                ])->values()->all();
                $existingSteps = $recipe->steps->map(fn ($s) => [
                    'position' => $s->position,
                    'description' => $s->description,
                ])->values()->all();
            @endphp

            <form action="{{ route('admin.recipes.update', $recipe) }}" method="POST"
                  enctype="multipart/form-data"
                  x-data="recipeForm({ ingredients: {{ json_encode($existingIngredients) }}, steps: {{ json_encode($existingSteps) }} })"
                  class="bg-white p-6 rounded-lg shadow space-y-6">
                @csrf
                @method('PATCH')

                @include('admin.recipes._form', ['recipe' => $recipe])

                <div class="flex justify-end gap-2 pt-4 border-t">
                    <a href="{{ route('admin.recipes.index') }}" class="px-4 py-2 border rounded text-sm">취소</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">저장</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.recipes._script')
</x-app-layout>
