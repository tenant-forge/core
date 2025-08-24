<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class HeroBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'hero';
    }

    public static function getLabel(): string
    {
        return 'Hero';
    }

    /**
     * @throws Exception
     */
    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Hero section')
            ->schema([
                TextInput::make('title')
                    ->required(),

            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.hero.preview', [
            //
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.hero.index', [
            //
        ])->render();
    }
}
