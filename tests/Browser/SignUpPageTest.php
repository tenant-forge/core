<?php

declare(strict_types=1);

it('shows the register page', function (): void {
    visit('/sign-up')
        ->assertSee('Sign Up');
});
