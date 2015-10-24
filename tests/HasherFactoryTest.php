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
        parent::tearDown();

        unset($this->hasherFactory);
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
     * @expectedException         \Arcanedev\Hasher\Exceptions\HasherNotFoundException
     * @expectedExceptionMessage  The hasher client [hash] not found.
     */
    public function it_must_throw_hasher_exception_on_unavailable_client()
    {
        $this->hasherFactory->make('hash');
    }
}
