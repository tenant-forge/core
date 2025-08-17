<?php

declare(strict_types=1);

// config for TenantForge
return [

    'title' => env('TENANT_FORGE_TITLE', 'TenantForge'),
    /** @phpstan-ignore-next-line  */
    'user_model' => env('TENANT_FORGE_USER_MODEL', App\Models\User::class),
    'central_user_model' => env('TENANT_FORGE_CENTRAL_USER_MODEL', TenantForge\Models\CentralUser::class),

];
