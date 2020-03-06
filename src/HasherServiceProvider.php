<?php

declare(strict_types=1);

namespace Arcanedev\Hasher;

use Arcanedev\Hasher\Contracts\HashManager as HashManagerContract;
use Arcanedev\Support\Providers\PackageServiceProvider as ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     HasherServiceProvider
 *
 * @package  Arcanedev\Hasher
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HasherServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'hasher';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->registerConfig();

        $this->singleton(HashManagerContract::class, HashManager::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            HashManagerContract::class,
        ];
    }
}
