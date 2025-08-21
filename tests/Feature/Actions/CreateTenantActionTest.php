<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use TenantForge\Actions\Tenants\CreateTenantAction;
use TenantForge\DataObjects\CreateTenantData;
use TenantForge\Models\Tenant;
use TenantForge\Settings\AppSettings;

beforeEach(function () {

    /** @var AppSettings $this->appSettings */
    $this->appSettings = app(AppSettings::class);
    $this->appSettings->domain = 'testcompany.com';
    $this->appSettings->save();
    /** @var CreateTenantData $this->action */
    $this->action = app(CreateTenantAction::class);
});

describe('Create Tenant Action', function (): void {

    test('it adds a domain to the tenant', function (): void {

        Event::fake();

        $data = CreateTenantData::from([
            'name' => 'Test Company',
            'email' => 'admin@testcompany.com',
        ]);

        $tenant = $this->action->handle($data);

        expect($tenant->domain)
            ->toBe('test-company.testcompany.com');

    });

    test('it adds a slug to the tenant', function (): void {

        Event::fake();

        // Arrange
        $data = CreateTenantData::from([
            'name' => 'Test Company',
            'domain' => 'testcompany.com',
            'email' => 'admin@testcompany.com',
        ]);

        // Act
        $tenant = $this->action->handle($data);

        // Assert
        expect($tenant->slug)
            ->toBe('test-company');

    });

    test('if the slug is already taken, it adds a number to the slug', function (): void {

        Event::fake();

        Tenant::factory()->create([
            'name' => 'Test Company',
            'slug' => 'test-company',
        ]);

        $data = CreateTenantData::from([
            'name' => 'Test Company',
            'email' => 'admin@testcompany.com',
        ]);

        /** @var Tenant $tenant */
        $tenant = $this->action->handle($data);

        expect($tenant->slug)
            ->toBe('test-company-1');

    });

    test('it creates a new tenant', function (): void {

        Event::fake();

        $data = CreateTenantData::from([
            'name' => 'Test Company',
            'domain' => 'testcompany.com',
            'email' => 'admin@testcompany.com',
        ]);

        $tenant = $this->action->handle($data);

        expect($tenant)
            ->toBeInstanceOf(Tenant::class)
            ->and($tenant->slug)
            ->toBe('test-company');

    });

});
