<?php

declare(strict_types=1);

use CyrildeWit\FilamentViewable\ViewablePlugin;
use Filament\Facades\Filament;
use Workbench\App\Filament\Resources\Posts\Pages\ListPosts;
use Workbench\App\Filament\Resources\Posts\PostResource;
use Workbench\App\Models\User;

use function Pest\Livewire\livewire;

it('is registered on the panel', function (): void {
    expect(Filament::getPanel('admin')->getPlugin('filament-viewable'))
        ->toBeInstanceOf(ViewablePlugin::class);
});

it('returns the instance registered on the current panel', function (): void {
    Filament::setCurrentPanel('admin');

    expect(ViewablePlugin::get())
        ->toBe(Filament::getPanel('admin')->getPlugin('filament-viewable'));
});

it('resolves a fresh instance from the container', function (): void {
    expect(ViewablePlugin::make())
        ->toBeInstanceOf(ViewablePlugin::class)
        ->not->toBe(ViewablePlugin::make());
});

it('boots with the panel when a page of it is served', function (): void {
    $this->actingAs(User::factory()->create())
        ->get(PostResource::getUrl('index'))
        ->assertOk();
});

it('leaves the resource pages rendering', function (): void {
    $this->actingAs(User::factory()->create());

    livewire(ListPosts::class)->assertOk();
});
