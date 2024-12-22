<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Design\DesignCategoryFilterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesignFilterRequest;
use App\Http\Resources\DesignCollection;
use App\Services\DesignService;
use App\Traits\ApiResponseTrait;

class DesignController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private DesignService $designService) {}
    public function index(DesignFilterRequest $request)
    {
        $dto = DesignCategoryFilterDTO::fromRequest($request);
        $this->designService->getAll($dto);

        return $this->successResponse(new DesignCollection($dto->designs), 'Designs retrieved successfully.');
    }
}
