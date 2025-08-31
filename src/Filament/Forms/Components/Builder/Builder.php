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
            ...$actions,
            fn (Builder $component): Action => $component->newComponentAction(),
            fn (Builder $component): Action => $component->deleteComponentAction(),

        ]);

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
    public function newComponentAction(): Action
    {
        return Action::make('add-component')
            ->label('Add custom field')
            ->icon(Heroicon::PlusCircle)
            ->color('gray')
            ->slideOver()
            ->modalHeading('Field types')
            ->modalWidth(Width::Medium)
            ->modalContent(view('tenantforge::filament.forms.components.builder.add-component', [
                'fieldTypes' => $this->fieldTypes,
                'component' => $this,
            ]))
            ->modalCancelAction(false)
            ->modalSubmitAction(false);
    }
}
