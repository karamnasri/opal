<?php

namespace Database\Seeders;

use App\Enums\PrintTypeEnum;
use App\Models\Design;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designs = collect([
            [
                'title' => 'Ethnic Pattern 1',
                'description' => 'A traditional ethnic pattern with intricate details.',
                'price' => 50.25,
                'discount_percentage' => 40,
                'color' => ['#FF5733', '#C70039', '#900C3F'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/ethnic-pattern-1.psd',
                'image_path' => 'https://images.unsplash.com/photo-1534639077088-d702bcf685e7?q=80&w=1',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tropical Vibes',
                'description' => 'Bright and vibrant tropical design perfect for summer themes.',
                'price' => 75.50,
                'discount_percentage' => 65,
                'color' => ['#28A745', '#FFC107', '#DC3545'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/tropical-vibes.psd',
                'image_path' => 'https://images.unsplash.com/photo-1534639077088-d702bcf685e7?q=80&w=1',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Minimalist Elegance',
                'description' => 'Clean and simple design for modern aesthetics.',
                'price' => 60.99,
                'discount_percentage' => 50,
                'color' => ['#FFFFFF', '#000000', '#808080'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/minimalist-elegance.psd',
                'image_path' => 'https://images.unsplash.com/photo-1534639077088-d702bcf685e7?q=80&w=1',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Geometric Magic',
                'description' => 'A design featuring geometric shapes and sharp edges.',
                'price' => 45.99,
                'discount_percentage' => 40,
                'color' => ['#007BFF', '#17A2B8', '#FFC107'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/geometric-magic.psd',
                'image_path' => 'https://images.unsplash.com/photo-1534639077088-d702bcf685e7?q=80&w=1',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Abstract Waves',
                'description' => 'A creative and artistic abstract pattern full of vibrant waves.',
                'price' => 80.00,
                'discount_percentage' => 70,
                'color' => ['#FF5733', '#900C3F', '#DAF7A6'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/abstract-waves.psd',
                'image_path' => 'https://images.unsplash.com/photo-1527167598984-8802d8028eea?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Floral Garden',
                'description' => 'A floral design inspired by lush gardens.',
                'price' => 65.75,
                'discount_percentage' => 55,
                'color' => ['#FF1493', '#FFD700', '#228B22'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/floral-garden.psd',
                'image_path' => 'https://images.unsplash.com/photo-1527167598984-8802d8028eea?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bohemian Dreams',
                'description' => 'Free-spirited and eclectic bohemian pattern.',
                'price' => 55.00,
                'discount_percentage' => 45,
                'color' => ['#C71585', '#8B0000', '#F4A300'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/bohemian-dreams.psd',
                'image_path' => 'https://images.unsplash.com/photo-1527167598984-8802d8028eea?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vintage Charm',
                'description' => 'Designs inspired by retro aesthetics and vintage charm.',
                'price' => 60.00,
                'discount_percentage' => 50,
                'color' => ['#8B4513', '#D2691E', '#A52A2A'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/vintage-charm.psd',
                'image_path' => 'https://images.unsplash.com/photo-1527167598984-8802d8028eea?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::Digital->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Industrial Revolution',
                'description' => 'Inspired by industrial designs, strong lines, and raw materials.',
                'price' => 0,
                'discount_percentage' => 0,
                'color' => ['#A9A9A9', '#696969', '#D3D3D3'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/industrial-revolution.psd',
                'image_path' => 'https://images.unsplash.com/photo-1519405474421-f6a5fae2db20?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Art Deco Glam',
                'description' => 'Luxurious patterns and elegant motifs from the 1920s and 1930s.',
                'price' => 100.00,
                'discount_percentage' => 85,
                'color' => ['#FFD700', '#B8860B', '#C0C0C0'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/art-deco-glam.psd',
                'image_path' => 'https://images.unsplash.com/photo-1519405474421-f6a5fae2db20?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Neon Lights',
                'description' => 'Bright neon colors that stand out in the dark.',
                'price' => 85.00,
                'discount_percentage' => 70,
                'color' => ['#FF00FF', '#00FFFF', '#FFFF00'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/neon-lights.psd',
                'image_path' => 'https://images.unsplash.com/photo-1519405474421-f6a5fae2db20?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Woodland Escape',
                'description' => 'Inspired by the serene and earthy tones of a forest.',
                'price' => 0,
                'discount_percentage' => 0,
                'color' => ['#228B22', '#6B8E23', '#8B4513'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/woodland-escape.psd',
                'image_path' => 'https://images.unsplash.com/photo-1519405474421-f6a5fae2db20?q=80&w=3870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pop Art Explosion',
                'description' => 'Bold, comic-inspired designs with bright colors.',
                'price' => 55.00,
                'discount_percentage' => 45,
                'color' => ['#FF6347', '#FFD700', '#4682B4'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/pop-art-explosion.psd',
                'image_path' => 'https://images.unsplash.com/photo-1610973310510-82f514ea1986?q=80&w=3774&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cosmic Fantasy',
                'description' => 'Space-themed design with deep blue and purple tones.',
                'price' => 95.00,
                'discount_percentage' => 85,
                'color' => ['#4B0082', '#000080', '#8A2BE2'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/cosmic-fantasy.psd',
                'image_path' => 'https://images.unsplash.com/photo-1610973310510-82f514ea1986?q=80&w=3774&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Watercolor Bliss',
                'description' => 'Soft, pastel hues blending into a beautiful watercolor design.',
                'price' => 0,
                'discount_percentage' => 0,
                'color' => ['#ADD8E6', '#F0E68C', '#D3D3D3'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/watercolor-bliss.psd',
                'image_path' => 'https://images.unsplash.com/photo-1610973310510-82f514ea1986?q=80&w=3774&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Urban Graffiti',
                'description' => 'Street-inspired graffiti art with bold and rebellious colors.',
                'price' => 80.00,
                'discount_percentage' => 70,
                'color' => ['#FF0000', '#00FF00', '#0000FF'],
                'file_path' => 'https://example-bucket.s3.amazonaws.com/urban-graffiti.psd',
                'image_path' => 'https://images.unsplash.com/photo-1610973310510-82f514ea1986?q=80&w=3774&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'print_type' => PrintTypeEnum::DTF->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $designs->map(fn($design) => Design::create($design));
    }
}
