<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => new CategoryResource($this->category),
            'price' => $this->price,
            'discounted_percentage' => $this->discount_percentage,
            'colors' => $this->color,
            'preview_image' => $this->preview_image,
            'print_type' => $this->print_type,
            'liked' => $this->isLikedByUser(auth()->id()),
        ];
    }
}
