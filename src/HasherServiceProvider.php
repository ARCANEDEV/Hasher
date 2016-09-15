<?php namespace Arcanedev\Hasher;

use Arcanedev\Support\PackageServiceProvider as ServiceProvider;

/**
 * Class     HasherServiceProvider
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'hasher';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerHasherService();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\HashManager::class,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Service Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Hasher service.
     */
    private function registerHasherService()
    {
        $this->singleton(Contracts\HashManager::class, function ($app) {
            return new HashManager($app);
        });
    }
}
