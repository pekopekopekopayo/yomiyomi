<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $recipe->title }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto py-12 px-4">
        <a href="{{ route('recipes.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← 목록으로</a>

        <h1 class="text-3xl font-bold mt-4 mb-2">{{ $recipe->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">
            by {{ $recipe->user->name ?? '알 수 없음' }} · {{ $recipe->created_at->format('Y-m-d') }}
        </p>

        <img src="{{ $recipe->getFirstMediaUrl('cover') }}"
             alt="{{ $recipe->title }}"
             class="w-full rounded-lg shadow mb-8">

        <section class="mb-8">
            <h2 class="text-xl font-semibold mb-3">재료</h2>
            @if($recipe->ingredients->isEmpty())
                <p class="text-gray-500">등록된 재료가 없습니다.</p>
            @else
                <ul class="bg-white rounded-lg divide-y">
                    @foreach($recipe->ingredients as $ing)
                        <li class="flex justify-between px-4 py-2">
                            <span>{{ $ing->name }}</span>
                            <span class="text-gray-600">{{ $ing->pivot->amount }}{{ $ing->pivot->unit }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section>
            <h2 class="text-xl font-semibold mb-3">조리 순서</h2>
            @if($recipe->steps->isEmpty())
                <p class="text-gray-500">등록된 조리 순서가 없습니다.</p>
            @else
                <ol class="space-y-3">
                    @foreach($recipe->steps as $step)
                        <li class="bg-white rounded-lg p-4 flex gap-4">
                            <span class="font-bold text-blue-600">{{ $step->position }}.</span>
                            <p>{{ $step->description }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    </div>
</body>
</html>
