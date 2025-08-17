<?php

declare(strict_types=1);

namespace TenantForge\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use TenantForge\Settings\AppSettings;

use function config;

final class TenantForge extends Component
{
    public function __construct(
        private AppSettings $appSettings,
    ) {}

    public function render(): View
    {
        return view('tenantforge::components.tenantforge', [
            'title' => $this->appSettings->name ?: config()->string('tenantforge.title'),
            'description' => $this->appSettings->about,
        ]);
    }
}
