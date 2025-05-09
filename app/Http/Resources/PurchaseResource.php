<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'design' => new PurchaseItemResource($this->whenLoaded('design')),
            'due_at' => $this->created_at->addMonth()->diffForHumans(),
        ];
    }
}
