<?php namespace Arcanedev\Hasher;
use Arcanedev\Hasher\Exceptions\HasherException;
use Arcanedev\Hasher\Exceptions\HasherNotFoundException;

/**
 * Class     HasherFactory
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherFactory
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  array  */
    protected $clients     = [];

    /** @var  array  */
    protected $connections = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a HasherFactory instance.
     *
     * @param  array  $clients
     * @param  array  $connections
     */
    public function __construct(array $clients, array $connections)
    {
        $this->setClients($clients);
        $this->setConnections($connections);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set hash clients.
     *
     * @param  array  $clients
     *
     * @return self
     */
    private function setClients(array $clients)
    {
        $this->checkClients($clients);
        $this->clients = $clients;

        return $this;
    }

    /**
     * Set hash connections.
     *
     * @param  array  $connections
     *
     * @return self
     */
    private function setConnections(array $connections)
    {
        $this->checkConnections($connections);
        $this->connections = $connections;

        return $this;
    }

    /**
     * @param  string  $client
     *
     * @return Contracts\HashClient
     */
    private function getHasherClient($client)
    {
        $this->hasHasherClient($client);

        $hasher = array_get($this->clients, $client);

        return new $hasher;
    }

    /**
     * Get the hasher client connection.
     *
     * @param  string  $client
     * @param  string  $connection
     *
     * @return array
     */
    private function getHasherConnection($client, $connection)
    {
        return array_get($this->connections, "$client.$connection", []);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a hasher client.
     *
     * @param  string  $client
     * @param  string  $connection
     *
     * @return Contracts\HashClient
     */
    public function make($client, $connection = 'main')
    {
        $hasher  = $this->getHasherClient($client);
        $configs = $this->getHasherConnection($client, $connection);

        return $hasher->make($configs);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check clients.
     *
     * @param  array  $clients
     *
     * @throws Exceptions\HasherException
     */
    private function checkClients(array &$clients)
    {
        if (empty($clients)) {
            throw new HasherException('You must specify the hasher clients.');
        }

        if ( ! $this->isAssoc($clients)) {
            throw new HasherException('The hasher clients must be an associative array [name => class].');
        }
    }

    /**
     * Check if hasher client exists.
     *
     * @param  string  $client
     *
     * @throws Exceptions\HasherNotFoundException
     */
    private function hasHasherClient($client)
    {
        if ( ! array_has($this->clients, $client)) {
            throw new HasherNotFoundException(
                "The hasher client [$client] not found."
            );
        }
    }

    private function checkConnections(array $connections)
    {
        // TODO: Complete the checkConnections() implementation.
    }


    /**
     * Check if array is associative.
     *
     * @param  array  $array
     *
     * @return bool
     */
    private function isAssoc(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
