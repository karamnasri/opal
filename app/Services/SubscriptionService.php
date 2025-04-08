<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    public function getPlans()
    {
        return Plan::all();
    }
}
