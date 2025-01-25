<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['name' => 'Basic', 'slug' => 'basic-monthly', 'price' => 89.00, 'billing_cycle' => 'monthly', 'designs_limit' => 50],
            ['name' => 'Basic', 'slug' => 'basic-annual', 'price' => 69.00, 'billing_cycle' => 'annual', 'designs_limit' => 50],
            ['name' => 'Standard', 'slug' => 'standard-monthly', 'price' => 119.00, 'billing_cycle' => 'monthly', 'designs_limit' => 350],
            ['name' => 'Standard', 'slug' => 'standard-annual', 'price' => 99.00, 'billing_cycle' => 'annual', 'designs_limit' => 350],
            ['name' => 'Premium', 'slug' => 'premium-monthly', 'price' => 159.00, 'billing_cycle' => 'monthly', 'designs_limit' => 750],
            ['name' => 'Premium', 'slug' => 'premium-annual', 'price' => 84.00, 'billing_cycle' => 'annual', 'designs_limit' => 750],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
