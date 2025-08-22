<?php

declare(strict_types=1);

namespace TenantForge\Commands;

use Illuminate\Console\Command;

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

        return self::SUCCESS;
    }
}
