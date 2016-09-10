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

        $this->registerHasherFactory();
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
            'arcanedev.hasher',
            'arcanedev.hasher.factory',
            \Arcanedev\Hasher\Contracts\HashManager::class,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Service Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Hasher factory.
     */
    private function registerHasherFactory()
    {
        $this->singleton('arcanedev.hasher.factory', function ($app) {
            /** @var  \Illuminate\Contracts\Config\Repository  $config */
            $config = $app['config'];

            return new HasherFactory(
                $config->get('hasher.clients'),
                $config->get('hasher.connections')
            );
        });
    }

    /**
     * Register Hasher service.
     */
    private function registerHasherService()
    {
        $this->singleton('arcanedev.hasher', function ($app) {
            /**
             * @var  \Illuminate\Contracts\Config\Repository  $config
             * @var  \Arcanedev\Hasher\HasherFactory          $factory
             */
            $config  = $app['config'];
            $factory = $app['arcanedev.hasher.factory'];

            return new Hasher($config->get('hasher'), $factory);
        });

        $this->bind(
            \Arcanedev\Hasher\Contracts\HashManager::class,
            'arcanedev.hasher'
        );
    }
}
