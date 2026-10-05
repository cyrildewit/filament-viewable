<?php

declare(strict_types=1);

use CyrildeWit\FilamentViewable\ViewablePlugin;

it('is identified as filament-viewable', function (): void {
    expect(new ViewablePlugin()->getId())->toBe('filament-viewable');
});
