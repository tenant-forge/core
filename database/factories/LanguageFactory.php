<?php

declare(strict_types=1);

namespace TenantForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TenantForge\Models\Language;

/**
 * @template TModel of Language
 *
 * @extends Factory<TModel>
 */
class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'locale' => fake()->locale(),
            'name' => fake()->name(),
            'default' => fake()->boolean(),
            'active' => fake()->boolean(),
        ];
    }

    /**
     * @return self<Language>
     */
    public function active(): self
    {
        return $this->state(fn (array $attributes): array => [
            'active' => true,
        ]);
    }
}
