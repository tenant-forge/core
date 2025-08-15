<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use TenantForge\Models\Tenant;

final class TenantsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            StatsOverviewWidget\Stat::make('Tenants', Tenant::query()->count())
                ->description('Total number of tenants')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
