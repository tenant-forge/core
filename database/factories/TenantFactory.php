<?php

namespace TenantForge\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TenantForge\Core\Models\Tenant;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'domain' => fake()->unique()->domainName(),
            'email' => fake()->unique()->safeEmail(),
            'stripe_id' => fake()->optional()->regexify('cus_[A-Za-z0-9]{14}'),
            'data' => [
                'settings' => [
                    'theme' => fake()->randomElement(['light', 'dark']),
                    'timezone' => fake()->timezone(),
                ],
                'features' => fake()->randomElements(['analytics', 'reporting', 'api_access'], fake()->numberBetween(0, 3)),
            ],
        ];
    }
}
