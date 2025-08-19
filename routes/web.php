<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TenantForge\Filament\Central\Pages\Auth\Login;
use TenantForge\Filament\Central\Pages\Auth\Register;

Route::get('/sign-up', Register::class)
    ->name('tenantforge.sign-up');

Route::get('sign-in', Login::class)
    ->name('tenantforge.sign-in');
