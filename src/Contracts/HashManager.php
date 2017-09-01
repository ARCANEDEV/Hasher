<?php namespace Arcanedev\Hasher\Contracts;

/**
 * Interface  HashManager
 *
 * @package   Arcanedev\Hasher\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface HashManager extends HashDriver
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver();

    /**
     * Get the default driver connection.
     *
     * @return string
     */
    public function getDefaultConnection();

    /**
     * Set the hasher connection.
     *
     * @param  string  $connection
     *
     * @return \Arcanedev\Hasher\HashManager
     */
    public function connection($connection = null);

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a driver instance.
     *
     * @param  string       $driver
     * @param  string|null  $connection
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function with($connection = null, $driver = null);

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function driver($driver = null);
}
