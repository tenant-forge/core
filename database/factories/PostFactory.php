<?php

declare(strict_types=1);

namespace TenantForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TenantForge\Models\Post;

/**
 * @template TModel of Post
 *
 * @extends Factory<TModel>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Post::class;

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
