<?php namespace Arcanedev\Hasher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class     Hasher
 *
 * @package  Arcanedev\Hasher\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Hasher extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'arcanedev.hasher'; }
}
