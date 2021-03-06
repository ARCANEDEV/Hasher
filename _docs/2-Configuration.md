# 3. Configuration

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

After you've published the config file `config/hasher.php`, you can customize the settings :

## Defaults

```php
return [
    
    /* -----------------------------------------------------------------
     |  Defaults
     | -----------------------------------------------------------------
     */
         
    'default'     => [
        'driver' => 'hashids',
        'option' => 'main',
    ],
    
    //..
```

You can set your default hashing `driver` and `connection` for your application.

## Drivers

```php
return [
    //...
    
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

    //...
];
```

The `drivers` attribute allows you to specify the supported drivers for your application and you can also create & add your own custom `class` & `options`.  

The `options` attribute are options for your hashing driver, it may vary according to your driver.

You can also specify multiple connections for each driver, like `main` and `alt`, it allows you to hash each entity in your application to different hashing results.
