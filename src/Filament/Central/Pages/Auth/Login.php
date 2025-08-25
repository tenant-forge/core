<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as FilamentLogin;
use Livewire\Attributes\Layout;
use TenantForge\Settings\AppSettings;
use TenantForge\View\Components\TenantForge;

use function __;

#[Layout(TenantForge::class)]
final class Login extends FilamentLogin
{
    public ?string $description = null;

    public string $appName;

    protected string $view = 'tenantforge::filament.central.pages.auth.login';

    public function boot(AppSettings $appSettings): void
    {
        $this->appName = $appSettings->name;
        $this->description = $appSettings->about;
    }

    public function dontHaveAnAccountAction(): Action
    {
        return Action::make('sign-up')
            ->label(__('tenantforge::auth.sign_up'))
            ->extraAttributes([
                'data-test' => 'sign-up',
            ])
            ->link()
            ->url(route('tenantforge.sign-up'));
    }

    protected function getAuthenticateFormAction(): Action
    {
        $action = parent::getAuthenticateFormAction();

        $action->extraAttributes([
            'data-test' => 'sign-in',
        ]);

        return $action;
    }
}
