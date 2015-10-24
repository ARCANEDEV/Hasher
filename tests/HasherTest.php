<?php namespace Arcanedev\Hasher\Tests;

use Arcanedev\Hasher\Hasher;

class HasherTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Hasher */
    private $hasher;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->hasher = $this->app->make('arcanedev.hasher');
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
        $this->assertInstanceOf(\Arcanedev\Hasher\Hasher::class, $this->hasher);

        $this->assertEquals(
            $this->hasher->getDefaultClient(),
            $this->hasher->getCurrentClient()
        );

        $this->assertEquals(
            $this->hasher->getDefaultConnection(),
            $this->hasher->getCurrentConnection()
        );
    }

    /** @test */
    public function it_can_set_the_hash_client()
    {
        $name = 'hashids';
        $this->hasher->client($name);

        $this->assertEquals($name, $this->hasher->getCurrentClient());


        $hashClient = $this->hasher->getHashClient();

        $expectations= [
            \Arcanedev\Hasher\Contracts\HashClient::class,
            \Arcanedev\Hasher\Clients\HashidsClient::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $hashClient);
        }

        $this->assertInstanceOf(\Hashids\Hashids::class, $hashClient->getClient());
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherNotFoundException
     * @expectedExceptionMessage  The hasher client [hash] not found.
     */
    public function it_must_throw_hasher_exception_on_unavailable_client()
    {
        $this->hasher->client('hash');
    }

    /** @test */
    public function it_can_set_and_get_current_connection()
    {
        $connection = 'alt';

        $this->hasher->connection($connection);

        $this->assertNotEquals($connection, $this->hasher->getDefaultConnection());
        $this->assertEquals($connection, $this->hasher->getCurrentConnection());
    }

    /** @test */
    public function it_can_encode_and_decode()
    {
        $plain  = 123456;
        $hashed = $this->hasher->encode($plain);

        $this->assertNotEquals($plain, $hashed);

        $this->assertTrue(in_array($plain, $this->hasher->decode($hashed)));
    }
}
