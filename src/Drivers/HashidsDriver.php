<?php namespace Arcanedev\Hasher\Drivers;

use Arcanedev\Hasher\Contracts\HashDriver;
use Hashids\Hashids;
use Illuminate\Support\Arr;

/**
 * Class     HashidsDriver
 *
 * @package  Arcanedev\Hasher\Drivers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashidsDriver implements HashDriver
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var \Hashids\Hashids */
    private $hasher;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * HashidsDriver constructor.
     *
     * @param  array  $options
     */
    public function __construct(array $options)
    {
        $this->hasher = new Hashids(
            Arr::get($options, 'salt', ''),
            Arr::get($options, 'length', 0),
            Arr::get($options, 'alphabet', '')
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
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
        return $this->hasher->encode($value);
    }

    /**
     * Decode the hashed value.
     *
     * @param  string  $hashed
     *
     * @return mixed
     */
    public function decode($hashed)
    {
        return head(
            $this->hasher->decode($hashed)
        );
    }
}
