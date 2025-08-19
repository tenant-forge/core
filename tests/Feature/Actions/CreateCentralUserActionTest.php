<?php

declare(strict_types=1);

use TenantForge\Actions\Users\CreateCentralUserAction;
use TenantForge\DataObjects\CentraUserData;
use TenantForge\Models\CentralUser;

describe('CreateCentralUserAction', function (): void {

    it('creates a new central users', function (): void {

        $data = new CentraUserData(
            name: 'John Doe',
            email: 'joe@example.com',
            password: 'password'
        );

        /** @var CreateCentralUserAction $action */
        $action = app(CreateCentralUserAction::class);

        $centralUser = $action->handle($data);

        expect($centralUser)
            ->toBeInstanceOf(CentralUser::class);

    });

});
