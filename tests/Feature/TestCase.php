<?php

declare(strict_types=1);

namespace CyrildeWit\FilamentViewable\Tests\Feature;

use CyrildeWit\FilamentViewable\FilamentViewableServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Workbench\App\Providers\Filament\AdminPanelProvider;
use Workbench\App\Providers\WorkbenchServiceProvider;

use function Orchestra\Testbench\default_migration_path;

/**
 * Boots the workbench: the panel `make serve` opens, with the plugin
 * registered on it, on an in-memory SQLite database.
 */
abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * Filament, Livewire and the core come in through package discovery, the
     * way they reach an application, so the list of Filament's own providers
     * never has to be kept in step here. Discovery reads the installed
     * packages only, so this plugin's own provider is listed below.
     */
    #[\Override]
    protected $enablesPackageDiscoveries = true;

    /**
     * @param  Application  $app
     * @return list<class-string<ServiceProvider>>
     */
    #[\Override]
    protected function getPackageProviders($app): array
    {
        return [
            FilamentViewableServiceProvider::class,
            WorkbenchServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    /** @param  Application  $app */
    #[\Override]
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
    }

    #[\Override]
    protected function defineDatabaseMigrations(): void
    {
        // The users table the workbench signs in with, and its own tables.
        $this->loadMigrationsFrom(default_migration_path());
        $this->loadMigrationsFrom(__DIR__.'/../../workbench/database/migrations');
    }
}
