<?php

namespace App\Enums;

enum PrintTypeEnum: string
{
    case Digital = 'digital';
    case DTF = 'dtf';

    /**
     * Get all the values of the enum.
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
