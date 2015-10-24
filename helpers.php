<?php

if ( ! function_exists('hasher')) {
    /**
     * Get the Hasher repository.
     *
     * @return \Arcanedev\Hasher\Hasher
     */
    function hasher() {
        return app('arcanedev.hasher');
    }
}
