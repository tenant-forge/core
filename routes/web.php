<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TenantForge\Filament\Central\Pages\Auth\Login;
use TenantForge\Filament\Central\Pages\Auth\Register;
use TenantForge\Filament\Central\Pages\Onboarding\TenantOnboarding;
use TenantForge\Http\Controllers\Central\HomePageController;
use TenantForge\Http\Middleware\HandleBladeRequests;

Route::middleware(['web', HandleBladeRequests::class])->group(function () {

    Route::get('/', [HomePageController::class, 'index'])
        ->name('tenantforge.home');

    Route::get('/sign-up', Register::class)
        ->name('tenantforge.sign-up');

    Route::get('/sign-in', Login::class)
        ->name('tenantforge.sign-in');

    Route::redirect('/login', '/sign-in')
        ->name('login');

    Route::middleware(['auth:web_central'])->group(function () {

        Route::get('/onboarding/tenant', TenantOnboarding::class)
            ->name('tenantforge.onboarding.tenant');

    });

});
