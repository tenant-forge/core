<?php

use Illuminate\Support\Facades\Route;
use TenantForge\Filament\Pages\Auth\Register;

Route::get('/', function () {
    return 'Hello World!';
});

Route::get('/sign-up', Register::class)
    ->name('tenantforge.sign-up');
