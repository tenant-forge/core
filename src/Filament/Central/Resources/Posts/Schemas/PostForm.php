<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Schemas;

use Exception;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use TenantForge\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HeroBlock;
use TenantForge\Models\PostType;

class PostForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema, PostType $postType): Schema
    {

        return $schema
            ->columns(1)
            ->components([
                Flex::make([
                    Section::make()
                        ->schema([
                            TextInput::make('title'),
                            TextInput::make('slug'),
                            FileUpload::make('featured_image')
                                ->directory('posts')
                                ->disk('public')
                                ->hidden(! $postType->has_featured_image),
                            RichEditor::make('content')
                                ->customBlocks([
                                    HeroBlock::class,
                                ])
                                ->json(),
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
