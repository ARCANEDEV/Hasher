<?php

if ( ! function_exists('hasher')) {
    /**
     * Get the Hasher repository.
     *
     * @return Arcanedev\Hasher\Contracts\HashManager
     */
    function hasher() {
        return app(Arcanedev\Hasher\Contracts\HashManager::class);
    }
}
