<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        rescue(fn () => $this->migrator->add('app.name', 'TenantForge'));
        rescue(fn () => $this->migrator->add('app.domain', 'localhost'));
        rescue(fn () => $this->migrator->add('app.about', 'TenantForge is a multi-tenant application built with Laravel and Filament.'));
        rescue(fn () => $this->migrator->add('app.timezone', 'UTC'));
        rescue(fn () => $this->migrator->add('app.locale', 'en'));

    }
};
