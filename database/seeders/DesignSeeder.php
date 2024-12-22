<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designs = [
            [
                'title' => 'Ethnic Pattern 1',
                'description' => 'A traditional ethnic pattern with intricate details.',
                'price' => 50.00,
                'discounted_price' => 40.00,
                'category_id' => 1,
                'color' => json_encode(['#FF5733', '#C70039', '#900C3F']), // Hex color codes
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/ethnic-pattern-1.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/ethnic-pattern-1-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tropical Vibes',
                'description' => 'Bright and vibrant tropical design perfect for summer themes.',
                'price' => 75.00,
                'discounted_price' => 65.00,
                'category_id' => 2,
                'color' => json_encode(['#28A745', '#FFC107', '#DC3545']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/tropical-vibes.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/tropical-vibes-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Minimalist Elegance',
                'description' => 'Clean and simple design for modern aesthetics.',
                'price' => 60.00,
                'discounted_price' => 50.00,
                'category_id' => 3,
                'color' => json_encode(['#FFFFFF', '#000000', '#808080']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/minimalist-elegance.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/minimalist-elegance-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Geometric Magic',
                'description' => 'A design featuring geometric shapes and sharp edges.',
                'price' => 45.00,
                'discounted_price' => 40.00,
                'category_id' => 4,
                'color' => json_encode(['#007BFF', '#17A2B8', '#FFC107']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/geometric-magic.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/geometric-magic-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Abstract Waves',
                'description' => 'A creative and artistic abstract pattern full of vibrant waves.',
                'price' => 80.00,
                'discounted_price' => 70.00,
                'category_id' => 5,
                'color' => json_encode(['#FF5733', '#900C3F', '#DAF7A6']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/abstract-waves.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/abstract-waves-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Floral Garden',
                'description' => 'A floral design inspired by lush gardens.',
                'price' => 65.00,
                'discounted_price' => 55.00,
                'category_id' => 6,
                'color' => json_encode(['#FF1493', '#FFD700', '#228B22']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/floral-garden.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/floral-garden-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bohemian Dreams',
                'description' => 'Free-spirited and eclectic bohemian pattern.',
                'price' => 55.00,
                'discounted_price' => 45.00,
                'category_id' => 7,
                'color' => json_encode(['#C71585', '#8B0000', '#F4A300']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/bohemian-dreams.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/bohemian-dreams-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vintage Charm',
                'description' => 'Designs inspired by retro aesthetics and vintage charm.',
                'price' => 60.00,
                'discounted_price' => 50.00,
                'category_id' => 8,
                'color' => json_encode(['#8B4513', '#D2691E', '#A52A2A']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/vintage-charm.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/vintage-charm-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Industrial Revolution',
                'description' => 'Inspired by industrial designs, strong lines, and raw materials.',
                'price' => 90.00,
                'discounted_price' => 75.00,
                'category_id' => 9,
                'color' => json_encode(['#A9A9A9', '#696969', '#D3D3D3']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/industrial-revolution.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/industrial-revolution-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Art Deco Glam',
                'description' => 'Luxurious patterns and elegant motifs from the 1920s and 1930s.',
                'price' => 100.00,
                'discounted_price' => 85.00,
                'category_id' => 4,
                'color' => json_encode(['#FFD700', '#B8860B', '#C0C0C0']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/art-deco-glam.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/art-deco-glam-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Neon Lights',
                'description' => 'Bright neon colors that stand out in the dark.',
                'price' => 85.00,
                'discounted_price' => 70.00,
                'category_id' => 5,
                'color' => json_encode(['#FF00FF', '#00FFFF', '#FFFF00']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/neon-lights.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/neon-lights-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Woodland Escape',
                'description' => 'Inspired by the serene and earthy tones of a forest.',
                'price' => 70.00,
                'discounted_price' => 60.00,
                'category_id' => 1,
                'color' => json_encode(['#228B22', '#6B8E23', '#8B4513']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/woodland-escape.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/woodland-escape-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pop Art Explosion',
                'description' => 'Bold, comic-inspired designs with bright colors.',
                'price' => 55.00,
                'discounted_price' => 45.00,
                'category_id' => 5,
                'color' => json_encode(['#FF6347', '#FFD700', '#4682B4']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/pop-art-explosion.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/pop-art-explosion-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cosmic Fantasy',
                'description' => 'Space-themed design with deep blue and purple tones.',
                'price' => 95.00,
                'discounted_price' => 85.00,
                'category_id' => 7,
                'color' => json_encode(['#4B0082', '#000080', '#8A2BE2']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/cosmic-fantasy.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/cosmic-fantasy-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Watercolor Bliss',
                'description' => 'Soft, pastel hues blending into a beautiful watercolor design.',
                'price' => 65.00,
                'discounted_price' => 55.00,
                'category_id' => 1,
                'color' => json_encode(['#ADD8E6', '#F0E68C', '#D3D3D3']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/watercolor-bliss.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/watercolor-bliss-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Urban Graffiti',
                'description' => 'Street-inspired graffiti art with bold and rebellious colors.',
                'price' => 80.00,
                'discounted_price' => 70.00,
                'category_id' => 1,
                'color' => json_encode(['#FF0000', '#00FF00', '#0000FF']),
                's3_file_url' => 'https://example-bucket.s3.amazonaws.com/urban-graffiti.psd',
                'preview_image' => 'https://example-bucket.s3.amazonaws.com/urban-graffiti-preview.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('designs')->insert($designs);
    }
}
