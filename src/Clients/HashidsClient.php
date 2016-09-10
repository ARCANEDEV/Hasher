<?php namespace Arcanedev\Hasher\Clients;

use Arcanedev\Hasher\Contracts\HashClient;
use Hashids\Hashids;
use Illuminate\Support\Arr;

/**
 * Class     HashidsClient
 *
 * @package  Arcanedev\Hasher\Clients
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashidsClient implements HashClient
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Hashids\Hashids */
    private $client;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the client.
     *
     * @return \Hashids\Hashids
     */
    public function getClient()
    {
        return $this->client;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a new Hashids client.
     *
     * @param  array  $configs
     *
     * @return self
     */
    public function make(array $configs)
    {
        $this->client = new Hashids(
            Arr::get($configs, 'salt', ''),
            Arr::get($configs, 'length', 0),
            Arr::get($configs, 'alphabet', '')
        );

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
