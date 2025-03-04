<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\SubscriptionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $plans = $this->subscriptionService->getPlans();

        // Return response with a resource
        return $this->successResponse(PlanResource::collection($plans), 'Plans retrieved successfully.');
    }

    public function subscribe(Plan $plan)
    {
        $result = $this->subscriptionService->subscribeToPlan($plan);

        return $this->successResponse($result, 'Subscription created successfully.');
    }
}
