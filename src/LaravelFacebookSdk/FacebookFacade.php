<?php

namespace AndyJessop\LaravelFacebook;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AndyJessop\LaravelFacebook
 */
class FacebookFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * Don't use this. Just... don't.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AndyJessop\LaravelFacebook\LaravelFacebook;
    }
}
