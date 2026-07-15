<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>레시피 목록</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50">
    <div class="max-w-5xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8">레시피</h1>

        @if($recipes->isEmpty())
            <p class="text-gray-500">등록된 레시피가 없습니다.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe) }}"
                       class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                        <img src="{{ $recipe->getFirstMediaUrl('cover') }}"
                             alt="{{ $recipe->title }}"
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="font-semibold text-lg">{{ $recipe->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $recipe->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $recipes->links() }}
            </div>
        @endif
    </div>
</body>
</html>
