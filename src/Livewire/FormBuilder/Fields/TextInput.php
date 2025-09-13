<?php

declare(strict_types=1);

namespace TenantForge\Livewire\FormBuilder\Fields;

use Illuminate\View\View;
use Livewire\Component;

class TextInput extends Component
{
    public function render(): View
    {
        return view('tenantforge::livewire.form-builder.fields.text-input');
    }
}
