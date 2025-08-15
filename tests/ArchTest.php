<?php

declare(strict_types=1);

use TenantForge\Commands\MakeCentralPanelCommand;
use Workbench\App\Models\User;

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch()->preset()->php();

arch()->preset()->security();

arch()->preset()->strict()->ignoring([
    MakeCentralPanelCommand::class,
    User::class,
    'TenantForge\Filament',
]);
