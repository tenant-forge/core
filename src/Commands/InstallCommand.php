<?php

namespace TenantForge\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'tenantforge:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('Installing TenantForge...');

        $this->comment('Installing Tenancy...');

        $this->call('tenancy:install');

        return self::SUCCESS;
    }
}
