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
        $plans = collect([
            ['name' => '50 Points Monthly', 'points' => 50, 'price' => 62.50, 'interval' => 'monthly'],
            ['name' => '50 Points Yearly', 'points' => 50, 'price' => 489.50, 'interval' => 'yearly'],
            ['name' => '350 Points Monthly', 'points' => 350, 'price' => 99.99, 'interval' => 'monthly'],
            ['name' => '350 Points Yearly', 'points' => 350, 'price' => 824.50, 'interval' => 'yearly'],
            ['name' => '750 Points Monthly', 'points' => 750, 'price' => 125.00, 'interval' => 'monthly'],
            ['name' => '750 Points Yearly', 'points' => 750, 'price' => 999.99, 'interval' => 'yearly'],
        ]);

        $plans->map(fn($plan) => Plan::create($plan));
    }
}
