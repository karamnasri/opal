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
        $user = auth()->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => CategoryResource::collection($this->categories),
            'price' => $this->original_price->inDollars(),
            'discounted_percentage' => $this->discount_percentage,
            'discounted_price' => $this->final_price->inDollars(),
            'colors' => $this->color,
            'preview_image' => $this->image_path,
            'print_type' => $this->print_type,
            'liked' => $user ? $this->isLikedBy($user) : false,
            'purchased' => $user ? $this->isRecentlyPurchasedBy($user) : false,
        ];
    }
}
