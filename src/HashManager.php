<?php namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Contracts\HashManager as HashManagerContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Manager;

/**
 * Class     HashManager
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashManager extends Manager implements HashManagerContract
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The driver option.
     *
     * @var  string
     */
    protected $option;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * HashManager constructor.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->buildDrivers();
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config('default.driver');
    }

    /**
     * Get the default driver connection.
     *
     * @return string
     */
    public function getDefaultOption()
    {
        return $this->option ?? $this->config('default.option', 'main');
    }

    /**
     * Set the hasher option.
     *
     * @param  string  $option
     *
     * @return \Arcanedev\Hasher\HashManager
     */
    public function option($option = null)
    {
        if ($this->option !== $option) {
            $this->option = $option;
            $this->buildDrivers();
        }

        return $this;
    }

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
    public function with($option = null, $driver = null)
    {
        return $this->option($option)->driver($driver);
    }

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function driver($driver = null)
    {
        return parent::driver($driver);
    }

    /**
     * Build all hash drivers.
     */
    private function buildDrivers(): void
    {
        foreach ($this->config('drivers', []) as $name => $driver) {
            $this->buildDriver($name, $driver);
        }
    }

    /**
     * Build the driver.
     *
     * @param  string  $name
     * @param  array   $params
     */
    private function buildDriver(string $name, array $params): void
    {
        $this->drivers[$name] = $this->container->make($params['driver'], [
            'options' => $params['options'][$this->getDefaultOption()] ?? [],
        ]);
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
        return $this->driver()->encode($value);
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
        return $this->driver()->decode($hashed);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the hasher config.
     *
     * @param  string      $name
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    protected function config(string $name, $default = null)
    {
        return $this->config->get("hasher.$name", $default);
    }
}
