<?php

namespace SaschaEnde\Hookable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hookable
 */
class Hookable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'hookable';
    }
}
