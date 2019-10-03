<?php

use Arcanedev\Hasher\Contracts\HashManager;

if ( ! function_exists('hasher')) {
    /**
     * Get the Hash Manager instance.
     *
     * @return \Arcanedev\Hasher\Contracts\HashManager
     */
    function hasher(): HashManager {
        return app(HashManager::class);
    }
}
