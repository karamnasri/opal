<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RewardMonthlySubscriptionPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:reward-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reward monthly points to users with yearly subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $subscriptions = Subscription::where('status', 'active')
            ->whereHas('plan', function ($query) {
                $query->where('interval', 'yearly');
            })
            ->whereDate('starts_at', '<=', $now)
            ->whereDate('ends_at', '>=', $now)
            ->get();

        foreach ($subscriptions as $subscription) {
            $last = $subscription->last_rewarded_at ?? $subscription->starts_at;
            if ($last->diffInMonths($now) >= 1) {
                $user = $subscription->user;
                $points = $subscription->plan->points;

                $user->increment('points', $points);
                $subscription->update(['last_rewarded_at' => $now]);

                $this->info("Added {$points} points to user {$user->id}");
            }
        }

        return 0;
    }
}
