<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use TenantForge\Models\CentralUser;

describe('CentralUser Model', function (): void {

    test('to array', function (): void {

        $centralUser = CentralUser::factory()
            ->create()
            ->fresh();

        expect(array_keys($centralUser->toArray()))
        // ->dd()
            ->toBe([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
                'global_id',
            ]);

    });

    it('can be created', function (): void {

        $centralUser = CentralUser::query()
            ->createQuietly([
                'name' => 'John Doe',
                'email' => 'cD6Ht@example.com',
                'password' => Hash::make('password'),
                'global_id' => Str::uuid()->toString(),
            ])
            ->fresh();

        expect($centralUser)
            ->toBeInstanceOf(CentralUser::class);

    });

});
