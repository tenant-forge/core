<?php

declare(strict_types=1);

namespace TenantForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TenantForge\Models\PostType;

/**
 * @template TModel of PostType
 *
 * @extends Factory<TModel>
 */
class PostTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = PostType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
