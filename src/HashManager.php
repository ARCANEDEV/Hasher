<?php namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Contracts\HashManager as HashManagerContract;
use Illuminate\Support\Arr;
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
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

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
        return $this->getHasherConfig('default.driver');
    }

    /**
     * Get the default driver connection.
     *
     * @return string
     */
    public function getDefaultOption()
    {
        return $this->option ?? $this->getHasherConfig('default.option', 'main');
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
        if ( ! is_null($option)) {
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
    private function buildDrivers()
    {
        $drivers = $this->getHasherConfig('drivers', []);

        foreach ($drivers as $name => $driver) {
            $this->buildDriver($name, $driver);
        }
    }

    /**
     * Build the driver.
     *
     * @param  string  $name
     * @param  array  $driver
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    private function buildDriver($name, array $driver)
    {
        return $this->drivers[$name] = new $driver['driver'](
            Arr::get($driver, 'options.'.$this->getDefaultOption(), [])
        );
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
    protected function getHasherConfig($name, $default = null)
    {
        return $this->app->make('config')->get("hasher.$name", $default);
    }
}
