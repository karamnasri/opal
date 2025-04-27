<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        // $this->call(UserSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(DesignSeeder::class);
        // $this->call(DesignUserSeeder::class);
        // $this->call(CategoryDesignSeeder::class);
        // $this->call(BannerSeeder::class);
        $this->call(PlanSeeder::class);
        // $this->call(NotificationsSeeder::class);

        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@opal-dp.com',
        ])->assignRole(getAdminRole());
    }
}
