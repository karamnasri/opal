<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class AllocateMonthlyDesigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'designs:allocate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allocate monthly designs to active subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Subscription::where('stripe_status', 'active')
            ->chunk(200, function ($subscriptions) {
                foreach ($subscriptions as $sub) {
                    // Get the user
                    $user = User::find($sub->user_id);
                    if (!$user) continue;

                    // Get the plan based on the subscription's stripe_price
                    $plan = Plan::where('stripe_price_id', $sub->stripe_price)->first();
                    if (!$plan) continue;

                    // Calculate elapsed months
                    $monthsElapsed = $this->calculateMonthsElapsed($user->subscription_start);

                    // Handle yearly plans
                    if ($plan->is_yearly) {
                        $this->handleYearlyPlan($user, $plan, $monthsElapsed);
                    }
                }
            });
    }

    protected function calculateMonthsElapsed($startDate)
    {
        return now()->diffInMonths($startDate);
    }

    protected function handleYearlyPlan(User $user, Plan $plan, $monthsElapsed)
    {
        $monthlyAllocation = $plan->designs_limit;
        $expectedBank = max(0, ($plan->designs_limit * 11) - ($monthlyAllocation * $monthsElapsed));

        $deductionAmount = $user->design_limit_bank - $expectedBank;

        if ($deductionAmount > 0) {
            $user->design_limit_bank = $expectedBank;
            $user->available_designs = $monthlyAllocation;
            $user->save();
        }
    }
}
