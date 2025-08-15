<?php

declare(strict_types=1);

it('shows the register page', function (): void {

    $response = $this->get(route('tenantforge.sign-up'));

    $response->assertStatus(200);
});
