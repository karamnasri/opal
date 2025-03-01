<?php

namespace App\Listeners;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class HandleStripeWebhook
{
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;
        Log::info("Received Stripe webhook event: {$payload['type']}", [
            'event_id' => $payload['id'] ?? null,
            'event_type' => $payload['type'] ?? null
        ]);

        try {
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

                default:
                    Log::warning("Unhandled Stripe event type", [
                        'event_type' => $payload['type'] ?? 'unknown'
                    ]);
            }
        } catch (\Exception $e) {
            Log::error("Webhook processing failed: " . $e->getMessage(), [
                'event_id' => $payload['id'] ?? null,
                'exception' => $e->getTraceAsString()
            ]);
        }
    }

    protected function handleSubscriptionCreated(array $payload): void
    {
        Log::debug("Processing subscription created event", ['payload' => $payload]);
        $subscription = $payload['data']['object'];
        $priceId = $subscription['items']['data'][0]['price']['id'] ?? null;

        $user = User::where('stripe_id', $subscription['customer'])->first();
        $plan = Plan::where('stripe_price_id', $priceId)->first();

        if (!$user) {
            Log::warning("User not found for subscription creation", [
                'stripe_customer_id' => $subscription['customer'],
                'price_id' => $priceId
            ]);
            return;
        }

        if (!$plan) {
            Log::error("Plan not found for subscription creation", [
                'price_id' => $priceId,
                'user_id' => $user->id
            ]);
            return;
        }

        try {
            if ($plan->is_yearly) {
                Log::info("Handling yearly subscription creation", [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'designs_limit' => $plan->designs_limit
                ]);

                $user->update([
                    'design_limit_bank' => $plan->designs_limit * 11,
                    'available_designs' => $plan->designs_limit,
                    'subscription_start' => now(),
                ]);
            } else {
                Log::info("Handling monthly subscription creation", [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'designs_limit' => $plan->designs_limit
                ]);

                $user->update(['available_designs' => $plan->designs_limit]);
            }

            Log::debug("User updated successfully after subscription creation", [
                'user_id' => $user->id,
                'new_design_limit_bank' => $user->design_limit_bank,
                'new_available_designs' => $user->available_designs
            ]);
        } catch (\Exception $e) {
            Log::error("Subscription creation handling failed", [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function handleInvoicePaymentSucceeded(array $payload): void
    {
        Log::debug("Processing invoice payment succeeded event", ['payload' => $payload]);
        $invoice = $payload['data']['object'];
        $priceId = $invoice['lines']['data'][0]['price']['id'] ?? null;

        $user = User::where('stripe_id', $invoice['customer'])->first();
        $plan = Plan::where('stripe_price_id', $priceId)->first();

        if (!$user) {
            Log::warning("User not found for invoice payment", [
                'stripe_customer_id' => $invoice['customer'],
                'price_id' => $priceId
            ]);
            return;
        }

        if (!$plan) {
            Log::error("Plan not found for invoice payment", [
                'price_id' => $priceId,
                'user_id' => $user->id
            ]);
            return;
        }

        try {
            if ($plan->is_yearly) {
                Log::info("Handling yearly subscription renewal", [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'designs_limit' => $plan->designs_limit
                ]);

                $user->update([
                    'design_limit_bank' => $plan->designs_limit * 11,
                    'available_designs' => $plan->designs_limit,
                    'subscription_start' => now(),
                ]);
            } else {
                Log::info("Handling monthly subscription renewal", [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'designs_limit' => $plan->designs_limit
                ]);

                $user->update(['available_designs' => $plan->designs_limit]);
            }

            Log::debug("User updated successfully after payment", [
                'user_id' => $user->id,
                'new_design_limit_bank' => $user->design_limit_bank,
                'new_available_designs' => $user->available_designs
            ]);
        } catch (\Exception $e) {
            Log::error("Invoice payment handling failed", [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function handleSubscriptionDeleted(array $payload): void
    {
        Log::debug("Processing subscription deleted event", ['payload' => $payload]);
        $subscription = $payload['data']['object'];
        $user = User::where('stripe_id', $subscription['customer'])->first();

        if (!$user) {
            Log::warning("User not found for subscription deletion", [
                'stripe_customer_id' => $subscription['customer']
            ]);
            return;
        }

        try {
            Log::info("Resetting user design limits after subscription cancellation", [
                'user_id' => $user->id,
                'previous_design_limit_bank' => $user->design_limit_bank,
                'previous_available_designs' => $user->available_designs
            ]);

            $user->update([
                'available_designs' => 0,
                'design_limit_bank' => 0
            ]);

            Log::debug("User limits reset successfully", [
                'user_id' => $user->id,
                'new_design_limit_bank' => $user->design_limit_bank,
                'new_available_designs' => $user->available_designs
            ]);
        } catch (\Exception $e) {
            Log::error("Subscription deletion handling failed", [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
