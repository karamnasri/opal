<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = collect([
            [
                'image_url' => 'https://picsum.photos/800/600',
                'title' => 'Last Printing 1',
                'description' => 'Discount 50%',
                'action' => route('designs.index'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_url' => 'https://picsum.photos/800/600',
                'title' => 'Last Printing 2',
                'description' => 'Discount 10%',
                'action' => route('designs.index'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_url' => 'https://picsum.photos/800/600',
                'title' => 'Last Printing 3',
                'description' => 'Discount 70%',
                'action' => route('designs.index'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_url' => 'https://picsum.photos/800/600',
                'title' => 'Last Printing 4',
                'description' => 'Discount 40%',
                'action' => route('designs.index'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_url' => 'https://picsum.photos/800/600',
                'title' => 'Last Printing 5',
                'description' => 'Discount 20%',
                'action' => route('designs.index'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $banners->map(fn($banner) => Banner::create($banner));
    }
}
