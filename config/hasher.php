<?php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Defaults
     | ------------------------------------------------------------------------------------------------
     */
    'default'     => [
        'driver'     => 'hashids',
        'connection' => 'main',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Drivers
     | ------------------------------------------------------------------------------------------------
     */
    'drivers'     => [
        'hashids' => Arcanedev\Hasher\Drivers\HashidsDriver::class,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Connections
     | ------------------------------------------------------------------------------------------------
     */
    'connections' => [
        'hashids' => [
            'main' => [
                'salt'     => env('HASHIDS_MAIN_SALT', ''),
                'length'   => env('HASHIDS_MAIN_LENGTH', 0),
                'alphabet' => env('HASHIDS_MAIN_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
            ],

            // 'alt' => [
            //     'salt'     => '',
            //     'length'   => 0,
            //     'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
            // ],
        ],
    ],
];
