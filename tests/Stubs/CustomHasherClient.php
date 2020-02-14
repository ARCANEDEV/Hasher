<?php

declare(strict_types=1);

namespace Arcanedev\Hasher\Tests\Stubs;

use Arcanedev\Hasher\Contracts\HashDriver;
use Illuminate\Support\Arr;

/**
 * Class     CustomHasherClient
 *
 * @package  Arcanedev\Hasher\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CustomHasherClient implements HashDriver
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  string */
    protected $salt;

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the client.
     *
     * @return mixed
     */
    public function getClient()
    {
        return 'Custom hash client';
    }

    /**
     * Make a new Hash client.
     *
     * @param  array  $configs
     *
     * @return self
     */
    public function make(array $configs)
    {
        $this->salt = Arr::get($configs, 'salt', '');

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Encode the value.
     *
     * @param  mixed  $value
     *
     * @return string
     */
    public function encode($value)
    {
        return "$value-hashed";
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
        return substr($hash, 0, -7);
    }
}
