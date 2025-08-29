<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Schemas;

use Exception;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LanguageForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->maxLength(30)
                    ->required(),
                TextInput::make('locale')
                    ->maxLength(5)
                    ->required(),
            ]);
    }
}
