<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionService
{
    public function getPlans()
    {
        return Plan::all();
    }

    public function subscribeToPlan(Plan $plan)
    {
        $user = Auth::user();

        return $user->newSubscription($plan->stripe_product_id, $plan->stripe_price_id)->checkout([
            'success_url' => route('subscription.success'),
            'cancel_url' => route('subscription.cancel')
        ]);
    }
}
