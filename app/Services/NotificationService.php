<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationService
{

    public function getMyNotification()
    {
        return Notification::select(
            'id',
            'title',
            'message',
            'created_at',
            DB::raw("
                CASE
                    WHEN DATE(created_at) = CURDATE() THEN 'today'
                    WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN 'yesterday'
                    WHEN DATE(created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND DATE_SUB(CURDATE(), INTERVAL 2 DAY) THEN 'last_week'
                    WHEN DATE(created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_SUB(CURDATE(), INTERVAL 8 DAY) THEN 'last_30_days'
                    ELSE 'old_notifications'
                END as period
            ")
        )
            ->MyNotification()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('period');
    }
}
