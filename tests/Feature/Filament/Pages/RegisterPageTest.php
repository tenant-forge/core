<?php

it('shows the register page', function (): void {

    $response = $this->get(route('tenantforge.sign-up'));

    $response->assertStatus(200);
});
