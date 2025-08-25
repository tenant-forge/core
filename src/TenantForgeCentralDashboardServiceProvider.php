<?php

declare(strict_types=1);

namespace TenantForge;

use Filament\Events\ServingFilament;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Central\Resources\Posts\PostResource;
use TenantForge\Filament\Central\Widgets\TenantsWidget;
use TenantForge\Models\PostType;
use TenantForge\Settings\AppSettings;

use function Filament\Support\original_request;

class TenantForgeCentralDashboardServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::generatePalette('rgb(4, 193, 71)'),
                'gray' => Color::Zinc,
            ])
            ->sidebarWidth('16rem')
            ->maxContentWidth(Width::ScreenTwoExtraLarge)
            ->brandLogo(fn (AppSettings $settings): string => $settings->logo !== null && $settings->logo !== '' && $settings->logo !== '0' ? Storage::disk('public')->url($settings->logo) : '')
            ->darkModeBrandLogo(fn (AppSettings $settings): string => $settings->dark_logo !== null && $settings->dark_logo !== '' && $settings->dark_logo !== '0' ? Storage::disk('public')->url($settings->dark_logo) : '')
            ->favicon(fn (AppSettings $settings): string => $settings->favicon !== null && $settings->favicon !== '' && $settings->favicon !== '0' ? Storage::disk('public')->url($settings->favicon) : '')
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
                    fn (): string => Blade::render("@livewire('tenant-forge.livewire.central-dashboard-sidebar-footer')"),
                );

                $postTypes = PostType::query()
                    ->where('is_active', true)
                    ->orderBy('sort')
                    ->get();

                /** @var array<int, NavigationItem> $navigationItems */
                $navigationItems = $postTypes->map(fn (PostType $postType): NavigationItem => NavigationItem::make($postType->slug)
                    ->label($postType->plural_name)
                    ->url(fn (): string => PostResource::getUrl(parameters: ['type' => $postType->slug]))
                    ->group(__('Content'))
                    ->isActiveWhen(fn (): bool => original_request()->routeIs('filament.admin.resources.content.*') && original_request()->route()?->parameter('type') === $postType->slug)
                    ->icon($postType->icon))
                    ->toArray();

                $contentNavigationGroup = NavigationGroup::make('content');

                $panel
                    ->navigationGroups([
                        $contentNavigationGroup,
                    ])
                    ->navigationItems($navigationItems);

            }
        });
    }
}
