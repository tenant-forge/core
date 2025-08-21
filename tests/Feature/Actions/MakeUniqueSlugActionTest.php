<?php

declare(strict_types=1);

use TenantForge\Actions\MakeUniqueSlugAction;
use TenantForge\Models\Tenant;

beforeEach(function (): void {

    /** @var MakeUniqueSlugAction $this->action */
    $this->action = app(MakeUniqueSlugAction::class);

});

describe('MakeUniqueSlugAction', function (): void {

    test('it returns the slug from the given name if there is no conflict', function (): void {

        $slug = $this->action
            ->handle('This is my new organization', Tenant::class);

        expect($slug)
            ->toBe('this-is-my-new-organization');

    });

    test('it makes a unique slug by adding the correct suffix', function (): void {

        $tenant = Tenant::factory()->createQuietly([
            'name' => 'TenantForge',
            'slug' => 'tenantforge',
            'created_at' => now(),
        ])->fresh();

        Tenant::factory()->createQuietly([
            'name' => 'TenantForge',
            'slug' => 'tenantforge-2',
            'created_at' => now()->addSeconds(15),
        ]);

        Tenant::factory()->createQuietly([
            'name' => 'TenantForge',
            'slug' => 'tenantforge-1',
            'created_at' => now()->addSeconds(1),
        ]);

        $slug = $this->action->handle($tenant->slug, Tenant::class);

        expect($tenant)
            ->toBeInstanceOf(Tenant::class)
            ->and($slug)
            ->toBe('tenantforge-3');

    });

    test('it makes a unique slug', function (): void {

        $tenant = Tenant::factory()->createQuietly([
            'name' => 'TenantForge',
            'slug' => 'tenantforge',
        ]);

        $slug = $this->action->handle($tenant->slug, Tenant::class);

        expect($tenant)
            ->toBeInstanceOf(Tenant::class)
            ->and($slug)
            ->toBe('tenantforge-1');

    });

});
