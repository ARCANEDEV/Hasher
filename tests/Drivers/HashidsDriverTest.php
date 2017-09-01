<?php namespace Arcanedev\Hasher\Tests\Drivers;

use Arcanedev\Hasher\Drivers\HashidsDriver;
use Arcanedev\Hasher\Tests\TestCase;

/**
 * Class     HashidsDriverTest
 *
 * @package  Arcanedev\Hasher\Tests\Clients
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashidsDriverTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Hasher\Drivers\HashidsDriver */
    private $hasher;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->hasher = new HashidsDriver($this->getConfig());
    }

    public function tearDown()
    {
        unset($this->hasher);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\Hasher\Contracts\HashDriver::class,
            \Arcanedev\Hasher\Drivers\HashidsDriver::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->hasher);
        }
    }
    /** @test */
    public function it_assert_it_can_encode_and_decode()
    {
        $value  = 123456;
        $hashed = $this->hasher->encode($value);

        $this->assertNotEquals($hashed, $value);
        $this->assertSame($value, $this->hasher->decode($hashed));
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get Hashids config.
     *
     * @return array
     */
    private function getConfig()
    {
        return [
            'salt'      => 'This is my main salt',
            'length'    => 8,
            'alphabet'  => 'abcdefghij1234567890',
        ];
    }
}
