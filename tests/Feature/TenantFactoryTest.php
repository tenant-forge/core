<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use TenantForge\Core\Models\Tenant;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Run the tenant migration
    if (! Schema::hasTable('tenants')) {
        $migration = include __DIR__ . '/../../database/migrations/create_tenants_table.php.stub';
        $migration->up();
    }
});

test('tenant factory creates valid tenant', function () {
    $tenant = Tenant::factory()->create();

    expect($tenant)->toBeInstanceOf(Tenant::class)
        ->and($tenant->id)->toBeString()
        ->and($tenant->name)->toBeString()
        ->and($tenant->domain)->toBeString()
        ->and($tenant->email)->toBeString()
        ->and($tenant->data)->toBeArray()
        ->and($tenant->created_at)->not->toBeNull()
        ->and($tenant->updated_at)->not->toBeNull();

    // Verify it's saved to database
    $this->assertDatabaseHas('tenants', [
        'id' => $tenant->id,
        'name' => $tenant->name,
        'domain' => $tenant->domain,
        'email' => $tenant->email,
    ]);
});

test('tenant factory generates unique domains and emails', function () {
    $tenants = Tenant::factory()->count(3)->create();

    $domains = $tenants->pluck('domain')->toArray();
    $emails = $tenants->pluck('email')->toArray();

    expect($domains)->toHaveCount(3)
        ->and(array_unique($domains))->toHaveCount(3)
        ->and($emails)->toHaveCount(3)
        ->and(array_unique($emails))->toHaveCount(3);
});

test('tenant factory creates realistic data structure', function () {
    $tenant = Tenant::factory()->create();

    expect($tenant->data)->toHaveKeys(['settings', 'features'])
        ->and($tenant->data['settings'])->toHaveKeys(['theme', 'timezone'])
        ->and($tenant->data['settings']['theme'])->toBeIn(['light', 'dark'])
        ->and($tenant->data['settings']['timezone'])->toBeString()
        ->and($tenant->data['features'])->toBeArray();

    // Verify features are from the expected list
    $allowedFeatures = ['analytics', 'reporting', 'api_access'];
    foreach ($tenant->data['features'] as $feature) {
        expect($feature)->toBeIn($allowedFeatures);
    }
});

test('tenant factory can override attributes', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Custom Company Name',
        'domain' => 'custom.example.com',
        'email' => 'custom@example.com',
        'data' => ['custom' => 'value'],
    ]);

    expect($tenant->name)->toBe('Custom Company Name')
        ->and($tenant->domain)->toBe('custom.example.com')
        ->and($tenant->email)->toBe('custom@example.com')
        ->and($tenant->data)->toBe(['custom' => 'value']);
});

test('tenant factory can create tenants without stripe_id', function () {
    // Factory should randomly create some tenants with null stripe_id
    $tenants = Tenant::factory()->count(10)->create();

    $tenantsWithoutStripe = $tenants->whereNull('stripe_id');
    $tenantsWithStripe = $tenants->whereNotNull('stripe_id');

    // Should have some variation (not all with or without stripe_id)
    expect($tenantsWithoutStripe->count())->toBeGreaterThan(0);
});

test('tenant factory stripe_id follows correct format when present', function () {
    $tenants = Tenant::factory()->count(20)->create();

    $tenantsWithStripe = $tenants->whereNotNull('stripe_id');

    foreach ($tenantsWithStripe as $tenant) {
        expect($tenant->stripe_id)->toMatch('/^cus_[A-Za-z0-9]{14}$/');
    }
});

test('can create multiple tenants using factory', function () {
    $tenants = Tenant::factory()->count(5)->create();

    expect($tenants)->toHaveCount(5);

    foreach ($tenants as $tenant) {
        expect($tenant)->toBeInstanceOf(Tenant::class);
        $this->assertDatabaseHas('tenants', ['id' => $tenant->id]);
    }
});

test('tenant factory makes valid tenant instances without persisting', function () {
    $tenant = Tenant::factory()->make();

    expect($tenant)->toBeInstanceOf(Tenant::class)
        ->and($tenant->exists)->toBeFalse()
        ->and($tenant->name)->toBeString()
        ->and($tenant->domain)->toBeString()
        ->and($tenant->email)->toBeString();

    // Should not be in database
    $this->assertDatabaseMissing('tenants', [
        'name' => $tenant->name,
        'domain' => $tenant->domain,
    ]);
});
