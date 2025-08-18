<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use TenantForge\DataObjects\CentraUserData;

describe('CentraUserData', function (): void {

    test('to array', function (): void {

        $centralUserData = CentraUserData::from([
            'name' => 'John Doe',
            'email' => 'joe@example.com',
            'password' => 'password',
        ]);

        expect(array_keys($centralUserData->toArray()))
            ->toBe(['name', 'email', 'password', 'global_id']);

    });

    it('sets the global id', function (): void {
        $centralUserData = new CentraUserData(
            name: 'John Doe',
            email: 'joe@example.com',
            password: 'password'
        );

        expect($centralUserData->global_id)
            ->not()
            ->toBeEmpty()
            ->and(Str::isUuid($centralUserData->global_id))
            ->toBeTrue();

    });

    it('can be created', function (): void {

        $centralUserData = new CentraUserData(
            name: 'John Doe',
            email: 'joe@example.com',
            password: 'password'
        );

        expect($centralUserData->name)
            ->toBe('John Doe')
            ->and($centralUserData->email)
            ->toBe('joe@example.com')
            ->and($centralUserData->password);

    });

});
