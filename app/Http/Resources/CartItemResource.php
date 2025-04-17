<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->design->id,
            'title' => $this->design->title,
            'image' => $this->design->image_path,
            'price' => $this->design->original_price->inDollars(),
        ];
    }
}
