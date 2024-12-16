<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

if (!function_exists('getUserRole')) {
    function getUserRole(): ?Role
    {
        return Role::where('name', 'user')->first();
    }
}

if (!function_exists('getAdminRole')) {
    function getAdminRole(): ?Role
    {
        return Role::where('name', 'admin')->first();
    }
}

if (!function_exists('generateVerificationCode')) {
    function generateVerificationCode(): string
    {
        do {
            $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('verification_code', $verificationCode)->exists());

        return  $verificationCode;
    }
}
