<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Schemas;

use Exception;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->columns(1)
            ->components([
                Flex::make([
                    Section::make()
                        ->schema([
                            TextInput::make('title'),
                            TextInput::make('slug'),
                        ])
                        ->grow(),
                    Section::make()
                        ->schema([
                            DateTimePicker::make('published_at'),
                        ])
                        ->extraAttributes([
                            'style' => 'min-width: 350px; max-width: 350px;',
                        ])
                        ->grow(false),
                ])
                    ->from('md'),
            ]);
    }
}
