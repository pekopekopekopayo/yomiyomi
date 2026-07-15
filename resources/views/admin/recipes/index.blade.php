<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">레시피 관리</h2>
            <a href="{{ route('admin.recipes.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                + 새 레시피
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($recipes->isEmpty())
                    <p class="p-6 text-gray-500">등록된 레시피가 없습니다.</p>
                @else
                    <table class="w-full">
                        <thead class="bg-gray-50 text-left text-sm">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">제목</th>
                                <th class="px-4 py-3">작성자</th>
                                <th class="px-4 py-3">생성일</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($recipes as $recipe)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $recipe->id }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.recipes.show', $recipe) }}"
                                           class="text-blue-600 hover:underline">{{ $recipe->title }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $recipe->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $recipe->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-sm text-right space-x-2">
                                        <a href="{{ route('admin.recipes.edit', $recipe) }}"
                                           class="text-gray-600 hover:text-gray-800">수정</a>
                                        <form action="{{ route('admin.recipes.destroy', $recipe) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('삭제하시겠습니까?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">삭제</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-4">{{ $recipes->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
