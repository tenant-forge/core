<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Pages\Onboarding;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use TenantForge\Actions\Tenants\CreateTenantAction;
use TenantForge\DataObjects\CreateTenantData;
use TenantForge\Enums\AuthGuard;
use TenantForge\Enums\OrganizationType;
use TenantForge\Models\CentralUser;
use TenantForge\Models\Tenant;
use TenantForge\Settings\AppSettings;
use TenantForge\View\Components\TenantForge;
use Throwable;

use function abort;
use function auth;

/**
 * @property Schema $form
 */
#[Layout(TenantForge::class)]
#[Title('Tenant Onboarding')]
final class TenantOnboarding extends Page implements HasSchemas
{
    public ?string $description = null;

    public string $appName;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    protected string $view = 'tenantforge::filament.central.pages.onboarding.tenant';

    private CreateTenantAction $createTenantAction;

    private ?CentralUser $centralUser = null;

    public function boot(
        AppSettings $appSettings,
        CreateTenantAction $createTenantAction
    ): void {

        $this->centralUser = auth()
            ->guard(AuthGuard::WebCentral->value)
            ->user();

        if (! $this->centralUser instanceof CentralUser) {
            abort(403);
        }

        $this->appName = $appSettings->name;
        $this->description = $appSettings->about;

        $this->createTenantAction = $createTenantAction;

    }

    public function mount(): void
    {

        $this->form->fill([
            'email' => $this->centralUser?->email,
        ]);

    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('tenantforge::tenants.fields.name'))
                    ->autofocus()
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->label(__('tenantforge::tenants.fields.email'))
                    ->email()
                    ->required(),
                Select::make('type')
                    ->label(__('tenantforge::tenants.fields.type'))
                    ->native(false)
                    ->options(OrganizationType::class),
            ])
            ->model(Tenant::class)
            ->statePath('data');
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('onboardTenant')
            ->footer([
                Actions::make([
                    Action::make('onboardTenant')
                        ->label(__('tenantforge::tenants.actions.create'))
                        ->submit('form'),
                ])
                    ->fullWidth(),
            ]);
    }

    /**
     * @throws Throwable
     */
    public function onboardTenant(): void
    {

        $state = $this->form->getState();

        $tenant = $this->createTenantAction->handle(
            CreateTenantData::from($state),
        );

        Notification::make('tenant-created')
            ->success()
            ->title("Tenant {$tenant->name} has been created.")
            ->send();

    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                RenderHook::make(PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE),
                $this->getFormContentComponent(),
                RenderHook::make(PanelsRenderHook::AUTH_REGISTER_FORM_AFTER),
            ]);
    }
}
