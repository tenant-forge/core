<?php

declare(strict_types=1);

use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Central\Clusters\Settings\Pages\LogosSettings;
use TenantForge\Models\CentralUser;

use function Pest\Laravel\actingAs;

describe('appearance settings', function (): void {

    beforeEach(function () {

        $this->centralUser = CentralUser::factory()->create();

    });

    test('user must see the appearance navigation items on settings cluster', function () {

        actingAs($this->centralUser, AuthGuard::WebCentral->value)
            ->visit(LogosSettings::getUrl(isAbsolute: false))
            ->assertSee('Appearance')
            ->assertSee('Logos');

    });

});
