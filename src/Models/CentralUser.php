<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use TenantForge\Database\Factories\CentralUserFactory;

/**
 * @property-read string $id
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 * @property-read ?Carbon $email_verified_at
 * @property-read string $remember_token
 * @property-read string $global_id
 * @property-read ?Carbon $created_at
 * @property-read ?Carbon $updated_at
 */
final class CentralUser extends User implements Authenticatable, FilamentUser
{
    use CentralConnection;

    /** @use HasFactory<CentralUserFactory> */
    use HasFactory;

    protected $table = 'users';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'global_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
