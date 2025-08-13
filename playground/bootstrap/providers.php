<?php

use TenantForge\Core\CoreServiceProvider;
use TenantForge\Core\Providers\Filament\CorePanelProvider;

return [
    App\Providers\AppServiceProvider::class,
    CoreServiceProvider::class,
    CorePanelProvider::class,
];
