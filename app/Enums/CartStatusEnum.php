<?php

namespace App\Enums;

enum CartStatusEnum: string
{
    case Active = 'active';
    case Waiting = 'waiting';

    /**
     * Get all the values of the enum.
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
