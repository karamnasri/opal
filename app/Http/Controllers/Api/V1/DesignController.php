<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Design\DesignFilterDTO;
use App\DTOs\Design\LikedDesignDTO;
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
        $dto = DesignFilterDTO::fromRequest($request);
        $this->designService->getAll($dto);

        return $this->successResponse(new DesignCollection($dto->designs), 'Designs retrieved successfully.');
    }
    public function liked()
    {
        $dto = new LikedDesignDTO();
        $this->designService->getLiked($dto);

        return $this->successResponse(new DesignCollection($dto->designs), 'Designs retrieved successfully.');
    }
}
