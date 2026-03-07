<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins', // ← CORRECTION: 'users' pour les utilisateurs normaux
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins', // ← Pour les utilisateurs normaux
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Guard pour super_admin
        'super_admin' => [
            'driver' => 'session',
            'provider' => 'super_admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // ← Modèle User pour utilisateurs normaux
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // Provider pour super_admins
        'super_admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SuperAdmin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users', // ← Provider 'users'
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Password reset pour super_admins
        'super_admins' => [
            'provider' => 'super_admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];