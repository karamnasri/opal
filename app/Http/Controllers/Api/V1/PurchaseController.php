<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\PurchaseDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseResource;
use App\Services\PurchaseService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private PurchaseService $purchaseService) {}
    public function index()
    {
        $dto = new PurchaseDTO();
        $this->purchaseService->getUserPurchases($dto);

        return $this->successResponse(PurchaseResource::collection($dto->purchases), 'Purchases retrieved successfully.');
    }
}
