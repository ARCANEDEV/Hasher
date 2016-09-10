<?php namespace Arcanedev\Hasher;

use Illuminate\Support\Arr;

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
    /**
     * The supported clients.
     *
     * @var  array
     */
    protected $clients     = [];

    /**
     * The hashing options.
     *
     * @var  array
     */
    protected $connections = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * HasherFactory constructor.
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
     * Get the hasher client.
     *
     * @param  string  $client
     *
     * @return \Arcanedev\Hasher\Contracts\HashClient
     */
    private function getHasherClient($client)
    {
        $this->checkClient($client);

        $hasher = Arr::get($this->clients, $client);

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
        return Arr::get($this->connections, "$client.$connection", []);
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
     * @return \Arcanedev\Hasher\Contracts\HashClient
     */
    public function make($client, $connection = 'main')
    {
        return $this->getHasherClient($client)->make(
            $this->getHasherConnection($client, $connection)
        );
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
        $this->clients[$name]     = $class;
        $this->connections[$name] = empty($connections) ? ['main' => []] : $connections;
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
        return Arr::has($this->clients, $client);
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
     * @throws \Arcanedev\Hasher\Exceptions\HasherException
     */
    private function checkClients(array &$clients)
    {
        if (empty($clients)) {
            throw new Exceptions\HasherException(
                'You must specify the hasher clients.'
            );
        }

        if ( ! $this->isAssoc($clients)) {
            throw new Exceptions\HasherException(
                'The hasher clients must be an associative array [name => class].'
            );
        }
    }

    /**
     * Check if hasher client exists.
     *
     * @param  string  $client
     *
     * @throws \Arcanedev\Hasher\Exceptions\HasherNotFoundException
     */
    public function checkClient($client)
    {
        if ( ! $this->registered($client)) {
            throw new Exceptions\HasherNotFoundException(
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
            throw new Exceptions\HasherConnectionsException(
                'The hasher connections must be an associative array [key => value].'
            );
        }

        foreach ($connections as $key => $connection) {
            if ( ! array_key_exists('main', $connection)) {
                throw new Exceptions\HasherConnectionsException(
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
