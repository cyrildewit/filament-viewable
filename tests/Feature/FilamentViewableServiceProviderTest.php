<?php

declare(strict_types=1);

use CyrildeWit\FilamentViewable\FilamentViewableServiceProvider;
use Illuminate\Support\ServiceProvider;

it('loads the translations under the filament-viewable namespace', function (): void {
    $namespaces = app('translator')->getLoader()->namespaces();

    expect($namespaces)->toHaveKey('filament-viewable')
        ->and(realpath($namespaces['filament-viewable']))->toBe(realpath(__DIR__.'/../../resources/lang'));
});

it('publishes the translations to the application', function (): void {
    $paths = ServiceProvider::pathsToPublish(FilamentViewableServiceProvider::class, 'translations');

    expect($paths)->toHaveCount(1)
        ->and(realpath((string) array_key_first($paths)))->toBe(realpath(__DIR__.'/../../resources/lang'))
        ->and(array_first($paths))->toBe(lang_path('vendor/filament-viewable'));
});
