<?php

declare(strict_types=1);

use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use TenantForge\Models\CentralUser;

beforeEach(function (): void {
    $this->app->bind(
        RegistrationResponse::class,
        TenantForge\Http\Responses\RegistrationResponse::class
    );
});

describe('sign-up page', function (): void {

    test('user can navigate to sign-in page', function (): void {

        visit(route('tenantforge.sign-up'))
            ->assertSee(__('tenantforge::auth.sign_up'))
            ->click('Sign in')
            ->assertSee(__('tenantforge::auth.sign_in_message'));

    });

    it('creates a new user', function (): void {

        visit(route('tenantforge.sign-up'))
            ->type('form.name', 'John Doe')
            ->type('form.email', 'joe@example.com')
            ->type('form.password', 'password')
            ->click('Sign up')
            ->assertNoConsoleLogs()
            ->assertSee(__('tenantforge::tenants.create_your_organization'));

        expect(
            CentralUser::query()
                ->where('email', 'joe@example.com')
                ->exists()
        )->toBeTrue();

    });

    it('can be rendered', function (): void {
        visit('/sign-up')
            ->assertButtonEnabled('Sign up')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee(__('tenantforge::auth.already_have_an_account'))
            ->assertSee('Sign in')
            ->assertSee(__('tenantforge::auth.sign_up'))
            ->assertSee(__('tenantforge::auth.already_have_an_account'))
            ->assertDontSee('Confirm password');
    });

});
