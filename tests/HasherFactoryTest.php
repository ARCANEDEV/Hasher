<?php namespace Arcanedev\Hasher\Tests;
use Arcanedev\Hasher\HasherFactory;

/**
 * Class     HasherFactoryTest
 *
 * @package  Arcanedev\Hasher\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherFactoryTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var HasherFactory */
    private $hasherFactory;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->hasherFactory = $this->app->make('arcanedev.hasher.factory');
    }

    public function tearDown()
    {
        unset($this->hasherFactory);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(HasherFactory::class, $this->hasherFactory);
    }

    /** @test */
    public function it_can_make_a_hasher_client()
    {
        $hasher = $this->hasherFactory->make('hashids');

        /** @var \Hashids\Hashids $client */
        $client = $hasher->getClient();

        $this->assertInstanceOf(\Hashids\Hashids::class, $client);
        $this->assertEquals('This is my main salt', $client->_salt);
    }

    /** @test */
    public function it_can_make_a_hasher_client_with_different_connection()
    {
        $hasher = $this->hasherFactory->make('hashids', 'alt');

        /** @var \Hashids\Hashids $client */
        $client = $hasher->getClient();

        $this->assertInstanceOf(\Hashids\Hashids::class, $client);
        $this->assertEquals('This is my alternative salt', $client->_salt);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherException
     * @expectedExceptionMessage  You must specify the hasher clients.
     */
    public function it_must_throw_hasher_exception_on_empty_clients()
    {
        new HasherFactory([], []);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherException
     * @expectedExceptionMessage  The hasher clients must be an associative array [name => class].
     */
    public function it_must_throw_hasher_exception_on_invalid_clients()
    {
        new HasherFactory([
            \Arcanedev\Hasher\Clients\HashidsClient::class
        ], []);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherConnectionsException
     * @expectedExceptionMessage  The hasher connections must be an associative array [key => value].
     */
    public function it_must_throw_hasher_exception_on_invalid_connections()
    {
        new HasherFactory([
            'hashids' => \Arcanedev\Hasher\Clients\HashidsClient::class
        ], ['hashids']);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherConnectionsException
     * @expectedExceptionMessage  The hasher [hashids] connections must have a [main] connection.
     */
    public function it_must_throw_hasher_exception_on_main_connection_not_found()
    {
        new HasherFactory([
            'hashids' => \Arcanedev\Hasher\Clients\HashidsClient::class
        ], [
            'hashids'   => [
                'not-main' => []
            ]
        ]);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherNotFoundException
     * @expectedExceptionMessage  The hasher client [hash] not found.
     */
    public function it_must_throw_hasher_exception_on_unavailable_client()
    {
        $this->hasherFactory->make('hash');
    }

    /** @test */
    public function it_can_register_a_custom_hash_client()
    {
        $this->registerCustomClient();
        $hasher = $this->hasherFactory->make('mcrypt');

        $this->assertInstanceOf(Stubs\CustomHasherClient::class, $hasher);
        $this->assertEquals('Custom hash client', $hasher->getClient());
    }

    /** @test */
    public function it_can_register_a_custom_hash_client_with_empty_connections()
    {
        $this->registerCustomClientWithEmptyConnections();
        $hasher = $this->hasherFactory->make('mcrypt');

        $this->assertInstanceOf(Stubs\CustomHasherClient::class, $hasher);
        $this->assertEquals('Custom hash client', $hasher->getClient());
    }

    /** @test */
    public function it_can_encode_and_decode_with_custom_hasher()
    {
        $this->registerCustomClient();

        $hasher = $this->hasherFactory->make('mcrypt');
        $plain  = 123456;
        $hashed = $hasher->encode($plain);

        $this->assertNotEquals($plain, $hashed);

        $this->assertEquals($plain, $hasher->decode($hashed));
    }

    /** @test */
    public function it_can_encode_and_decode_with_custom_hasher_with_empty_connections()
    {
        $this->registerCustomClientWithEmptyConnections();

        $hasher = $this->hasherFactory->make('mcrypt');
        $plain  = 123456;
        $hashed = $hasher->encode($plain);

        $this->assertNotEquals($plain, $hashed);

        $this->assertEquals($plain, $hasher->decode($hashed));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function registerCustomClient()
    {
        $this->hasherFactory->register(
            'mcrypt', Stubs\CustomHasherClient::class,
            [
                'main'  => [
                    'salt'  => 'main salt to (en/de)crypt',
                ],
                'alt'  => [
                    'salt'  => 'alt salt to (en/de)crypt',
                ],
            ]
        );
    }

    private function registerCustomClientWithEmptyConnections()
    {
        $this->hasherFactory->register(
            'mcrypt', Stubs\CustomHasherClient::class
        );
    }
}
