# 3. Configuration

## Table of contents

0. [Home](0-Home.md)
1. [Requirements](1-Requirements.md)
2. [Installation and Setup](2-Installation-and-Setup.md)
3. [Configuration](3-Configuration.md)
4. [Usage](4-Usage.md)

After you've published the config file `config/hasher.php`, you can customize the settings :

## Defaults

```php
return [
    /* ------------------------------------------------------------------------------------------------
     |  Defaults
     | ------------------------------------------------------------------------------------------------
     */
    'default'     => [
        'driver'     => 'hashids',
        'connection' => 'main',
    ],
    
    //..
```

You can set your default hashing `driver` and `connection` for your application.

## Clients

```php
return [
    //...
    
    /* ------------------------------------------------------------------------------------------------
     |  Drivers
     | ------------------------------------------------------------------------------------------------
     */
    'drivers'     => [
        'hashids' => Arcanedev\Hasher\Drivers\HashidsDriver::class,
    ],

    //...
];
```

The `drivers` attribute allows you to specify the supported drivers for your application and you can also create & add your own custom driver.  

## Connections

```php
return [
    // ...
    
    /* ------------------------------------------------------------------------------------------------
     |  Connections
     | ------------------------------------------------------------------------------------------------
     */
    'connections' => [
        'hashids' => [
            'main' => [
                'salt'      => env('HASHIDS_MAIN_SALT', ''),
                'length'    => env('HASHIDS_MAIN_LENGTH', 0),
                'alphabet'  => env('HASHIDS_MAIN_ALPHABET', ''),
            ],
            // 'alt' => [
            //     'salt'      => '',
            //     'length'    => 0,
            //     'alphabet'  => '',
            // ],
        ],
    ],
];
```

The `connections` attribute are options for your hashing driver, it may vary according to your driver.

You can also specify multiple connections for each driver, like `main` and `alt`, it allows you to hash each entity in your application to different hashing results.
