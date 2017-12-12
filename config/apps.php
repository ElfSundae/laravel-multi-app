<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | The root URL for each sub application.
    |
    */

    'url' => [
        'web' => env('APP_URL'),
        'admin' => env('APP_URL_ADMIN', env('APP_URL')),
        'api' => env('APP_URL_API', env('APP_URL')),
        'assets' => env('APP_URL_ASSETS', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may override the default configurations for each sub application.
    |
    */

    'config' => [

        'default' => [
            'app.log' => env('APP_LOG', 'daily'),
            'app.log_max_files' => 90,

            'filesystems.disks.public.url' => env('APP_URL_ASSETS', env('APP_URL')).'/storage',
        ],

        'admin' => [
            'session.domain' => env('SESSION_DOMAIN_ADMIN', null),
        ],

    ],

];
