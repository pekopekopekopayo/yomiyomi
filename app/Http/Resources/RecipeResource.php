<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_url' => $this->getFirstMediaUrl('cover') ?: null,
            'author' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
            'ingredients' => $this->whenLoaded('ingredients', fn () =>
                $this->ingredients->map(fn ($i) => [
                    'id' => $i->id,
                    'name' => $i->name,
                    'amount' => $i->pivot->amount,
                    'unit' => $i->pivot->unit,
                ])
            ),
            'steps' => $this->whenLoaded('steps', fn () =>
                $this->steps->map(fn ($s) => [
                    'position' => $s->position,
                    'description' => $s->description,
                ])
            ),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
