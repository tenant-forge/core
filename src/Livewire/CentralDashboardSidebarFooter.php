<?php

declare(strict_types=1);

namespace TenantForge\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Illuminate\View\View;
use Livewire\Component;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;

final class CentralDashboardSidebarFooter extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function settingsAction(): Action
    {
        return Action::make('settings')
            ->icon(Heroicon::OutlinedCog6Tooth)
            ->link()
            ->extraAttributes([
                'class' => 'fi-sidebar-item-btn',
            ])
            ->url(SettingsCluster::getUrl());
    }

    public function render(): View
    {
        return view('tenantforge::livewire.central-dashboard-sidebar-footer');
    }
}
