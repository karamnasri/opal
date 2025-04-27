<?php

namespace App\Services;

use App\DTOs\Design\DesignFilterDTO;
use App\Models\Design;
use Illuminate\Database\Eloquent\Builder;

class DesignService
{
    public function getAll(DesignFilterDTO $dto)
    {
        $dto->designs = Design::with(['categories', 'likers'])
            ->when($dto->hasCategoryFilter(), fn($q) => $q->whereRelation('categories', 'categories.id', $dto->category_id))
            ->when($dto->hasPrintTypeFilter(), fn(Builder $q) => $q->where('print_type', $dto->print_type))
            ->when($dto->hasSearchFilter(), fn(Builder $q) => $q->where('title', 'LIKE', "%$dto->query%"))
            ->when($dto->hasFreeFilter(), fn(Builder $q) => $q->where('price', 0))
            ->when($dto->hasLikedFilter(), fn(Builder $q) => $q->isLiker(auth()->user()))
            ->paginate();
    }
}
