@php use Filament\Support\Icons\Heroicon;use TenantForge\Filament\Central\Clusters\Settings\Pages\LogosSettings;use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster; @endphp
<div class="p-4">
    <ul class="fi-sidebar-group-items">
        <li
                @class([
                    'fi-sidebar-item fi-sidebar-item-has-url',
                    'fi-active' => Str::startsWith(request()->url(), SettingsCluster::getUrl())
                ])
        >
            <a href="{{ SettingsCluster::getUrl() }}"
               class="fi-sidebar-item-btn"
            >
                <x-filament::icon
                        icon="heroicon-{{ Heroicon::OutlinedCog6Tooth->value }}"
                        class="fi-icon fi-size-lg fi-sidebar-item-icon"
                />
                <span class="fi-sidebar-item-label">
                    {{ __('Settings') }}
                </span>
            </a>
        </li>

        <li
                @class([
                    'fi-sidebar-item fi-sidebar-item-has-url',
                    //'fi-active' => Str::startsWith(request()->url(), SettingsCluster::getUrl())
                ])
        >
            <a href="{{ SettingsCluster::getUrl() }}"
               class="fi-sidebar-item-btn"
               target="_blank"
            >
                <x-filament::icon
                        icon="heroicon-{{ Heroicon::OutlinedBookOpen }}"
                        class="fi-icon fi-size-lg fi-sidebar-item-icon"
                />
                <span class="fi-sidebar-item-label">
                    {{ __('Documentation') }}
                </span>
            </a>
        </li>

    </ul>
</div>
