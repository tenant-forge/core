<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Tables;

use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TenantForge\Models\PostType;

class PostsTable
{
    /**
     * @throws Exception
     */
    public static function configure(Table $table, PostType $postType): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) use ($postType): void {
                $query->where('post_type_id', $postType->id);
            })
            ->columns([
                TextColumn::make('title')
                    ->limit(50),
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
