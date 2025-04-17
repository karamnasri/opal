<?php

namespace App\Services;

use App\DTOs\PointsDTO;
use Illuminate\Support\Facades\DB;

class PayService
{
    public function payWithPoints(PointsDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $dto->user->removeDesignPoints($dto->requiredPoints);
            $dto->cart->checkout($dto->unpurchasedItems);
        });
    }
}
