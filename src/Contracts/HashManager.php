<?php

declare(strict_types=1);

namespace Arcanedev\Hasher\Contracts;

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
     * Get the default driver option.
     *
     * @return string
     */
    public function getDefaultOption();

    /**
     * Set the hasher option.
     *
     * @param  string  $option
     *
     * @return \Arcanedev\Hasher\HashManager
     */
    public function option($option = null);

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a driver instance.
     *
     * @param  string       $driver
     * @param  string|null  $option
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function with($option = null, $driver = null);

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function driver($driver = null);
}
