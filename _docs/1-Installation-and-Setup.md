# 2. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

## Version Compatibility

| Hasher                         | Laravel                                                                                                             |
|:-------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| ![Hasher v2.0.x][hasher_2_0_x] | ![Laravel v5.0][laravel_5_0] ![Laravel v5.1][laravel_5_1] ![Laravel v5.2][laravel_5_2] ![Laravel v5.3][laravel_5_3] |
| ![Hasher v2.1.x][hasher_2_1_x] | ![Laravel v5.4][laravel_5_4]                                                                                        |
| ![Hasher v2.2.x][hasher_2_2_x] | ![Laravel v5.5][laravel_5_5]                                                                                        |
| ![Hasher v2.3.x][hasher_2_3_x] | ![Laravel v5.6][laravel_5_6]                                                                                        |
| ![Hasher v2.4.x][hasher_2_4_x] | ![Laravel v5.7][laravel_5_7]                                                                                        |
| ![Hasher v2.5.x][hasher_2_5_x] | ![Laravel v5.8][laravel_5_8]                                                                                        |

[laravel_5_0]:  https://img.shields.io/badge/v5.0-supported-brightgreen.svg?style=flat-square "Laravel v5.0"
[laravel_5_1]:  https://img.shields.io/badge/v5.1-supported-brightgreen.svg?style=flat-square "Laravel v5.1"
[laravel_5_2]:  https://img.shields.io/badge/v5.2-supported-brightgreen.svg?style=flat-square "Laravel v5.2"
[laravel_5_3]:  https://img.shields.io/badge/v5.3-supported-brightgreen.svg?style=flat-square "Laravel v5.3"
[laravel_5_4]:  https://img.shields.io/badge/v5.4-supported-brightgreen.svg?style=flat-square "Laravel v5.4"
[laravel_5_5]:  https://img.shields.io/badge/v5.5-supported-brightgreen.svg?style=flat-square "Laravel v5.5"
[laravel_5_6]:  https://img.shields.io/badge/v5.6-supported-brightgreen.svg?style=flat-square "Laravel v5.6"
[laravel_5_7]:  https://img.shields.io/badge/v5.7-supported-brightgreen.svg?style=flat-square "Laravel v5.7"
[laravel_5_8]:  https://img.shields.io/badge/v5.8-supported-brightgreen.svg?style=flat-square "Laravel v5.8"

[hasher_2_0_x]: https://img.shields.io/badge/version-2.0.*-blue.svg?style=flat-square "Hasher v2.0.*"
[hasher_2_1_x]: https://img.shields.io/badge/version-2.1.*-blue.svg?style=flat-square "Hasher v2.1.*"
[hasher_2_2_x]: https://img.shields.io/badge/version-2.2.*-blue.svg?style=flat-square "Hasher v2.2.*"
[hasher_2_3_x]: https://img.shields.io/badge/version-2.3.*-blue.svg?style=flat-square "Hasher v2.3.*"
[hasher_2_4_x]: https://img.shields.io/badge/version-2.4.*-blue.svg?style=flat-square "Hasher v2.4.*"
[hasher_2_5_x]: https://img.shields.io/badge/version-2.5.*-blue.svg?style=flat-square "Hasher v2.5.*"

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command: `composer require arcanedev/hasher`.

## Laravel

### Setup

> **NOTE :** The package will automatically register itself if you're using Laravel `>= v5.5`, so you can skip this section.

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
// config/app.php

'providers' => [
    ...
    Arcanedev\Hasher\HasherServiceProvider::class,
],
```

### Artisan commands

To publish the config file, run this command:

```bash
php artisan vendor:publish --provider="Arcanedev\Hasher\HasherServiceProvider"
```
