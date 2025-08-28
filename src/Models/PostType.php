<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Database\Factories\PostTypeFactory;

/**
 * @property-read int $id
 * @property-read  string $name
 * @property-read  string $plural_name
 * @property-read string $slug
 * @property-read Heroicon $icon
 * @property-read string $description
 * @property-read int $sort
 * @property-read bool $is_active
 * @property-read bool $is_system
 * @property-read bool $has_featured_image
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class PostType extends Model
{
    /** @use HasFactory<PostTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'plural_name',
        'icon',
        'description',
        'sort',
        'is_active',
        'is_system',
        'has_featured_image',
    ];

    /**
     * @return PostTypeFactory<PostType>
     */
    public static function newFactory(): PostTypeFactory
    {
        return PostTypeFactory::new();
    }

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            'is_active' => 'bool',
            'icon' => Heroicon::class,
        ];
    }
}
