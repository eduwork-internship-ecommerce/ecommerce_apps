<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */
    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp-relay.brevo.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)
            ),
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => ['smtp', 'log'],
            'retry_after' => 60,
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-reply@ecommerce_apps.test'),
        'name' => env('MAIL_FROM_NAME', 'Ecommerce Apps'),
    ],

];
