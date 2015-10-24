<?php namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Exceptions\HasherConnectionsException;
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
        $this->checkClient($client);

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

    /**
     * Register a hasher client.
     *
     * @param  string  $name
     * @param  string  $class
     * @param  array   $connections
     */
    public function register($name, $class, array $connections = [])
    {
        if (empty($connections)) {
            $connections = [
                'main' => []
            ];
        }

        $this->clients[$name]     = $class;
        $this->connections[$name] = $connections;
    }

    /**
     * Check if client is registered.
     *
     * @param  string  $client
     *
     * @return bool
     */
    public function registered($client)
    {
        return array_has($this->clients, $client);
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
    public function checkClient($client)
    {
        if ( ! $this->registered($client)) {
            throw new HasherNotFoundException(
                "The hasher client [$client] not found."
            );
        }
    }

    /**
     * Check the hasher connections.
     *
     * @param  array  $connections
     *
     * @throws \Arcanedev\Hasher\Exceptions\HasherConnectionsException
     */
    private function checkConnections(array $connections)
    {
        if ( ! $this->isAssoc($connections)) {
            throw new HasherConnectionsException(
                'The hasher connections must be an associative array [key => value].'
            );
        }

        foreach ($connections as $key => $connection) {
            if ( ! array_key_exists('main', $connection)) {
                throw new HasherConnectionsException(
                    "The hasher [$key] connections must have a [main] connection."
                );
            }
        }
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
