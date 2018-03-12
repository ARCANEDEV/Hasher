<?php

return [

    /* -----------------------------------------------------------------
     |  Defaults
     | -----------------------------------------------------------------
     */

    'default'     => [
        'driver' => 'hashids',
        'option' => 'main',
    ],

    /* -----------------------------------------------------------------
     |  Drivers
     | -----------------------------------------------------------------
     */

    'drivers'     => [

        'hashids' => [
            'driver'  => Arcanedev\Hasher\Drivers\HashidsDriver::class,

            'options' => [
                'main' => [
                    'salt'     => env('HASHIDS_MAIN_SALT', ''),
                    'length'   => env('HASHIDS_MAIN_LENGTH', 0),
                    'alphabet' => env('HASHIDS_MAIN_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
                ],

                //
            ],
        ],

    ],

];
