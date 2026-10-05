<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('every file declares strict types')
    ->expect(['CyrildeWit\FilamentViewable', 'Workbench'])
    ->toUseStrictTypes();

arch('the plugin never depends on the tests or the workbench')
    ->expect('CyrildeWit\FilamentViewable')
    ->not->toUse(['CyrildeWit\FilamentViewable\Tests', 'Workbench']);
