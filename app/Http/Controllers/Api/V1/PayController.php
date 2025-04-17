<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\PointsDTO;
use App\Http\Controllers\Controller;
use App\Services\PayService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PayController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private PayService $payService) {}
    public function points()
    {
        $dto = new PointsDTO();
        $this->payService->payWithPoints($dto);

        return $this->successResponse([], 'Cart purchased successfully using points.');
    }
}
