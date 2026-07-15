{{-- 제목 --}}
<div>
    <label class="block text-sm font-medium mb-1">제목</label>
    <input type="text" name="title" value="{{ old('title', $recipe->title ?? '') }}" required
           class="w-full border-gray-300 rounded shadow-sm">
    @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

{{-- 이미지 --}}
<div>
    @isset($recipe)
        <label class="block text-sm font-medium mb-1">현재 이미지</label>
        <img src="{{ $recipe->getFirstMediaUrl('cover') }}" class="w-48 rounded mb-2">
        <label class="block text-sm font-medium mb-1">새 이미지 (선택)</label>
        <input type="file" name="image" accept="image/*" class="w-full">
    @else
        <label class="block text-sm font-medium mb-1">대표 이미지</label>
        <input type="file" name="image" accept="image/*" required class="w-full">
    @endisset
    @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

{{-- 재료 --}}
<div>
    <div class="flex justify-between items-center mb-2">
        <label class="block text-sm font-medium">재료</label>
        <button type="button" @click="addIngredient()"
                class="text-sm text-blue-600 hover:text-blue-800">+ 재료 추가</button>
    </div>

    <div class="space-y-2">
        <template x-for="(ing, idx) in ingredients" :key="idx">
            <div class="flex gap-2 items-start">
                <input type="text" :name="`ingredients[${idx}][name]`" x-model="ing.name"
                       placeholder="재료명 (예: 양파)"
                       class="flex-1 border-gray-300 rounded shadow-sm text-sm">
                <input type="number" step="0.1" min="0" :name="`ingredients[${idx}][amount]`" x-model="ing.amount"
                       placeholder="수량"
                       class="w-24 border-gray-300 rounded shadow-sm text-sm">
                <input type="text" :name="`ingredients[${idx}][unit]`" x-model="ing.unit"
                       placeholder="단위"
                       class="w-24 border-gray-300 rounded shadow-sm text-sm">
                <button type="button" @click="ingredients.splice(idx, 1)"
                        class="text-red-600 hover:text-red-800 text-sm px-2 py-1">×</button>
            </div>
        </template>
        <p x-show="ingredients.length === 0" class="text-sm text-gray-400">재료를 추가하세요</p>
    </div>
    @error('ingredients') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    @error('ingredients.*.name') <p class="text-red-600 text-sm mt-1">재료명은 필수입니다.</p> @enderror
    @error('ingredients.*.amount') <p class="text-red-600 text-sm mt-1">수량은 필수입니다.</p> @enderror
    @error('ingredients.*.unit') <p class="text-red-600 text-sm mt-1">단위는 필수입니다.</p> @enderror
</div>

{{-- 조리 순서 --}}
<div>
    <div class="flex justify-between items-center mb-2">
        <label class="block text-sm font-medium">조리 순서</label>
        <button type="button" @click="addStep()"
                class="text-sm text-blue-600 hover:text-blue-800">+ 단계 추가</button>
    </div>

    <div class="space-y-2">
        <template x-for="(step, idx) in steps" :key="idx">
            <div class="flex gap-2 items-start">
                <div class="flex flex-col">
                    <button type="button" @click="moveStep(idx, -1)" :disabled="idx === 0"
                            class="text-gray-600 hover:text-gray-800 text-xs disabled:opacity-30">▲</button>
                    <button type="button" @click="moveStep(idx, 1)" :disabled="idx === steps.length - 1"
                            class="text-gray-600 hover:text-gray-800 text-xs disabled:opacity-30">▼</button>
                </div>
                <input type="hidden" :name="`steps[${idx}][position]`" :value="idx + 1">
                <span class="font-bold text-blue-600 pt-2 w-6" x-text="idx + 1 + '.'"></span>
                <textarea :name="`steps[${idx}][description]`" x-model="step.description"
                          placeholder="조리 단계 설명"
                          rows="2"
                          class="flex-1 border-gray-300 rounded shadow-sm text-sm"></textarea>
                <button type="button" @click="steps.splice(idx, 1)"
                        class="text-red-600 hover:text-red-800 text-sm px-2 py-1">×</button>
            </div>
        </template>
        <p x-show="steps.length === 0" class="text-sm text-gray-400">단계를 추가하세요</p>
    </div>
    @error('steps') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    @error('steps.*.description') <p class="text-red-600 text-sm mt-1">설명은 필수입니다.</p> @enderror
</div>
