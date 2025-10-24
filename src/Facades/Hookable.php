<?php

namespace SaschaEnde\Hookable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void action(string $name, callable $callback, int $priority = 10)
 * @method static void filter(string $name, callable $callback, int $priority = 10)
 * @method static mixed applyFilters(string $name, mixed $value = null, ...$params)
 * @method static string renderActions(string $name, ...$params)
 *
 * @see \SaschaEnde\Hookable\Hookable
 */
class Hookable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SaschaEnde\Hookable\Hookable::class;
    }
}
