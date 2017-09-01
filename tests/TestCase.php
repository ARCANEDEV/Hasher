<?php namespace Arcanedev\Hasher\Tests;

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

    public function setUp()
    {
        parent::setUp();

        $this->app->loadDeferredProviders();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Arcanedev\Hasher\HasherServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            \Arcanedev\Hasher\Facades\Hasher::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        /** @var  \Illuminate\Contracts\Config\Repository  $config */
        $config = $app['config'];

        $config->set('hasher.drivers', [
            'hashids' => \Arcanedev\Hasher\Drivers\HashidsDriver::class,
            'custom'  => \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class,
        ]);

        $config->set('hasher.connections', [
            'hashids'   => [
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
        ]);
    }
}
