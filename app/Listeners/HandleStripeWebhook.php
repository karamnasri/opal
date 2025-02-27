<?php

namespace App\Listeners;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Events\WebhookReceived;

class HandleStripeWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        switch ($payload['type']) {
            case 'customer.subscription.created':
                $this->handleSubscriptionCreated($payload);
                break;

            case 'invoice.payment_succeeded':
                $this->handleInvoicePaymentSucceeded($payload);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($payload);
                break;
        }
    }

    protected function handleSubscriptionCreated(array $payload): void
    {
        $subscription = $payload['data']['object'];
        $priceId = $subscription['items']['data'][0]['price']['id'];
        $user = User::where('stripe_id', $subscription['customer'])->first();
        $plan = Plan::where('stripe_price_id', $priceId)->first();

        if ($user && $plan) {
            if ($plan->is_yearly) {
                $user->update([
                    'design_limit_bank' => $plan->designs_limit * 11,
                    'available_designs' => $plan->designs_limit,
                    'subscription_start' => now(),
                ]);
            } else {
                $user->update(['available_designs' => $plan->designs_limit]);
            }
        }
    }

    protected function handleInvoicePaymentSucceeded(array $payload): void
    {
        $invoice = $payload['data']['object'];
        $priceId = $invoice['lines']['data'][0]['price']['id'];
        $plan = Plan::where('stripe_price_id', $priceId)->first();
        $user = User::where('stripe_id', $invoice['customer'])->first();

        if ($user && $plan) {
            if ($plan->is_yearly) {
                $user->update([
                    'design_limit_bank' => $plan->designs_limit * 11,
                    'available_designs' => $plan->designs_limit,
                    'subscription_start' => now(),
                ]);
            } else {
                $user->update(['available_designs' => $plan->designs_limit]);
            }
        }
    }

    protected function handleSubscriptionDeleted(array $payload): void
    {
        $subscription = $payload['data']['object'];
        $user = User::where('stripe_id', $subscription['customer'])->first();

        if ($user) {
            $user->update([
                'available_designs' => 0,
                'design_limit_bank' => 0
            ]);
        }
    }
}
