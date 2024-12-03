<?php

namespace App\Enums;

enum SocialProvidersEnum: string
{
    case Google = 'google';

    /**
     * Get all the values of the enum.
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
