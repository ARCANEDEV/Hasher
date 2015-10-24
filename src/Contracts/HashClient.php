<?php namespace Arcanedev\Hasher\Contracts;

/**
 * Interface  HashClient
 *
 * @package   Arcanedev\Hasher\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface HashClient
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the client.
     *
     * @return mixed
     */
    public function getClient();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a new Hash client.
     *
     * @param  array  $configs
     *
     * @return self
     */
    public function make(array $configs);

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
