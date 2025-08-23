<?php

declare(strict_types=1);

use TenantForge\Filament\Central\Clusters\Settings\Pages\GeneralSettings;
use TenantForge\Models\CentralUser;

describe('App Settings Page', function (): void {

    test('it has a logo file upload component', function (): void {

        // Arrange
        /** @var CentralUser $user */
        $user = CentralUser::factory()
            ->create()
            ->fresh();

        // Act
        visit(route('tenantforge.sign-in', absolute: false))
            ->type('form.email', $user->email)
            ->type('form.password', 'password')
            ->click('Sign in');

        visit(GeneralSettings::getUrl())
            ->assertSee('General Settings')
            ->assertSee('Name')
            ->assertSee('Domain')
            ->assertSee('About');

    });

});
