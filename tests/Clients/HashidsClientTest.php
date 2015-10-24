<?php namespace Arcanedev\Hasher\Tests\Clients;

use Arcanedev\Hasher\Clients\HashidsClient;
use Arcanedev\Hasher\Tests\TestCase;

/**
 * Class     HashidsClientTest
 *
 * @package  Arcanedev\Hasher\Tests\Clients
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashidsClientTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  HashidsClient */
    private $hasher;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->hasher = new HashidsClient;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->hasher);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\Hasher\Contracts\HashClient::class,
            \Arcanedev\Hasher\Clients\HashidsClient::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->hasher);
        }

        $this->assertNull($this->hasher->getClient());
    }

    /** @test */
    public function it_can_make()
    {
        $this->hasher->make($this->getConfig());

        $this->assertInstanceOf(\Hashids\Hashids::class, $this->hasher->getClient());
    }

    /** @test */
    public function it_assert_it_can_encode_and_decode()
    {
        $this->hasher->make($this->getConfig());

        $plain  = 123456;
        $hashed = $this->hasher->encode($plain);

        $this->assertNotEquals($hashed, $plain);

        $this->assertTrue(
            in_array($plain, $this->hasher->decode($hashed))
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
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
