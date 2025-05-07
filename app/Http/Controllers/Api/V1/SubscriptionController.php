<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\SubscriptionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private SubscriptionService $subscriptionService) {}
    public function plans()
    {
        $plans = $this->subscriptionService->getPlans();

        return $this->successResponse(PlanResource::collection($plans), 'Plans retrieved successfully.');
    }

    public function createPaymentIntent(Plan $plan)
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();

        $user->createSetupIntent();

        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $plan->price->raw(),
            'currency' => 'usd',
            'customer' => $user->stripe_id,
            'automatic_payment_methods' => ['enabled' => false],
            'metadata' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ]
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret
        ]);
    }

    public function confirmSubscription(Request $request)
    {
        $request->validate(['payment_intent_id' => 'required|string']);

        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

        if ($intent->status !== 'succeeded') {
            return response()->json(['error' => 'Payment not successful'], 400);
        }

        $user = $request->user();
        $planId = $intent->metadata['plan_id'];
        $plan = Plan::findOrFail($planId);

        // Add points
        $user->points += $plan->points;
        $user->save();

        // Create subscription
        $startsAt = now();
        $endsAt = $plan->interval === 'monthly' ? $startsAt->copy()->addMonth() : $startsAt->copy()->addYear();

        $user->subscriptions()->create([
            'plan_id' => $plan->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);

        return response()->json(['message' => 'Subscription activated.']);
    }
}
