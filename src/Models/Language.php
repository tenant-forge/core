<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use TenantForge\Database\Factories\LanguageFactory;

/**
 * @property-read int $id
 * @property-read string $locale
 * @property-read string $name
 * @property-read bool $is_default
 * @property-read bool $is_active
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Language extends Model
{
    use CentralConnection;

    /** @use HasFactory<LanguageFactory> */
    use HasFactory;

    protected $fillable = [
        'locale',
        'name',
        'is_default',
        'is_active',
    ];

    /**
     * @return LanguageFactory<Language>
     */
    public static function newFactory(): LanguageFactory
    {
        return LanguageFactory::new();
    }

    /**
     * @return array|string[]
     */
    public function casts(): array
    {
        return [
            'is_default' => 'bool',
            'is_active' => 'bool',
        ];
    }
}
