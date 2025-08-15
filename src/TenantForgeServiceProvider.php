<?php

namespace TenantForge;

use Illuminate\Support\ServiceProvider;

use function config_path;
use function database_path;
use function lang_path;

class TenantForgeServiceProvider extends ServiceProvider
{
    public static string $name = 'tenantforge';

    public static string $viewNamespace = 'tenantforge';

    public function boot(): void
    {
        $this->configureConfiguration();
        $this->configureMigrations();
        $this->configureTranslations();
        $this->configureViews();
        $this->configureCommands();
    }

    protected function configureCommands(): void
    {
        $this->commands([
            Commands\InstallCommand::class,
            Commands\MakeCentralPanelCommand::class,
        ]);
    }

    protected function configureViews(): void
    {

        $this->loadViewsFrom(__DIR__ . '/../resources/views', static::$viewNamespace);
        $this->publishes(
            paths: [
                __DIR__ . '/../resources/views' => resource_path('views/vendor/' . static::$viewNamespace),
            ],
            groups: static::$name . '-views'
        );
    }

    protected function configureTranslations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../lang' => lang_path('vendor/' . static::$name),
                ],
                groups: static::$name . '-translations'
            );
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', static::$name);

    }

    protected function configureMigrations(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishesMigrations(
                paths: [
                    __DIR__ . '/../database/migrations' => database_path('migrations'),
                ],
                groups: 'tenantforge-migrations'
            );

        }

    }

    protected function configureConfiguration(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../config/tenantforge.php' => config_path('tenantforge.php'),
                ],
                groups: static::$name . '-config'
            );
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/tenantforge.php', static::$name);
    }
}
