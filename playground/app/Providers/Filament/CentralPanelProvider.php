<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Support\Colors\Color;
use TenantForge\Providers\Filament\CorePanelProvider;

class CentralPanelProvider extends CorePanelProvider
{
    public function panel(Panel $panel): Panel
    {

        $panel = parent::panel($panel);

        return $panel
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Central/Resources'), for: 'App\\Filament\\Central\\Resources')
            ->discoverPages(in: app_path('Filament/Central/Pages'), for: 'App\\Filament\\Central\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Central/Widgets'), for: 'App\\Filament\\Central\\Widgets');
    }
}
