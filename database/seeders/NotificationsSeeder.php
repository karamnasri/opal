<?php

namespace Database\Seeders;

use App\Enums\NotificationTitleEnum;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $titles = NotificationTitleEnum::getValues();

            // Notifications for today
            Notification::create([
                'user_id' => 1,
                'title' => $titles[array_rand($titles)],
                'message' => 'Notification for today',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Notifications for yesterday
            Notification::create([
                'user_id' => 1,
                'title' => $titles[array_rand($titles)],
                'message' => 'Notification for yesterday',
                'created_at' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday(),
            ]);

            // Notifications for the last week (excluding today and yesterday)
            for ($i = 2; $i <= 7; $i++) {
                Notification::create([
                    'user_id' => 1,
                    'title' => $titles[array_rand($titles)],
                    'message' => 'Notification for last week',
                    'created_at' => Carbon::now()->subDays($i),
                    'updated_at' => Carbon::now()->subDays($i),
                ]);
            }

            // Notifications for the last 30 days (excluding the last week)
            for ($i = 8; $i <= 30; $i++) {
                Notification::create([
                    'user_id' => 1,
                    'title' => $titles[array_rand($titles)],
                    'message' => 'Notification for the last 30 days',
                    'created_at' => Carbon::now()->subDays($i),
                    'updated_at' => Carbon::now()->subDays($i),
                ]);
            }

            // Old notifications
            for ($i = 31; $i <= 60; $i++) {
                Notification::create([
                    'user_id' => 1,
                    'title' => $titles[array_rand($titles)],
                    'message' => 'Old notification',
                    'created_at' => Carbon::now()->subDays($i),
                    'updated_at' => Carbon::now()->subDays($i),
                ]);
            }
        }
    }
}
