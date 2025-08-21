<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Exception;
use Filament\Panel;
use TenantForge\TenantForgeCentralDashboardServiceProvider;

use function app_path;

final class CentralDashboardServiceProvider extends TenantForgeCentralDashboardServiceProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {

        return parent::panel($panel)
            ->discoverPages(in: app_path('Filament/Central/Pages'), for: 'App\Filament\Central\Pages')
            ->discoverResources(in: app_path('Filament/Central/Resources'), for: 'App\Filament\Central\Resources')
            ->discoverWidgets(in: app_path('Filament/Central/Widgets'), for: 'App\Filament\Central\Widgets')
            ->discoverClusters(in: app_path('Filament/Central/Clustres'), for: 'App\Filament\Central\Clusters');

    }
}
