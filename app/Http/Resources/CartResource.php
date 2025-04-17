<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'total_price_before' => (string)  $this->total_price_before,
            'total_price_after' => (string) $this->total_price_after,
            'items' => CartItemResource::collection($this->items),
        ];
    }
}
