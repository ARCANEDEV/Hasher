<?php namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Contracts\HashManager;
use Illuminate\Support\Arr;

/**
 * Class     Hasher
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Hasher implements HashManager
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Arcanedev\Hasher\HasherFactory */
    protected $factory;

    /**
     * Default client name.
     *
     * @var string
     */
    protected $defaultClient     = '';

    /**
     * Current client name.
     *
     * @var string
     */
    protected $currentClient     = '';

    /**
     * Default connection.
     *
     * @var string
     */
    protected $defaultConnection = '';

    /**
     * Current connection.
     *
     * @var string
     */
    protected $currentConnection = '';

    /**
     * The hash client.
     *
     * @var \Arcanedev\Hasher\Contracts\HashClient
     */
    protected $client;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make Hasher instance.
     *
     * @param  array                            $configs
     * @param  \Arcanedev\Hasher\HasherFactory  $factory
     */
    public function __construct(array $configs, HasherFactory $factory)
    {
        $this->factory           = $factory;

        $this->defaultClient     = Arr::get($configs, 'client', '');
        $this->currentClient     = $this->defaultClient;

        $this->defaultConnection = Arr::get($configs, 'connection', '');
        $this->currentConnection = $this->defaultConnection;

        $this->init();
    }

    /**
     * Make hash client.
     */
    private function init()
    {
        $this->client = $this->factory->make(
            $this->currentClient,
            $this->currentConnection
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the hash client.
     *
     * @return Contracts\HashClient
     */
    public function getHashClient()
    {
        return $this->client;
    }

    /**
     * Get the default client name.
     *
     * @return string
     */
    public function getDefaultClient()
    {
        return $this->defaultClient;
    }

    /**
     * Get the current client name.
     *
     * @return string
     */
    public function getCurrentClient()
    {
        return $this->currentClient;
    }

    /**
     * Set the hash client name.
     *
     * @param  string  $client
     *
     * @return self
     */
    public function client($client)
    {
        $this->factory->checkClient($client);
        $this->currentClient = $client;
        $this->init();

        return $this;
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->defaultConnection;
    }

    /**
     * Get the current connection name.
     *
     * @return string
     */
    public function getCurrentConnection()
    {
        return $this->currentConnection;
    }

    /**
     * Set the hasher connection.
     *
     * @param  string  $connection
     *
     * @return self
     */
    public function connection($connection = 'main')
    {
        $this->currentConnection = $connection;
        $this->init();

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register a hasher client.
     *
     * @param  string  $name
     * @param  string  $class
     * @param  array   $connections
     *
     * @return self
     */
    public function register($name, $class, array $connections = [])
    {
        $this->factory->register($name, $class, $connections);

        return $this;
    }

    /**
     * Encode the value.
     *
     * @param  mixed  $value
     *
     * @return string
     */
    public function encode($value)
    {
        return $this->client->encode($value);
    }

    /**
     * Decode the hashed value.
     *
     * @param  string  $hash
     *
     * @return mixed
     */
    public function decode($hash)
    {
        return $this->client->decode($hash);
    }
}
