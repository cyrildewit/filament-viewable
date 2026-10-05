<?php

declare(strict_types=1);

use CyrildeWit\FilamentViewable\Tests\Feature\TestCase as FeatureTestCase;
use CyrildeWit\FilamentViewable\Tests\Unit\TestCase as UnitTestCase;

pest()->extend(UnitTestCase::class)->in('Unit');

pest()->extend(FeatureTestCase::class)->in('Feature');
