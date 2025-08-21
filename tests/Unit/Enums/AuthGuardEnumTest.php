<?php

declare(strict_types=1);

use TenantForge\Enums\AuthGuard;

describe('AuthGuardEnum', function (): void {

    test('it has a web auth guard', function (): void {

        $webAuthGuard = AuthGuard::Web->value;

        expect($webAuthGuard)
            ->toBe('web');

    });

    test('it has a web central auth guard', function (): void {
        $webCentralAuthGuard = AuthGuard::WebCentral->value;

        expect($webCentralAuthGuard)
            ->toBe('web_central');
    });

});
