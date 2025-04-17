<?php

namespace App\Services;

use App\DTOs\PurchaseDTO;

class PurchaseService
{
    public function getUserPurchases(PurchaseDTO $dto)
    {

        $dto->purchases = $dto->user
            ->purchases()
            ->where('created_at', '>=', now()->subMonth())
            ->with('design')
            ->latest()
            ->get();
    }
}
