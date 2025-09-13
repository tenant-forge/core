<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Contracts\HasExtraItemActions;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\View;

use function collect;
use function view;

class Builder extends Field implements HasExtraItemActions
{
    use Concerns\HasExtraItemActions;

    protected string $view = 'tenantforge::filament.forms.components.builder.index';

    protected BuilderRegistry $builderRegistry;

    /**
     * @var array<int, Closure>
     */
    protected array $fieldTypes;

    /**
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        $this->builderRegistry = app()->make(BuilderRegistry::class);
        parent::setUp();

        $this->afterStateHydrated(static function (Builder $component, ?array $rawState, BuilderRegistry $builderRegistry): void {

            $rawState = $component->getRawState();

        });

        $components = collect($this->builderRegistry::components());

        /** @var array<int, Closure> $actions */
        $actions = $components->flatMap(function (string $componentClass, string $key): array {
            $builderComponent = $this->builderRegistry->getBuilderComponent($this, $key);

            return $builderComponent->getActions($this);

        })->toArray();

        $this->fieldTypes = $actions;

        $this->registerActions([
            fn (Builder $component): Action => $component->newComponentAction(),
            fn (Builder $component): Action => $component->deleteComponentAction(),

        ]);
        $this->registerActions($actions);

    }

    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     *                                                                                                                       /
     * @throws BindingResolutionException
     */
    public function renderComponent(string $type, ?array $state): View
    {
        return $this->builderRegistry->getBuilderComponent($this, $type, $state)
            ->render();
    }

    public function getDeleteActionName(): string
    {
        return 'delete-component';
    }

    public function deleteComponentAction(): Action
    {
        return Action::make($this->getDeleteActionName())
            ->hiddenLabel()
            ->icon(Heroicon::Trash)
            ->color('gray')
            ->slideOver()
            ->action(function (array $arguments, Builder $component): void {
                /** @var array<string, mixed> $items */
                $items = $component->getRawState();
                unset($items[$arguments['item']]);

                $component->rawState($items);

                $component->partiallyRender();

            });
    }

    public function getAddSectionActionName(): string
    {
        return 'add-section-component';
    }

    public function getNewComponentActionName(): string
    {
        return 'add-component';
    }

    /**
     * @throws Exception
     */
    public function newComponentAction(?string $hello = null): Action
    {

        return Action::make($this->getNewComponentActionName())
            ->label('Add custom field')
            ->icon(Heroicon::PlusCircle)
            ->color('gray')
            ->slideOver()
            ->modalHeading('Field types')
            ->modalWidth(Width::Medium)
            ->modalContent(function (array $arguments): View {

                $data = [
                    'fieldTypes' => $this->fieldTypes,
                    'component' => $this,
                    'parent' => $arguments['parent'],
                ];

                return view('tenantforge::filament.forms.components.builder.add-component', $data);

            })
            ->modalCancelAction(false)
            ->modalSubmitAction(false);
    }
}
