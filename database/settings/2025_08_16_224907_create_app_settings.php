<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        rescue(fn () => $this->migrator->add('appearance.logo'));
        rescue(fn () => $this->migrator->add('appearance.dark_logo'));
        rescue(fn () => $this->migrator->add('appearance.favicon'));

        rescue(fn () => $this->migrator->add('appearance.danger', '#EF4444'));
        rescue(fn () => $this->migrator->add('appearance.gray', '#6B7280'));
        rescue(fn () => $this->migrator->add('appearance.info', '#3B82F6'));
        rescue(fn () => $this->migrator->add('appearance.primary', '#04C147'));
        rescue(fn () => $this->migrator->add('appearance.secondary', '#6B7280'));
        rescue(fn () => $this->migrator->add('appearance.success', '#22C55E'));
        rescue(fn () => $this->migrator->add('appearance.warning', '#F59E0B'));

    }
};
