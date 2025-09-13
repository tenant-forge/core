<?php

declare(strict_types=1);

namespace TenantForge\Livewire\FormBuilder\Layout;

use Illuminate\View\View;
use Livewire\Component;

class Section extends Component
{
    public function render(): View
    {
        return view('tenantforge::livewire.form-builder.layout.section');
    }
}
