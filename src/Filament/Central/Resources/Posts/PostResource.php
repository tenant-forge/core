<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts;

use Exception;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Filament\Central\Resources\Posts\Pages\CreatePost;
use TenantForge\Filament\Central\Resources\Posts\Pages\EditPost;
use TenantForge\Filament\Central\Resources\Posts\Pages\ListPosts;
use TenantForge\Filament\Central\Resources\Posts\Schemas\PostForm;
use TenantForge\Filament\Central\Resources\Posts\Tables\PostsTable;
use TenantForge\Models\Post;
use TenantForge\Models\PostType;

use function abort;
use function array_key_exists;
use function request;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getPluralModelLabel(): string
    {

        return static::getPostType()
            ->plural_name;

    }

    public static function getModelLabel(): string
    {
        return static::getPostType()
            ->name;

    }

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {

        return PostForm::configure(schema: $schema);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return PostsTable::configure(
            table: $table,
            postType: static::getPostType()
        );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('Content');
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return 'content';
    }

    public static function getNavigationUrl(): string
    {
        return static::getUrl(parameters: ['type' => 'pages']);
    }

    public static function getUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {

        if (! array_key_exists('type', $parameters)) {
            $parameters = [
                ...$parameters,
                'type' => request()->route()?->parameter('type') ?? 'posts',
            ];
        }

        return parent::getUrl($name, [...$parameters], $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);

    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/{type}'),
            'create' => CreatePost::route('/{type}/create'),
            'edit' => EditPost::route('/{type}/{record}/edit'),
        ];
    }

    public static function getPostType(): PostType
    {
        /** @var ?PostType $postType */
        $postType = PostType::query()
            ->where('slug', request()->route()?->parameter('type'))
            ->first();

        if (! $postType) {
            abort(404);
        }

        return $postType;
    }
}
