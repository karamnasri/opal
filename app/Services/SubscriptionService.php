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

    public function subscribeToPlan($planSlug, $paymentMethod)
    {
        $user = Auth::user();

        $plan = Plan::findOrFail('slug', $planSlug);

        $subscription = $user->newSubscription('default', $plan->slug)->create($paymentMethod);

        return $subscription;
    }
}
