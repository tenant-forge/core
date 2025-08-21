<?php

declare(strict_types=1);

namespace TenantForge\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\RegistrationResponse as FilamentRegistrationResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

use function redirect;
use function route;

final class RegistrationResponse implements FilamentRegistrationResponse
{
    /**
     * @phpstan-ignore-next-line
     */
    public function toResponse($request): RedirectResponse|Redirector // @pest-ignore-type
    {

        return redirect()->intended(route('tenantforge.onboarding.tenant'));

    }
}
