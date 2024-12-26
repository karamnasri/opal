<?php

namespace App\Services;

use App\DTOs\Design\DesignFilterDTO;
use App\DTOs\Design\LikedDesignDTO;
use App\Models\Design;

class DesignService
{
    public function getAll(DesignFilterDTO $dto)
    {
        $query = Design::query();

        if ($dto->category_id) {
            $query->where('category_id', $dto->category_id);
        }

        if ($dto->print_type) {
            $query->where('print_type', $dto->print_type);
        }

        if (!is_null($dto->is_free)) {
            if ($dto->is_free) {
                $query->whereNull('price');
            } else {
                $query->whereNotNull('price');
            }
        }

        $dto->designs = $query->paginate();
    }

    public function getLiked(LikedDesignDTO $dto)
    {
        $dto->designs = auth()->user()->likedDesigns()->paginate();
    }
}
