<?php

declare(strict_types=1);

namespace TenantForge\Livewire\FormBuilder;

use Illuminate\View\View;
use Livewire\Component;

class Builder extends Component
{
    public function render(): View
    {
        return view('tenantforge::livewire.form-builder.builder');
    }
}
