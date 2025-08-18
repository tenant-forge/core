<?php

declare(strict_types=1);

namespace TenantForge\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

use function array_merge;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {

        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'TenantForge\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

    }

    final public function getEnvironmentSetUp($app): void
    {

        $app['config']->set([
            'auth.providers.users.model' => 'Workbench\\App\\Models\\User',
            'database.default' => 'testing',
            'cache.default' => 'array',
            'session.driver' => 'array',
            'app.locale' => 'en',
            'app.debug' => true,
            'app.env' => 'testing',
        ]);

    }

    /**
     * @return class-string[]
     */
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            SupportServiceProvider::class,
            FilamentServiceProvider::class,
            LivewireServiceProvider::class,
            ActionsServiceProvider::class,
            FormsServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            WidgetsServiceProvider::class,
            SchemasServiceProvider::class,
            NotificationsServiceProvider::class,
            // LaravelSettingsServiceProvider::class,
            // LaravelDataServiceProvider::class,
        ]);
    }
}
