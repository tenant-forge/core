<?php

declare(strict_types=1);

use TenantForge\Actions\Tenants\CreateTenantAction;
use TenantForge\DataObjects\CreateTenantData;
use TenantForge\Models\Tenant;

beforeEach(function () {
    /** @var CreateTenantData $this->action */
    $this->action = app(CreateTenantAction::class);
});

describe('Create Tenant Action', function (): void {

    test('it adds a domain to the tenant', function (): void {})
        ->todo('When creating a tenant, add the domain to the tenant');

    test('it adds a slug to the tenant', function (): void {})
        ->todo('When creating a tenant, add a slug to the tenant');

    test('if the slug is already taken, it adds a number to the slug', function (): void {})
        ->todo('When creating a tenant, add the number to the slug');

    test('it creates a new tenant', function (): void {

        $data = CreateTenantData::from([
            'name' => 'Test Company',
            'domain' => 'testcompany.com',
            'email' => 'admin@testcompany.com',
        ]);

        $tenant = $this->action->handle($data);

        expect($tenant)->toBeInstanceOf(Tenant::class);

    });

});
