<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TenantForge\Concerns\InteractsWithTranslations;
use TenantForge\Contracts\Slugable;
use TenantForge\Contracts\Translatable;
use TenantForge\Database\Factories\PostFactory;
use TenantForge\Enums\ContentStatus;

/**
 * @property-read int $id
 * @property-read int $post_type_id
 * @property-read int $language_id
 * @property-read ?int $translation_id
 * @property-read string $title
 * @property-read string $slug
 * @property-read ?string $content
 * @property-read ?string $featured_image
 * @property-read ContentStatus $status
 * @property-read Carbon $published_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read PostType $type
 * @property-read Post $originalTranslation
 * @property-read Collection<int, Post> $translations
 * @property-read Language $language
 */
class Post extends Model implements Slugable, Translatable
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /** @use InteractsWithTranslations<Post, $this> */
    use InteractsWithTranslations;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'published_at',
        'post_type_id',
        'translation_id',
        'parent_id',
        'language_id',
    ];

    /**
     * @return PostFactory<Post>
     */
    public static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    public function casts(): array
    {
        return [
            'content' => 'array',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<PostType, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }
}
