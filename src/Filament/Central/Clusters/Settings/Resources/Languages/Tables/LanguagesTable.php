<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Tables;

use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use TenantForge\Actions\Languages\SetDefaultLanguageAction;
use TenantForge\Models\Language;

class LanguagesTable
{
    /**
     * @throws Exception
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('locale')
                    ->label(__('Locale'))
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('default')
                    ->label(__('Default'))
                    ->disabled(fn (Language $record): bool => $record->is_default || ! $record->is_active)
                    ->updateStateUsing(function (Language $record, SetDefaultLanguageAction $action): void {

                        $action->handle($record->locale);

                    }),

                ToggleColumn::make('is_active')
                    ->disabled(fn (Language $record) => $record->is_default),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
