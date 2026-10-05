<?php

declare(strict_types=1);

namespace CyrildeWit\FilamentViewable;

use Filament\Contracts\Plugin;
use Filament\Panel;

/**
 * The plugin a panel registers to show view statistics. Its options apply to
 * every column, filter and widget the plugin adds to that panel.
 */
class ViewablePlugin implements Plugin
{
    public static function make(): static
    {
        /** @var static $plugin */
        $plugin = app(static::class);

        return $plugin;
    }

    /**
     * The instance registered on the current panel.
     */
    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(static::make()->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'filament-viewable';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
