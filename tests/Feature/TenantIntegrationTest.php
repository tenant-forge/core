<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use TenantForge\Core\Models\Tenant;

uses(RefreshDatabase::class);

test('complete tenant workflow: publish migration, run it, create tenant', function () {
    // Step 1: Ensure we can publish migrations (simulated)
    expect(file_exists(__DIR__ . '/../../database/migrations/create_tenants_table.php.stub'))->toBeTrue();

    // Step 2: Run the migration
    if (! Schema::hasTable('tenants')) {
        $migration = include __DIR__ . '/../../database/migrations/create_tenants_table.php.stub';
        $migration->up();
    }

    // Step 3: Verify table structure
    expect(Schema::hasTable('tenants'))->toBeTrue();

    // Step 4: Create tenant using factory
    $tenant = Tenant::factory()->create([
        'name' => 'Integration Test Company',
        'domain' => 'integration-test.com',
        'email' => 'admin@integration-test.com',
    ]);

    // Step 5: Verify tenant creation
    expect($tenant)->toBeInstanceOf(Tenant::class)
        ->and($tenant->id)->toBeString()
        ->and($tenant->name)->toBe('Integration Test Company')
        ->and($tenant->domain)->toBe('integration-test.com')
        ->and($tenant->email)->toBe('admin@integration-test.com');

    // Step 6: Verify tenant is persisted
    $this->assertDatabaseHas('tenants', [
        'id' => $tenant->id,
        'name' => 'Integration Test Company',
        'domain' => 'integration-test.com',
        'email' => 'admin@integration-test.com',
    ]);

    // Step 7: Test that we can retrieve and use the tenant
    $retrievedTenant = Tenant::where('domain', 'integration-test.com')->first();
    expect($retrievedTenant)->not->toBeNull()
        ->and($retrievedTenant->id)->toBe($tenant->id)
        ->and($retrievedTenant->data)->toBeArray();

    // Step 8: Test updating tenant data
    $retrievedTenant->update([
        'data' => [
            'settings' => ['theme' => 'custom'],
            'updated_in_test' => true,
        ],
    ]);

    $updatedTenant = $retrievedTenant->fresh();
    expect($updatedTenant->data)->toBe([
        'settings' => ['theme' => 'custom'],
        'updated_in_test' => true,
    ]);
});
