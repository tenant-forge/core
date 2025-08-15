<?php

declare(strict_types=1);

namespace TenantForge\Filament\Pages\Auth;

use Filament\Pages\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use TenantForge\View\Components\TenantForge;

#[Layout(TenantForge::class)]
#[Title('Sign Up')]
final class Register extends Page
{
    public static ?string $title = 'Sign Up';

    public string $description = 'Hello Mundo!';

    protected string $view = 'tenantforge::filament.pages.auth.register';
}
