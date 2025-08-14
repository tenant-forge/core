<?php

use TenantForge\Providers\Filament\CorePanelProvider;
use TenantForge\TenantForgeServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    TenantForgeServiceProvider::class,
    CorePanelProvider::class,
];
