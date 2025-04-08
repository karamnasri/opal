<?php

namespace App\Enums;

enum TokenAbilityEnum: string
{
    case REFRESH_TOKEN = 'refresh-token';
    case ACCESS_TOKEN = 'access-token';

    /**
     * Get all the values of the enum.
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
