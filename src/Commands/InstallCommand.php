<?php

declare(strict_types=1);

namespace TenantForge\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class InstallCommand extends Command
{
    public $signature = 'tenantforge:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('Installing TenantForge...');

        $this->comment('Setting Tenancy');

        $this->call('tenancy:install');

        $this->comment('Setting Filament');

        $this->call('filament:install', [
            '--no-interaction' => true,
        ]);

        $this->call('filament:assets');

        $this->comment('Publishing TenantForge assets...');

        $this->call('vendor:publish', [
            '--provider' => 'TenantForge\\TenantForgeServiceProvider',
            '--tag' => 'tenantforge',
        ]);

        $this->comment('Adding CentralDashboardServiceProvider to application providers...');
        $this->addProviderToBootstrap();

        return self::SUCCESS;
    }

    private function addProviderToBootstrap(): void
    {
        $providersFile = base_path('bootstrap/providers.php');
        $providerClass = 'App\\Providers\\Filament\\CentralDashboardServiceProvider::class';

        if (!File::exists($providersFile)) {
            $this->warn('bootstrap/providers.php not found. Please manually add the provider to your application.');
            return;
        }

        $content = File::get($providersFile);

        if (str_contains($content, $providerClass)) {
            $this->info('CentralDashboardServiceProvider already registered.');
            return;
        }

        $pattern = '/return\s*\[\s*(.*?)\s*\];/s';

        if (preg_match($pattern, $content, $matches)) {
            $existingProviders = trim($matches[1]);

            $newProviders = $existingProviders
                ? $existingProviders . ",\n    " . $providerClass
                : "    " . $providerClass;

            $newContent = preg_replace(
                $pattern,
                "return [\n" . $newProviders . ",\n];",
                $content
            );

            File::put($providersFile, $newContent);
            $this->info('CentralDashboardServiceProvider added to bootstrap/providers.php');
        } else {
            $this->warn('Could not parse bootstrap/providers.php. Please manually add the provider to your application.');
        }
    }
}
