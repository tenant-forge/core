<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SectionBuilder extends Component implements BuilderComponent
{
    public static string $type = 'section';

    public static bool $hasChildren = true;

    /**
     * @throws Exception
     */
    public function render(): View
    {
        return view('tenantforge::filament.forms.components.builder.section', [
            'field' => $this->field,
            'name' => $this->state ? $this->state['name'] : 'Section',
            'schemaPath' => $this->state ? $this->state['schemaPath'] : null,
            'configuration' => $this->state ? $this->state['configuration'] : [],
            'hasChildren' => static::$hasChildren,
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
    public function addSectionAction(Builder $component): Action
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
                        'component' => static::$type,
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
