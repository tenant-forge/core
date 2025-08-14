<?php

use TenantForge\Models\Tenant;

test('can create a tenant with all required fields', function () {

    $tenant = Tenant::query()
        ->create([
            'name' => 'Test Company',
            'domain' => 'testcompany.com',
            'email' => 'admin@testcompany.com',
            'stripe_id' => 'cus_test123456789',
            'data' => [
                'settings' => ['theme' => 'dark'],
                'features' => ['analytics', 'reporting'],
            ],
        ]);

    expect($tenant)
        ->toBeInstanceOf(Tenant::class)
        ->and($tenant->id)
        ->toBeString()
        ->and($tenant->name)
        ->toBe('Test Company')
        ->and($tenant->domain)
        ->toBe('testcompany.com')
        ->and($tenant->email)
        ->toBe('admin@testcompany.com')
        ->and($tenant->stripe_id)
        ->toBe('cus_test123456789')
        ->and($tenant->data)
        ->toBe([
            'settings' => ['theme' => 'dark'],
            'features' => ['analytics', 'reporting'],
        ])
        ->and(
            Tenant::query()
                ->where('id', $tenant->id)
                ->exists()
        )
        ->toBeTrue();

});

test('tenant id is automatically generated as uuid', function () {
    $tenant = Tenant::create([
        'name' => 'Test Company',
        'domain' => 'testcompany.com',
        'email' => 'admin@testcompany.com',
    ]);

    expect($tenant->id)
        ->toBeString()
        ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('can create tenant without optional fields', function () {
    $tenant = Tenant::query()->create([
        'name' => 'Minimal Company',
        'domain' => 'minimal.com',
        'email' => 'admin@minimal.com',
    ]);

    expect($tenant->stripe_id)->toBeNull()
        ->and($tenant->data)->toBeNull();
});

test('data field is properly cast to array', function () {
    $data = [
        'settings' => ['theme' => 'light', 'timezone' => 'UTC'],
        'features' => ['api_access'],
        'metadata' => ['created_by' => 'admin'],
    ];

    $tenant = Tenant::create([
        'name' => 'JSON Test Company',
        'domain' => 'jsontest.com',
        'email' => 'admin@jsontest.com',
        'data' => $data,
    ]);

    expect($tenant->data)->toBe($data)
        ->and($tenant->data)->toBeArray();

    // Refresh from database to ensure casting works on retrieval
    $tenant->refresh();
    expect($tenant->data)->toBe($data);
});

test('domain field must be unique', function () {
    Tenant::create([
        'name' => 'First Company',
        'domain' => 'unique.com',
        'email' => 'first@unique.com',
    ]);

    expect(fn () => Tenant::create([
        'name' => 'Second Company',
        'domain' => 'unique.com',
        'email' => 'second@unique.com',
    ]))->toThrow(Exception::class);
});

test('email field must be unique', function () {
    Tenant::create([
        'name' => 'First Company',
        'domain' => 'first.com',
        'email' => 'admin@unique.com',
    ]);

    expect(fn () => Tenant::create([
        'name' => 'Second Company',
        'domain' => 'second.com',
        'email' => 'admin@unique.com',
    ]))->toThrow(Exception::class);
});

test('tenant has timestamps', function () {
    $tenant = Tenant::create([
        'name' => 'Timestamp Company',
        'domain' => 'timestamp.com',
        'email' => 'admin@timestamp.com',
    ]);

    expect($tenant->created_at)->not->toBeNull()
        ->and($tenant->updated_at)->not->toBeNull()
        ->and($tenant->created_at)->toBeInstanceOf(Carbon\Carbon::class)
        ->and($tenant->updated_at)->toBeInstanceOf(Carbon\Carbon::class);
});
