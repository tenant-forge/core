<?php

declare(strict_types=1);

namespace TenantForge\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('tenants')->truncate();

        /** @var User $userModel */
        $userModel = config('tenantforge.user_model');

        $userModel::query()->create([
            'name' => 'Tenant Forge Demo',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'global_id' => Str::uuid()->toString(),
        ]);

    }
}
