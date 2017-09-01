<?php namespace Arcanedev\Hasher\Contracts;

/**
 * Interface  HashDriver
 *
 * @package   Arcanedev\Hasher\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface HashDriver
{
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
    public function encode($value);

    /**
     * Decode the hashed value.
     *
     * @param  string  $hashed
     *
     * @return mixed
     */
    public function decode($hashed);
}
