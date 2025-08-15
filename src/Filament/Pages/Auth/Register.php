<?php

namespace TenantForge\Filament\Pages\Auth;

use Filament\Pages\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use TenantForge\View\Components\TenantForge;

#[Layout(TenantForge::class)]
#[Title('Sign Up')]
class Register extends Page
{
    protected string $view = 'tenantforge::filament.pages.auth.register';

    public static ?string $title = 'Sign Up';

    public string $description = 'Hello Mundo!';
}
