<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Schemas;

use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

use function collect;

class PostTypeForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('plural_name')
                    ->required(),
                Select::make('icon')
                    ->native(false)
                    ->searchable()
                    ->options(function () {

                        $collection = collect(Heroicon::cases());

                        return $collection->mapWithKeys(fn (Heroicon $icon) => [$icon->value => Blade::render('<div class="flex items-center gap-1.5"><x-filament::icon :icon="$icon" :size="$size" color="gray"/> <span>{{ $name }}</span></div>', ['icon' => $icon, 'size' => IconSize::Medium, 'name' => Str::replace('-', ' ', Str::title(Str::of($icon->name)->kebab()->toString()))])]);

                    })
                    ->allowHtml(),
                TextInput::make('description'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_system')
                    ->required(),
                Toggle::make('has_featured_image')
                    ->required(),
                TextInput::make('sort')
                    ->numeric()
                    ->required(),
            ]);
    }
}
