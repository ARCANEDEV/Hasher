<?php namespace Arcanedev\Hasher\Tests;

/**
 * Class     HasherManagerTest
 *
 * @package  Arcanedev\Hasher\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherManagerTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  \Arcanedev\Hasher\Contracts\HashManager */
    private $manager;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = $this->app->make(\Arcanedev\Hasher\Contracts\HashManager::class);
    }

    public function tearDown()
    {
        unset($this->manager);

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
            \Arcanedev\Hasher\Contracts\HashManager::class,
            \Arcanedev\Hasher\HashManager::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->manager);
        }
    }

    /** @test */
    public function it_can_get_default_driver()
    {
        $this->assertSame('hashids', $this->manager->getDefaultDriver());
    }

    /** @test */
    public function it_can_get_default_connection()
    {
        $this->assertSame('main', $this->manager->getDefaultConnection());
    }

    /** @test */
    public function it_can_set_default_connection()
    {
        $this->manager->connection('alt');

        $this->assertSame('alt', $this->manager->getDefaultConnection());
    }

    /** @test */
    public function it_can_get_hash_driver_without_name()
    {
        $driver = $this->manager->driver();

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Drivers\HashidsDriver::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_get_hash_driver_with_name()
    {
        $driver = $this->manager->driver('custom');

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_get_hash_driver_with_name_and_connection()
    {
        $driver = $this->manager->with('alt', 'custom');

        $this->assertSame('alt', $this->manager->getDefaultConnection());

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_encode_and_decode()
    {
        $value      = 123456;
        $mainDriver = $this->manager->connection('main')->driver();
        $altDriver  = $this->manager->connection('alt')->driver();

        $mainHashed = $mainDriver->encode($value);
        $altHashed  = $altDriver->encode($value);

        $this->assertNotSame($mainHashed, $altHashed);
        $this->assertSame(
            $mainDriver->decode($mainHashed),
            $altDriver->decode($altHashed)
        );
    }

    /** @test */
    public function it_can_encode_and_decode_with_helper()
    {
        $value      = 123456;
        $mainDriver = hash_with('main');
        $altDriver  = hash_with('alt');

        $mainHashed = $mainDriver->encode($value);
        $altHashed  = $altDriver->encode($value);

        $this->assertNotSame($mainHashed, $altHashed);
        $this->assertSame(
            $mainDriver->decode($mainHashed),
            $altDriver->decode($altHashed)
        );
    }

    /** @test */
    public function it_can_encode_and_decode_from_manager()
    {
        $value  = 123456;
        $hashed = $this->manager->encode($value);

        $this->assertNotSame($value, $hashed);
        $this->assertSame($value, $this->manager->decode($hashed));
    }
}
