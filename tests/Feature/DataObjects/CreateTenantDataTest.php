<?php

declare(strict_types=1);

use TenantForge\DataObjects\CreateTenantData;

describe('CreateTenantData', function (): void {

    test('to array', function (): void {

        $data = [
            'name' => 'Test Company',
            'domain' => 'testcompany@example.com',
            'email' => 'admin@testcompany.com',
        ];

        $createTenantData = CreateTenantData::from($data);

        expect(array_keys($createTenantData->toArray()))->toBe([
            'name',
            'email',
            'domain',
        ]);

    });

});
