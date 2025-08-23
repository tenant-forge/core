<?php

declare(strict_types=1);

describe('Sign In Page', function (): void {

    test('can be rendered', function (): void {

        visit(route('tenantforge.sign-in', absolute: false))
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Remember Me')
            ->assertSee(__('tenantforge::auth.sign_in'))
            ->assertSee(__('tenantforge::auth.dont_have_an_account'));

    });

});
