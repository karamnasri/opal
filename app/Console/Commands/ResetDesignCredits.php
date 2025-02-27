<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;

class ResetDesignCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset monthly design credits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereHas('subscriptions', function ($query) {
            $query->where('stripe_status', 'active');
        })
            ->where('next_reset_date', '<=', now())
            ->each(function ($user) {
                $subscription = $user->subscriptions()->active()->first();
                $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();

                $user->update([
                    'available_designs' => $plan->designs_limit,
                    'next_reset_date' => now()->addMonth()
                ]);
            });

        $this->info('Design credits reset successfully');
    }
}
