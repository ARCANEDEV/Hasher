# 3. Configuration

## Table of contents

0. [Home](0-Home.md)
1. [Requirements](1-Requirements.md)
2. [Installation and Setup](2-Installation-and-Setup.md)
3. [Configuration](3-Configuration.md)
4. [Usage](4-Usage.md)

After you've published the config file `config/hasher.php`, you can customize the settings :

## Clients

```php
return [
    /* ------------------------------------------------------------------------------------------------
     |  Clients
     | ------------------------------------------------------------------------------------------------
     */
    'client'  => 'hashids',

    'clients' => [
        'hashids'   => Arcanedev\Hasher\Clients\HashidsClient::class,
    ],

    //...
];
```

You can specify the default `client` to use for hashing and also the list of `clients` that are supported with the class associated with.

You can also override the hasher class by replacing the *client value*.

## Connections

```php
return [
    // ...
    
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
```

The `connection` is the options for the hasher client to use for hashing.

You can specify multiple connections for each client, like `main` and `alt`, it allows you to hash multiple entities in your app with different hashing results.

