<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => CategoryResource::collection($this->categories),
            'price' => (string) $this->original_price,
            'discounted_percentage' => (string) $this->discount_percentage,
            'discounted_price' => (string) $this->final_price,
            'colors' => $this->color,
            'preview_image' => Storage::disk('public')->path($this->image_path),
            'print_type' => $this->print_type,
            'liked' => $user ? $this->isLikedBy($user) : false,
            'purchased' => $user ? $this->isRecentlyPurchasedBy($user) : false,
        ];
    }
}
