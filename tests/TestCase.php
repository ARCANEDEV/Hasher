<?php

declare(strict_types=1);

namespace Arcanedev\Hasher\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Hasher\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->loadDeferredProviders();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Arcanedev\Hasher\HasherServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        /** @var  \Illuminate\Contracts\Config\Repository  $config */
        $config = $app['config'];

        $config->set('hasher.drivers', [
            'hashids' => [
                'driver'  => \Arcanedev\Hasher\Drivers\HashidsDriver::class,
                'options' => [
                    'main'  => [
                        'salt'      => 'This is my main salt',
                        'length'    => 8,
                        'alphabet'  => 'abcdefghij1234567890',
                    ],
                    'alt'   => [
                        'salt'      => 'This is my alternative salt',
                        'length'    => 6,
                        'alphabet'  => 'ABCDEFGHIJ1234567890',
                    ],
                ],
            ],

            'custom'  => [
                'driver' => \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class
            ],
        ]);
    }
}
