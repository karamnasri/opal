<?php

return [
    'auth' => env('AUTH_BASE_PATH', 'v1/auth'),

    'app' => env('APP_BASE_PATH', 'v1/api'),

    'frontend' => [
        'base' => env('FRONTEND_URL', 'http://localhost:3000'),
        'auth' => [
            'google' => '/auth/google',
        ],
    ]

];
