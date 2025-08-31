<?php

declare(strict_types=1);

namespace TenantForge;

use Exception;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse as FilamentRegistrationResponse;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TenantForge\Configure\ConfigureLivewire;
use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Forms\Components\Builder\BuilderRegistry;
use TenantForge\Http\Responses\RegistrationResponse;
use TenantForge\Settings\AppearanceSettings;
use TenantForge\Settings\AppSettings;

use function app_path;
use function array_merge;
use function base_path;
use function config;
use function config_path;
use function database_path;
use function file_exists;
use function info;
use function lang_path;
use function public_path;
use function resource_path;

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

        $this->app->singleton(
            BuilderRegistry::class,
            fn (): BuilderRegistry => new BuilderRegistry()
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
        $this->configureFilament();

    }

    private function configureRoutes(): void
    {

        /** @var AppSettings $appSettings */
        $appSettings = app(AppSettings::class);

        $appDomain = null;
        try {
            $appDomain = $appSettings->domain;
            /** @phpstan-ignore-next-line  */
        } catch (Exception $exception) {
            info($exception->getMessage());
        }

        if (! $appDomain) {
            $appDomain = config()->string('app.domain', 'localhost');
        }

        /** @var array<string> $centralDomains */
        $centralDomains = [
            ...config()->array('tenancy.central_domains'),
            $appDomain,
        ];

        config()->set('tenancy.central_domains', $centralDomains);

        if (file_exists(__DIR__.'/../routes/web.php')) {
            foreach ($centralDomains as $domain) {
                Route::middleware(['web'])
                    ->domain($domain)
                    ->group(function (): void {
                        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                    });
            }
        }

        if (file_exists(base_path('routes/web.php'))) {
            foreach ($centralDomains as $domain) {
                Route::middleware(['web'])
                    ->domain($domain)
                    ->group(function (): void {
                        $this->loadRoutesFrom(base_path('routes/web.php'));
                    });
            }
        }

        if (file_exists(__DIR__.'/../routes/tenant.php')) {

            $this->loadRoutesFrom(__DIR__.'/../routes/tenant.php');

        }

    }

    private function configureFilament(): void
    {

        if (! $this->app->runningInConsole()) {

            /** @var AppearanceSettings $appearanceSettings */
            $appearanceSettings = app(AppearanceSettings::class);

            FilamentColor::register([
                'danger' => Color::generatePalette($appearanceSettings->danger ?? Color::Red[500]),
                'gray' => Color::Zinc,
                'info' => Color::generatePalette($appearanceSettings->info ?? Color::Blue[500]),
                'primary' => Color::generatePalette($appearanceSettings->primary ?? Color::Emerald[500]),
                'secondary' => Color::generatePalette($appearanceSettings->secondary ?? Color::Orange[500]),
                'success' => Color::generatePalette($appearanceSettings->success ?? Color::Zinc[500]),
                'warning' => Color::generatePalette($appearanceSettings->warning ?? Color::Orange[500]),
            ]);

        }

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

        ConfigureLivewire::registerComponents(
            in: __DIR__.'/Livewire',
            for: 'TenantForge\Livewire'
        );

        ConfigureLivewire::registerComponents(
            in: __DIR__.'/Filament/Central/Pages/Auth',
            for: 'TenantForge\Filament\Central\Pages\Auth'
        );

        ConfigureLivewire::registerComponents(
            in: __DIR__.'/Filament/Central/Pages/Onboarding',
            for: 'TenantForge\Filament\Central\Pages\Onboarding'
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

        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../resources/views' => resource_path('views/vendor/'.self::$viewNamespace),
                ],
                groups: self::$name.'-views'
            );
        }

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

        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../public/' => public_path('vendor/tenantforge/core'),
                ],
                groups: 'tenantforge'
            );

            $this->publishes(
                paths: [
                    __DIR__.'/../assets/CentralDashboardServiceProvider.stub.php' => app_path('Providers/Filament/CentralDashboardServiceProvider.php'),
                ],
                groups: 'tenantforge'
            );
        }

    }
}
