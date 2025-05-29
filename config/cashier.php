<?php

return [
    'key' => env('STRIPE_KEY'),
    'secret' => env('CASHIER_SECRET', env('STRIPE_SECRET')),
];
