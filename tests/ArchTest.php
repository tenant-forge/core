<?php

declare(strict_types=1);

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

it('follows PHP architecture rules')
    ->expect('TenantForge')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'exit', 'eval', 'var_dump', 'print_r']);

it('follows security best practices')
    ->expect('TenantForge')
    ->not->toUse(['eval', 'exec', 'shell_exec', 'system', 'passthru']);
