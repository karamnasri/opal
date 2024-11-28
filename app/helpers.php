<?php

use App\Models\Role;
use App\Models\User;

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

if (!function_exists('checkVerificationRateLimit')) {
    function checkVerificationRateLimit(int $userId, int $maxAttempts = 5): void
    {
        $rateLimitKey = 'verification-code:' . $userId;

        // Check if the user has exceeded the max attempts
        if (Illuminate\Support\Facades\RateLimiter::tooManyAttempts($rateLimitKey, $maxAttempts)) {
            throw new Exception('Too many verification attempts. Please try again later.');
        }

        // Hit the rate limiter to record the attempt
        Illuminate\Support\Facades\RateLimiter::hit($rateLimitKey);
    }
}
