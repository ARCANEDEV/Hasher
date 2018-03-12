# 4. Usage

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

## Helper

The `hasher()` helper allows you to manage & use your hash drivers. 

The `hasher()` function returns the **instance of the hash manager 'Arcanedev\Hasher\HashManager'**

To get the default hashing driver:

```php
$hasher = hasher()->driver();
```

After getting your hashing driver, you're ready to encoding/decoding your ids:

```php
$hasher = hasher()->driver();
$id     = 1234;

// To encode
$hashedId = $hasher->encode($id);

// ...

// To decode
$id = $hasher->decode($hashedId);
```

You can call the `encode()` & `decode()` directly from the hash manager if you want, it will take the default driver for hashing:

```php
$id = 1234;

// To encode
$hashedId = hasher()->encode($id);

// ...

// To decode
$id = hasher()->decode($hashedId);
```

You can also chain the calls like:

```php
$id = 1234;

// To encode
$hashedId = hasher()->driver()->encode($id);

// ...

// To decode
$id = hasher()->driver()->decode($hashedId);
```

The `driver()` method accepts an argument as the hash driver name. So you can do something like that:
 
```php
$hasher = hasher()->driver('custom-driver');
```

And to get your default driver with different `option`, you can use the `with()` method for that:

```php
$hasher = hasher()->with('alt');
```

You can also use another helper if you don't like calling multiple methods:

```php
$hasher = hash_with('alt');
```
 
Of course, you can specify the `option` and the `driver` at the same time with the same helpers:

```php
$hasher = hasher()->with('alt', 'custom-driver');

// OR

$hasher = hash_with('alt', 'custom-driver');
```

 > Note: if you don't specify the driver name, it will grab the default driver.

Other useful methods:

```php
// To get your default driver name
$driverName = hasher()->getDefaultDriver();

// To get your default option name 
$option = hasher()->getDefaultOption()

// To set the default option name
$manager = hasher()->option('alt');
```

## Facade

 > You start with `Hasher::` Facade and you call the same methods as mentioned above. **(Don't repeat yourself rule).**

## IOC

The Hash Manager is binded to `Arcanedev\Hasher\Contracts\HashManager` Contract, you can get the instance by doing this:

```php
$manager = app(Arcanedev\Hasher\Contracts\HashManager::class);
```

And if you prefer to use dependency injection then you can inject the manager like this:

```php
use Arcanedev\Hasher\Contracts\HashManager;

class Foo
{
    protected $hasher;

    public function __construct(HashManager $hasher)
    {
        $this->hasher = $hasher;
    }

    public function encode($id)
    {
        return $this->hasher->encode($id);
    }
    
    public function decode($hashed)
    {
        return $this->hasher->decode($id);
    }
}
```

## Extending Drivers

You can create your own hashing drivers by implementing this contract `Arcanedev\Hasher\Contracts\HashDriver`:

```php
<?php namespace App\Hashers;

use Arcanedev\Hasher\Contracts\HashDriver;

class CustomDriver implements HashDriver 
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * CustomDriver constructor.
     *
     * @param  array  $options
     */
    public function __construct(array $options)
    {
        //...
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Encode the value.
     *
     * @param  mixed  $value
     *
     * @return string
     */
    public function encode($value)
    {
        // return the encoded value
    }

    /**
     * Decode the hashed value.
     *
     * @param  string  $hashed
     *
     * @return mixed
     */
    public function decode($hashed)
    {
        // return the decoded value
    }
}
```

As you can see, the `__constructor` will receive an array as argument containing the selected `option` settings.

 > Check the [HashidsDriver](https://github.com/ARCANEDEV/Hasher/blob/master/src/Drivers/HashidsDriver.php) class as example.

After that, you need to add your driver to the supported `drivers` in your `config/hasher.php` config file:

```php
<?php

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
        
        'custom'  => [
            'driver' => App\Hashers\CustomDriver::class,
        ]
    ],

    //...
];
```

This is optional but you can specify a `option` settings (or multiple) for your `custom` driver.
