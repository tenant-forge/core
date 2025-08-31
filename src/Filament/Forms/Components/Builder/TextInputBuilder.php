<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TextInputBuilder implements BuilderComponent
{
    public static string $type = 'text-input';

    public function __construct(
        public Field $field,
    ) {}

    public static function make(
        Field $field,
    ): self {
        return new self(
            field: $field,
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
            fn (Builder $component): Action => $this->addTextInputAction($component),
        ];
    }

    public function getAddTextInputActionName(): string
    {
        return 'add-text-input';
    }

    /**
     * @throws Exception
     */
    public function addTextInputAction(Builder $component, ?Action $action = null): Action
    {

        return Action::make($this->getAddTextInputActionName())
            ->label('Text')
            ->modalDescription('Single and multi line text entry')
            ->icon(Heroicon::OutlinedDocumentText)
            ->color('gray')
            ->slideOver()
            ->schema([
                TextInput::make('name'),
                TextInput::make('label'),
                Textarea::make('description')
                    ->cols(5),
                Toggle::make('is_multiline')
                    ->label('Multi-line text'),
            ])
            ->action(function (array $data, Action $action) use ($component): void {

                /** @var array<string, mixed> $state */
                $state = $component->getState();

                $component->state([
                    ...$state,
                    Str::uuid()->toString() => [
                        'component' => static::$type,
                        'name' => $data['name'],
                        'configuration' => [
                            'label' => $data['label'],
                            'description' => $data['description'],
                            'is_multiline' => $data['is_multiline'],
                        ],
                    ],
                ]);

                $component->partiallyRenderAfterStateUpdated();
                $action->cancelParentActions();

            });
    }
}
