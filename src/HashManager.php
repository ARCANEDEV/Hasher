<?php namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Contracts\HashManager as HashManagerContract;
use Arcanedev\Support\Manager;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class     HashManager
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HashManager extends Manager implements HashManagerContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The driver connection.
     *
     * @var  string
     */
    protected $connection;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->buildDrivers();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
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
    public function getDefaultConnection()
    {
        return is_null($this->connection)
            ? $this->getHasherConfig('default.connection', 'main')
            : $this->connection;
    }

    /**
     * Set the hasher connection.
     *
     * @param  string  $connection
     *
     * @return \Arcanedev\Hasher\HashManager
     */
    public function connection($connection = null)
    {
        if ( ! is_null($connection)) {
            $this->connection = $connection;
            $this->buildDrivers();
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a driver instance.
     *
     * @param  string       $driver
     * @param  string|null  $connection
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    public function with($connection = null, $driver = null)
    {
        return $this->connection($connection)
                    ->driver($driver);
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

        foreach ($drivers as $name => $class) {
            $this->buildDriver($name, $class);
        }
    }

    /**
     * Build the driver.
     *
     * @param  string  $name
     * @param  string  $class
     *
     * @return Contracts\HashDriver
     */
    private function buildDriver($name, $class)
    {
        $connection           = $this->getDefaultConnection();
        $this->drivers[$name] = $this->app->make($class, [
            $this->getHasherConfig("connections.$name.$connection", [])
        ]);

        return $this->drivers[$name];
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
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
        return $this->app['config']->get("hasher.$name", $default);
    }
}
