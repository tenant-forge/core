<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TenantForge\Filament\Central\Pages\Auth\Login;
use TenantForge\Filament\Central\Pages\Auth\Register;
use TenantForge\Filament\Central\Pages\Onboarding\TenantOnboarding;

Route::get('/sign-up', Register::class)
    ->name('tenantforge.sign-up');

Route::redirect('/login', '/sign-in')
    ->name('login');

Route::get('/sign-in', Login::class)
    ->name('tenantforge.sign-in');

Route::middleware(['auth:web_central'])->get('/onboarding/tenant', TenantOnboarding::class)
    ->name('tenantforge.onboarding.tenant');
