<?php

use App\Providers\Filament\CentralPanelProvider;
use TenantForge\Providers\Filament\CorePanelProvider;
use TenantForge\TenantForgeServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    TenantForgeServiceProvider::class,
    CentralPanelProvider::class,
];
