<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Schemas;

use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use TenantForge\Filament\Forms\Components\Builder\Builder;

use function collect;

class PostTypeForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make()
                    ->tabs([
                        Tabs\Tab::make('Custom Fields')
                            ->components([
                                Builder::make('custom_fields')
                                    ->hiddenLabel(true),
                            ]),
                        Tabs\Tab::make('General')
                            ->components([
                                Flex::make([
                                    Section::make()
                                        ->components([
                                            TextInput::make('name')
                                                ->required(),
                                            TextInput::make('slug')
                                                ->required(),
                                            TextInput::make('plural_name')
                                                ->required(),
                                            Textarea::make('description'),
                                        ]),
                                    Section::make()
                                        ->grow(false)
                                        ->components([
                                            Select::make('icon')
                                                ->native(false)
                                                ->searchable()
                                                ->options(function () {

                                                    $collection = collect(Heroicon::cases());

                                                    return $collection->mapWithKeys(fn (Heroicon $icon) => [$icon->value => Blade::render('<div class="flex items-center gap-1.5"><x-filament::icon :icon="$icon" :size="$size" color="gray"/> <span>{{ $name }}</span></div>', ['icon' => $icon, 'size' => IconSize::Medium, 'name' => Str::replace('-', ' ', Str::title(Str::of($icon->name)->kebab()->toString()))])]);

                                                })
                                                ->allowHtml(),
                                            Toggle::make('is_active')
                                                ->required(),
                                            Toggle::make('is_system')
                                                ->required(),
                                            Toggle::make('has_featured_image')
                                                ->required(),
                                            TextInput::make('sort')
                                                ->numeric()
                                                ->required(),
                                        ]),
                                ]),
                            ]),
                    ]),

            ]);
    }
}
