<?php

declare(strict_types=1);

namespace TenantForge;

use Filament\Auth\Http\Responses\Contracts\RegistrationResponse as FilamentRegistrationResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Central\Pages\Auth\Register;
use TenantForge\Filament\Central\Pages\Onboarding\TenantOnboarding;
use TenantForge\Http\Responses\RegistrationResponse;
use TenantForge\Livewire\CentralDashboardSidebarFooter;

use function array_merge;
use function config;
use function config_path;
use function database_path;
use function file_exists;
use function lang_path;
use function public_path;

final class TenantForgeServiceProvider extends ServiceProvider
{
    public static string $name = 'tenantforge';

    public static string $viewNamespace = 'tenantforge';

    public function register(): void
    {
        $this->app->bind(
            FilamentRegistrationResponse::class,
            RegistrationResponse::class

        );
    }

    public function boot(): void
    {
        $this->configureConfiguration();
        $this->configureMigrations();
        $this->configureTranslations();
        $this->configureViews();
        $this->configureCommands();
        $this->configureResources();
        $this->configureRoutes();
        $this->configureLivewire();
        $this->configureBlade();
        $this->configureAuth();
    }

    private function configureAuth(): void
    {

        config()->set('auth.guards', array_merge(config()->array('auth.guards'), [
            AuthGuard::WebCentral->value => [
                'driver' => 'session',
                'provider' => 'central_users',
            ],
        ]));

        config()->set('auth.providers', array_merge(config()->array('auth.providers'), [
            'central_users' => [
                'driver' => 'eloquent',
                'model' => config()->string('tenantforge.central_user_model'),
            ],
        ]));

    }

    private function configureBlade(): void
    {

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'tenantforge');

    }

    private function configureLivewire(): void
    {

        Livewire::component(
            name: 'central-dashboard-sidebar-footer',
            class: CentralDashboardSidebarFooter::class
        );
        Livewire::component(
            name: 'tenant-forge.filament.pages.auth.register',
            class: Register::class
        );
        Livewire::component(
            name: 'tenant-forge.filament.central.pages.onboarding.tenant-onboarding',
            class: TenantOnboarding::class
        );

    }

    private function configureConfiguration(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../config/tenantforge.php' => config_path('tenantforge.php'),
                ],
                groups: self::$name.'-config'
            );
        }

        $this->mergeConfigFrom(__DIR__.'/../config/tenantforge.php', self::$name);
    }

    private function configureMigrations(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../database/migrations' => database_path('migrations'),
                    __DIR__.'/../database/settings' => database_path('settings'),
                ],
                groups: 'migrations'
            );

        }
    }

    private function configureTranslations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../lang' => lang_path('vendor/'.self::$name),
                ],
                groups: self::$name.'-translations'
            );
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang', self::$name);

    }

    private function configureViews(): void
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', self::$viewNamespace);
        $this->publishes(
            paths: [
                __DIR__.'/../resources/views' => resource_path('views/vendor/'.self::$viewNamespace),
            ],
            groups: self::$name.'-views'
        );
    }

    private function configureCommands(): void
    {
        $this->commands([
            Commands\InstallCommand::class,
            Commands\MakeCentralPanelCommand::class,
        ]);
    }

    private function configureResources(): void
    {

        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/tenantforge/core'),
        ], ['tenantforge', 'tenantforge-assets']);

    }

    private function configureRoutes(): void
    {

        if (file_exists(__DIR__.'/../routes/web.php')) {
            Route::middleware(['web'])
                ->group(function (): void {
                    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                });
        }

        if (file_exists(__DIR__.'/../routes/tenant.php')) {

            $this->loadRoutesFrom(__DIR__.'/../routes/tenant.php');

        }

    }
}
