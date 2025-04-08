<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Services\SubscriptionService;
use App\Traits\ApiResponseTrait;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private SubscriptionService $subscriptionService) {}
    public function index()
    {
        $plans = $this->subscriptionService->getPlans();

        return $this->successResponse(PlanResource::collection($plans), 'Plans retrieved successfully.');
    }
}
