<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use TenantForge\Contracts\Slugable;
use TenantForge\Database\Factories\TenantFactory;

/**
 * @property-read string $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string $domain
 * @property-read string $email
 * @property-read ?string $stripe_id
 * @property-read array<string, mixed> $data
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @method static TenantFactory factory(...$parameters)
 * @method HasMany<Domain, Tenant> domains();
 */
final class Tenant extends BaseTenant implements Slugable, TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;

    /** @use HasFactory<TenantFactory> */
    use HasFactory;

    use HasUuids;

    /**
     * @return string[]
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'slug',
            'domain',
            'email',
            'stripe_id',
            'created_at',
        ];
    }

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
