<?php namespace Arcanedev\Hasher\Contracts;

/**
 * Interface  HashManager
 *
 * @package   Arcanedev\Hasher\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface HashManager
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the hash client.
     *
     * @return HashClient
     */
    public function getHashClient();

    /**
     * Get the default client name.
     *
     * @return string
     */
    public function getDefaultClient();

    /**
     * Get the current client name.
     *
     * @return string
     */
    public function getCurrentClient();

    /**
     * Set the hash client name.
     *
     * @param  string  $client
     *
     * @return self
     */
    public function client($client);

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection();

    /**
     * Get the current connection name.
     *
     * @return string
     */
    public function getCurrentConnection();

    /**
     * Set the hasher connection.
     *
     * @param  string  $connection
     *
     * @return self
     */
    public function connection($connection = 'main');

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
    public function register($name, $class, array $connections = []);

    /**
     * Encode the value.
     *
     * @param  mixed  $value
     *
     * @return string
     */
    public function encode($value);

    /**
     * Decode the hashed value.
     *
     * @param  string  $hash
     *
     * @return mixed
     */
    public function decode($hash);
}
