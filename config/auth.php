<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'students',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'students', // Fixed typo here (was 'proavider')
        ],
        'president' => [
            'driver' => 'session',
            'provider' => 'clubs',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'clubs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Club::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'students' => [
            'provider' => 'students',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'presidents' => [
            'provider' => 'clubs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        // Add this for admin password reset
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
