<?php

declare(strict_types=1);

use CyrildeWit\EloquentViewable\EloquentViewableServiceProvider;
use Illuminate\Database\Migrations\Migration;

/**
 * Runs the migration the core ships as a stub, the one an application
 * publishes with `vendor:publish --tag=migrations`.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->stub()->up();
    }

    public function down(): void
    {
        $this->stub()->down();
    }

    private function stub(): CreateViewsTable
    {
        $provider = new ReflectionClass(EloquentViewableServiceProvider::class)->getFileName();

        require_once dirname((string) $provider, 2).'/database/migrations/create_views_table.php.stub';

        return new CreateViewsTable;
    }
};
