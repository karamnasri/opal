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
            ['name' => 'Basic', 'slug' => 'basic-monthly', 'price' => 62.50, 'stripe_product_id' => 'prod_RjfyRUzuyvdl0i', 'stripe_price_id' => 'price_1QqCchQTvvdeRGUF44MmMckl', 'designs_limit' => 50, 'is_yearly' => false],
            ['name' => 'Basic', 'slug' => 'basic-yearly', 'price' => 489.50, 'stripe_product_id' => 'prod_RjfyRUzuyvdl0i', 'stripe_price_id' => 'price_1QqCdgQTvvdeRGUFIDgn9Sm4', 'designs_limit' => 50, 'is_yearly' => true],

            ['name' => 'Standard', 'slug' => 'standard-monthly', 'price' => 99.99, 'stripe_product_id' => 'prod_Rjg1Cp2HBAvep5', 'stripe_price_id' => 'price_1QqCfFQTvvdeRGUFn6fkkBFG', 'designs_limit' => 350, 'is_yearly' => false],
            ['name' => 'Standard', 'slug' => 'standard-yearly', 'price' => 824.50, 'stripe_product_id' => 'prod_Rjg1Cp2HBAvep5', 'stripe_price_id' => 'price_1QqCfiQTvvdeRGUFD6VZLPWt', 'designs_limit' => 350, 'is_yearly' => true],

            ['name' => 'Premium', 'slug' => 'premium-monthly', 'price' => 125.00, 'stripe_product_id' => 'prod_Rjg3MlsfHip5Q0', 'stripe_price_id' => 'price_1QqCheQTvvdeRGUF6f8zX7PU', 'designs_limit' => 750, 'is_yearly' => false],
            ['name' => 'Premium', 'slug' => 'premium-yearly', 'price' => 999.99, 'stripe_product_id' => 'prod_Rjg3MlsfHip5Q0', 'stripe_price_id' => 'price_1QqCi3QTvvdeRGUFsaTgCaUg', 'designs_limit' => 750, 'is_yearly' => true],

        ]);

        $plans->map(fn($plan) => Plan::create($plan));
    }
}
