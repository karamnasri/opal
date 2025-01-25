<?php

namespace App\Enums;

enum NotificationTitleEnum: string
{
    case Pay = 'pay';
    case Contact = 'contact';

    /**
     * Get all the values of the enum.
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
