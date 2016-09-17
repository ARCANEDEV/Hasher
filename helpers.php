<?php

if ( ! function_exists('hasher')) {
    /**
     * Get the Hash Manager instance.
     *
     * @return \Arcanedev\Hasher\Contracts\HashManager
     */
    function hasher()
    {
        return app(Arcanedev\Hasher\Contracts\HashManager::class);
    }
}

if ( ! function_exists('hash_with')) {
    /**
     * Get the Hash Driver instance.
     *
     * @param  string       $connection
     * @param  string|null  $driver
     *
     * @return \Arcanedev\Hasher\Contracts\HashDriver
     */
    function hash_with($connection, $driver = null)
    {
        return hasher()->with($connection, $driver);
    }
}
