<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

test('can publish tenant migrations', function () {
    // Clean up any existing published migrations
    $migrationPath = database_path('migrations');
    if (File::exists($migrationPath)) {
        $tenantMigrationFiles = File::glob($migrationPath . '/*create_tenants_table.php');
        foreach ($tenantMigrationFiles as $file) {
            File::delete($file);
        }
    }

    // Publish migrations
    Artisan::call('vendor:publish', [
        '--tag' => 'core-migrations',
        '--force' => true,
    ]);

    // Check if migration file was published
    $migrationFiles = File::glob(database_path('migrations/*create_tenants_table.php'));
    expect($migrationFiles)->not->toBeEmpty()
        ->and(count($migrationFiles))->toBe(1);

    $migrationContent = File::get($migrationFiles[0]);
    expect($migrationContent)
        ->toContain('Schema::create(\'tenants\'')
        ->toContain('$table->uuid(\'id\')->primary()')
        ->toContain('$table->string(\'name\')')
        ->toContain('$table->string(\'domain\')->unique()')
        ->toContain('$table->string(\'email\')->unique()')
        ->toContain('$table->string(\'stripe_id\')->nullable()')
        ->toContain('$table->jsonb(\'data\')->nullable()');
});

test('migration creates tenants table with correct schema', function () {
    // Run the migration
    $migration = include __DIR__ . '/../../database/migrations/create_tenants_table.php.stub';
    $migration->up();

    // Verify table exists
    expect(Schema::hasTable('tenants'))->toBeTrue();

    // Verify columns exist
    expect(Schema::hasColumn('tenants', 'id'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'name'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'domain'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'email'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'stripe_id'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'data'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'created_at'))->toBeTrue()
        ->and(Schema::hasColumn('tenants', 'updated_at'))->toBeTrue();

    // Test migration rollback
    $migration->down();
    expect(Schema::hasTable('tenants'))->toBeFalse();
});
