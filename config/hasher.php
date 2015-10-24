<?php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Clients
     | ------------------------------------------------------------------------------------------------
     */
    'client'  => 'hashids',

    'clients' => [
        'hashids'   => \Arcanedev\Hasher\Clients\HashidsClient::class,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Connections
     | ------------------------------------------------------------------------------------------------
     */
    'connection'  => 'main',

    'connections' => [
        'hashids'   => [
            'main'  => [
                'salt'      => '',
                'length'    => 0,
                'alphabet'  => '',
            ],
            'alt'   => [
                'salt'      => '',
                'length'    => 0,
                'alphabet'  => '',
            ],
        ],
    ],
];
