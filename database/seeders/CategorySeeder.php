<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Ethnic', 'description' => 'Traditional and cultural design patterns.'],
            ['name' => 'Tropical', 'description' => 'Bright, vibrant designs inspired by tropical themes.'],
            ['name' => 'Minimalist', 'description' => 'Clean, simple, and modern designs.'],
            ['name' => 'Geometric', 'description' => 'Designs featuring geometric shapes and patterns.'],
            ['name' => 'Abstract', 'description' => 'Creative and artistic abstract patterns.'],
            ['name' => 'Floral', 'description' => 'Designs inspired by flowers and natural elements.'],
            ['name' => 'Bohemian', 'description' => 'Free-spirited and eclectic patterns.'],
            ['name' => 'Vintage', 'description' => 'Retro and old-fashioned designs.'],
            ['name' => 'Industrial', 'description' => 'Designs inspired by industrial materials and settings.'],
            ['name' => 'Art Deco', 'description' => 'Luxurious and elegant patterns from the 1920s and 1930s.'],
        ]);

        $categories->map(fn($category) => Category::create($category));
    }
}
