<?php

declare(strict_types=1);

namespace Arcanedev\Hasher\Tests;

/**
 * Class     HasherManagerTest
 *
 * @package  Arcanedev\Hasher\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherManagerTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Hasher\Contracts\HashManager */
    private $manager;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = $this->app->make(\Arcanedev\Hasher\Contracts\HashManager::class);
    }

    protected function tearDown(): void
    {
        unset($this->manager);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $expectations = [
            \Arcanedev\Hasher\Contracts\HashManager::class,
            \Arcanedev\Hasher\HashManager::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->manager);
        }
    }

    /** @test */
    public function it_can_get_default_driver(): void
    {
        static::assertSame('hashids', $this->manager->getDefaultDriver());
    }

    /** @test */
    public function it_can_get_default_option(): void
    {
        static::assertSame('main', $this->manager->getDefaultOption());
    }

    /** @test */
    public function it_can_set_default_option(): void
    {
        $this->manager->option('alt');

        static::assertSame('alt', $this->manager->getDefaultOption());
    }

    /** @test */
    public function it_can_get_hash_driver_without_name(): void
    {
        $driver = $this->manager->driver();

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Drivers\HashidsDriver::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_get_hash_driver_with_name(): void
    {
        $driver = $this->manager->driver('custom');

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_get_hash_driver_with_name_and_option(): void
    {
        $driver = $this->manager->with('alt', 'custom');

        static::assertSame('alt', $this->manager->getDefaultOption());

        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Tests\Stubs\CustomHasherClient::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $driver);
        }
    }

    /** @test */
    public function it_can_encode_and_decode(): void
    {
        $value      = 123456;
        $mainDriver = $this->manager->option('main')->driver();
        $altDriver  = $this->manager->option('alt')->driver();

        $mainHashed = $mainDriver->encode($value);
        $altHashed  = $altDriver->encode($value);

        static::assertNotSame($mainHashed, $altHashed);
        static::assertSame(
            $mainDriver->decode($mainHashed),
            $altDriver->decode($altHashed)
        );
    }

    /** @test */
    public function it_can_encode_and_decode_with_helper(): void
    {
        $value      = 123456;
        $mainDriver = hasher()->with('main');
        $altDriver  = hasher()->with('alt');

        $mainHashed = $mainDriver->encode($value);
        $altHashed  = $altDriver->encode($value);

        static::assertNotSame($mainHashed, $altHashed);
        static::assertSame(
            $mainDriver->decode($mainHashed),
            $altDriver->decode($altHashed)
        );
    }

    /** @test */
    public function it_can_encode_and_decode_from_manager(): void
    {
        $value  = 123456;
        $hashed = $this->manager->encode($value);

        static::assertNotSame($value, $hashed);
        static::assertSame($value, $this->manager->decode($hashed));
    }
}
