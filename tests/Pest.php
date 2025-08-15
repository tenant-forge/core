<?php

declare(strict_types=1);

namespace TenantForge\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->extends(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');
