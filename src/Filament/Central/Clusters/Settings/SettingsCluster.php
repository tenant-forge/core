<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

final class SettingsCluster extends Cluster
{
    protected static ?int $navigationSort = 99;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
