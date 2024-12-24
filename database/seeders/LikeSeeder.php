<?php

namespace Database\Seeders;

use App\Models\Design;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $designIds = Design::pluck('id')->toArray();

        $numberOfLikes = 100;
        $existingLikes = [];

        $likes = [];
        while (count($likes) < $numberOfLikes) {
            $randomDesignId = $designIds[array_rand($designIds)];
            $randomUserId = $userIds[array_rand($userIds)];
            $key = "{$randomDesignId}-{$randomUserId}";

            if (!isset($existingLikes[$key])) {
                $existingLikes[$key] = true;
                $likes[] = [
                    'design_id' => $randomDesignId,
                    'user_id' => $randomUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('likes')->insert($likes);
    }
}
