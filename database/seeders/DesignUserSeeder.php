<?php

namespace Database\Seeders;

use App\Models\Design;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $designIds = Design::pluck('id')->toArray();

        $numberOfRelations = 10;
        $relations = [];

        while (count($relations) < $numberOfRelations) {
            $randomDesignId = $designIds[array_rand($designIds)];
            $randomUserId = $userIds[array_rand($userIds)];
            $key = "{$randomDesignId}-{$randomUserId}";

            if (!isset($existingLikes[$key])) {
                $existingLikes[$key] = true;
                $relations[$key] = [
                    'design_id' => $randomDesignId,
                    'user_id' => $randomUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('design_user')->insert(array_values($relations));
    }
}
