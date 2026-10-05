<?php

declare(strict_types=1);

namespace CyrildeWit\FilamentViewable;

use Illuminate\Support\ServiceProvider;

class FilamentViewableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-viewable');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/filament-viewable'),
            ], 'translations');
        }
    }
}
