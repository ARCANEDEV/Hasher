<?php namespace Arcanedev\Hasher\Tests;

use Arcanedev\Hasher\HasherServiceProvider;

/**
 * Class     HasherServiceProviderTest
 *
 * @package  Arcanedev\Hasher\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherServiceProviderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Arcanedev\Hasher\HasherServiceProvider */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(HasherServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\Hasher\HasherServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            'arcanedev.hasher',
            'arcanedev.hasher.factory',
            \Arcanedev\Hasher\Contracts\HashManager::class,
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
