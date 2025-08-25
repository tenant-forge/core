<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
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
                TextInput::make('heading')
                    ->required(),
                Textarea::make('subheading')
                    ->rows(5)
                    ->required(),

            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('tenantforge::filament.forms.components.rich-editor.custom-blocks.hero.preview', [
            'heading' => $config['heading'] ?? 'Hero',
            'subheading' => $config['subheading'] ?? 'Subheading',
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('tenantforge::filament.forms.components.rich-editor.custom-blocks.hero.index', [
            'heading' => $config['heading'] ?? 'Hero',
            'subheading' => $config['subheading'] ?? 'Subheading',
        ])->render();
    }
}
