<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $recipe->title }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.recipes.edit', $recipe) }}"
                   class="px-3 py-1 border rounded text-sm">수정</a>
                <a href="{{ route('recipes.show', $recipe) }}"
                   class="px-3 py-1 border rounded text-sm">공개 페이지 보기</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <img src="{{ $recipe->getFirstMediaUrl('cover') }}"
                     alt="{{ $recipe->title }}"
                     class="w-full max-h-96 object-cover rounded mb-4">
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">ID</dt><dd>{{ $recipe->id }}</dd></div>
                    <div><dt class="text-gray-500">작성자</dt><dd>{{ $recipe->user->name ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">생성</dt><dd>{{ $recipe->created_at }}</dd></div>
                    <div><dt class="text-gray-500">수정</dt><dd>{{ $recipe->updated_at }}</dd></div>
                </dl>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-2">재료 ({{ $recipe->ingredients->count() }})</h3>
                @if($recipe->ingredients->isEmpty())
                    <p class="text-gray-500 text-sm">없음</p>
                @else
                    <ul class="text-sm space-y-1">
                        @foreach($recipe->ingredients as $ing)
                            <li>{{ $ing->name }} — {{ $ing->pivot->amount }}{{ $ing->pivot->unit }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-2">조리 순서 ({{ $recipe->steps->count() }})</h3>
                @if($recipe->steps->isEmpty())
                    <p class="text-gray-500 text-sm">없음</p>
                @else
                    <ol class="text-sm space-y-1">
                        @foreach($recipe->steps as $step)
                            <li>{{ $step->position }}. {{ $step->description }}</li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
