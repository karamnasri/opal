<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfUsers = 5;

        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $data = [
                'name' => "User $i",
                'email' => "user$i@opal.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ];

            User::createUser($data);
        }
    }
}
