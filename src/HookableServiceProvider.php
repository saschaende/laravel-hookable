<?php

namespace SaschaEnde\Hookable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HookableServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind Hookable as a singleton
        $this->app->singleton(\SaschaEnde\Hookable\Hookable::class, fn() => new Hookable());
    }

    public function boot()
    {
        // Blade directive for filters
        Blade::directive('applyFilter', function ($expression) {
            return "<?php echo \\App\\Domains\\Hookable\\Facades\\Hookable::applyFilters($expression); ?>";
        });

        // Blade directive for actions
        Blade::directive('doAction', function ($expression) {
            return "<?php echo \\App\\Domains\\Hookable\\Facades\\Hookable::renderActions($expression); ?>";
        });
    }
}
