<?php

// config for TenantForge
return [

    'title' => env('TENANT_FORGE_TITLE', 'TenantForge'),
    /** @phpstan-ignore-next-line  */
    'user_model' => env('TENANT_FORGE_USER_MODEL', App\Models\User::class),

];
