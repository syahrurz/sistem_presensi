<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web', // Guard default menggunakan 'web' untuk semua login
        'passwords' => 'users',  // Password reset mengarah ke 'users'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Here you may define every authentication guard for your application.
    | The default guard is "web", which uses session storage and the Eloquent user provider.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | The "users" provider defines how users are retrieved from your database
    | or other storage mechanisms used by your application. You may configure
    | multiple providers if you need different ways of retrieving users.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Passwords
    |--------------------------------------------------------------------------
    |
    | Here you may specify password reset settings for users.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',  // Menggunakan provider 'users' untuk password reset
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | The number of seconds before the password confirmation window expires.
    |
    */

    'password_timeout' => 10800, // 3 jam
];
