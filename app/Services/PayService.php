<?php

namespace App\Services;

use App\DTOs\PointsDTO;
use Illuminate\Support\Facades\DB;

class PayService
{
    public function payWithPoints(PointsDTO $dto): void
    {
        try {
            DB::transaction(function () use ($dto) {
                $dto->user->removeDesignPoints($dto->required_points);
                $dto->cart->checkout();
            });
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
