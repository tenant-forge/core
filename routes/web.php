<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TenantForge\Filament\Pages\Auth\Register;

Route::get('/sign-up', Register::class)
    ->name('tenantforge.sign-up');
