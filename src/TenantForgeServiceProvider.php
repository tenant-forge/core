<?php

namespace TenantForge;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use function config_path;
use function database_path;
use function lang_path;
use function public_path;

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
        $this->configureResources();
        $this->configureRoutes();
        $this->configureLivewire();

    }

    protected function configureRoutes(): void
    {

        Route::middleware(['web'])->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

    }

    protected function configureResources(): void
    {

        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/tenantforge/core'),
        ], ['tenantforge', 'tenantforge-assets']);

    }

    protected function getAssetPackageName(): ?string
    {
        return 'tenantforge/core';
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

    protected function configureLivewire(): void
    {
        // Register Livewire components for the package
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('tenant-forge.create-post', \TenantForge\Livewire\CreatePost::class);
            // Add more components as needed
        }
    }
}
