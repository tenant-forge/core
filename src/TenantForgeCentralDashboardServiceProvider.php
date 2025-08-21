<?php

declare(strict_types=1);

namespace TenantForge;

use Filament\Events\ServingFilament;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Central\Widgets\TenantsWidget;

final class TenantForgeCentralDashboardServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarWidth('18rem')
            ->maxContentWidth(Width::ScreenTwoExtraLarge)
            ->viteTheme('resources/css/filament/theme.css', 'vendor/tenantforge/core/build')
            ->discoverResources(in: __DIR__.'/Filament/Central/Resources', for: 'TenantForge\\Filament\\Central\\Resources')
            ->discoverPages(in: __DIR__.'/Filament/Central/Pages', for: 'TenantForge\\Filament\\Central\\Pages')
            ->discoverClusters(__DIR__.'/Filament/Central/Clusters', for: 'TenantForge\\Filament\\Central\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: __DIR__.'/Filament/Central/Widgets', for: 'TenantForge\\Filament\\Central\\Widgets')
            ->widgets([
                TenantsWidget::class,
                // Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                // @codeCoverageIgnoreStart
                DisableBladeIconComponents::class,
                // @codeCoverageIgnoreEnd
                DispatchServingFilamentEvent::class,
            ])
            ->authGuard(AuthGuard::WebCentral->value)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public function boot(): void
    {
        Filament::serving(function (ServingFilament $event): void {
            $panel = Filament::getCurrentPanel();
            if ($panel?->getId() === 'admin') {
                FilamentView::registerRenderHook(
                    PanelsRenderHook::SIDEBAR_FOOTER,
                    fn (): string => Blade::render("@livewire('central-dashboard-sidebar-footer')"),
                );
            }
        });
    }
}
