<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Database\Factories\TenantFactory;

/**
 * @property-read string $id
 * @property-read string $name
 * @property-read string $domain
 * @property-read string $email
 * @property-read ?string $stripe_id
 * @property-read array<string, mixed> $data
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
final class Tenant extends Model
{
    /** @use HasFactory<TenantFactory> */
    use HasFactory;

    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'domain',
        'email',
        'stripe_id',
        'data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
