<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SectionBuilder implements BuilderComponent
{
    public static string $type = 'section';

    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     */
    public function __construct(
        public Field $field,
        public ?string $name = null,
        public ?array $state = null,
        public ?BuilderComponent $parentComponent = null,
    ) {}

    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     */
    public static function make(Field $field, ?string $name = null, ?string $schemaPath = null, ?array $state = null, ?BuilderComponent $parentComponent = null): self
    {
        return new self(
            field: $field,
            name: $name,
            state: $state,
            parentComponent: $parentComponent,
        );

    }

    /**
     * @throws Exception
     */
    public function render(): View
    {
        return view('tenantforge::filament.forms.components.builder.section', [
            'name' => 'Section',
        ]);
    }

    /**
     * @return array{Closure(Builder $component): Action}
     */
    public function getActions(Builder $component): array
    {
        return [
            fn (Builder $component): Action => $this->addSectionAction($component),
        ];
    }

    public function getAddSectionActionName(): string
    {
        return 'add-section-component';
    }

    /**
     * @throws Exception
     */
    public function addSectionAction(Builder $component, ?BuilderComponent $parentComponent = null): Action
    {

        return Action::make($this->getAddSectionActionName())
            ->label('Section')
            ->icon(Heroicon::PlusCircle)
            ->color('gray')
            ->slideOver()
            ->schema([
                TextInput::make('name'),
            ])
            ->action(function (array $data, Action $action) use ($component): void {

                /** @var array<string, mixed> $state */
                $state = $component->getState() ?? [];

                $component->state([
                    ...$state,
                    Str::uuid()->toString() => [
                        'component' => 'section',
                        'name' => $data['name'],
                        'configuration' => [
                            'label' => $data['name'],
                            'description' => 'This is the description',
                        ],
                    ],
                ]);

                $component->partiallyRenderAfterStateUpdated();
                $action->cancelParentActions();

            });
    }
}
