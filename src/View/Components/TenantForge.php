<?php

namespace TenantForge\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

use function config;

class TenantForge extends Component
{
    public function render(): View
    {
        return view('tenantforge::components.tenantforge', [
            'title' => config()->string('tenantforge.title'),
            'description' => 'TenantForge is a multi-tenant application built with Laravel and Filament.',
        ]);
    }
}
