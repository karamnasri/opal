<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
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
    }
}
