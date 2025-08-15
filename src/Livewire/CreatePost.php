<?php

namespace TenantForge\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('tenantforge::components.app')]
class CreatePost extends Component
{
    public function render(): View
    {
        return view('tenantforge::livewire.create-post');
    }
}
