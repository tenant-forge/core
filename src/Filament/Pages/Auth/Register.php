<?php

declare(strict_types=1);

namespace TenantForge\Filament\Pages\Auth;

use Exception;
use Filament\Auth\Pages\Register as FilamentRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use TenantForge\Actions\Users\CreateCentralUserAction;
use TenantForge\DataObjects\CentraUserData;
use TenantForge\Settings\AppSettings;
use TenantForge\View\Components\TenantForge;
use Throwable;

use function __;
use function filament;

#[Layout(TenantForge::class)]
#[Title('Sign Up')]
final class Register extends FilamentRegister
{
    public static ?string $title = 'Sign Up';

    public string $description = 'Hello Mundo!';

    public string $appName;

    protected string $view = 'tenantforge::filament.pages.auth.register';

    private CreateCentralUserAction $createCentralUserAction;

    public function boot(
        AppSettings $appSettings,
        CreateCentralUserAction $createCentralUserAction,
    ): void {
        $this->appName = $appSettings->name;
        $this->createCentralUserAction = $createCentralUserAction;
    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }

    /**
     * @throws Throwable
     */
    protected function handleRegistration(array $data): Model
    {
        $data = CentraUserData::from($data);

        return $this->createCentralUserAction->handle($data);
    }

    /**
     * @throws Exception
     */
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::auth/pages/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->showAllValidationMessages()
            ->dehydrateStateUsing(fn (string $state) => Hash::make($state))
            ->validationAttribute(__('filament-panels::auth/pages/register.form.password.validation_attribute'));
    }
}
