<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => Str::slug($this->faker->unique()->word()),
            'stripe_product_id' => 'prod_' . Str::random(10),
            'stripe_price_id' => 'price_' . Str::random(10),
            'price' => $this->faker->randomElement([1000, 2000, 5000]), // Example prices
            'designs_limit' => $this->faker->randomElement([5, 10, 20]), // Example limits
            'is_yearly' => $this->faker->boolean(),
        ];
    }
}
