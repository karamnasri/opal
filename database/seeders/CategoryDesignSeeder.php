<?php

namespace Database\Seeders;

use App\Models\Design;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        $designIds = Design::pluck('id')->toArray();

        $numberOfRelations = 30;
        $relations = [];

        while (count($relations) < $numberOfRelations) {
            $randomCategoryId = $categoryIds[array_rand($categoryIds)];
            $randomDesignId = $designIds[array_rand($designIds)];
            $key = "{$randomCategoryId}-{$randomDesignId}";

            if (!isset($relations[$key])) {
                $relations[$key] = [
                    'category_id' => $randomCategoryId,
                    'design_id' => $randomDesignId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('category_design')->insert(array_values($relations));
    }
}
