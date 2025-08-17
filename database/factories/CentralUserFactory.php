<?php

declare(strict_types=1);

namespace TenantForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use TenantForge\Models\CentralUser;

final class CentralUserFactory extends Factory
{
    protected $model = CentralUser::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'global_id' => Str::uuid()->toString(),
        ];
    }
}
