<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">새 레시피</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.recipes.store') }}" method="POST"
                  enctype="multipart/form-data"
                  x-data="recipeForm({ ingredients: [], steps: [] })"
                  class="bg-white p-6 rounded-lg shadow space-y-6">
                @csrf

                @include('admin.recipes._form')

                <div class="flex justify-end gap-2 pt-4 border-t">
                    <a href="{{ route('admin.recipes.index') }}" class="px-4 py-2 border rounded text-sm">취소</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">저장</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.recipes._script')
</x-app-layout>
