<?php

declare(strict_types=1);

namespace TenantForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use TenantForge\Enums\ContentStatus;
use TenantForge\Models\Language;
use TenantForge\Models\Post;
use TenantForge\Models\PostType;

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
            'language_id' => Language::factory(),
            'title' => $title = Str::title(fake()->unique()->title),
            'slug' => Str::slug($title),
            'status' => fake()->randomElement(ContentStatus::cases()),
        ];
    }

    /**
     * @return PostFactory<Post>
     */
    public function page(): self
    {
        return $this->state(fn (array $attributes): array => [
            'post_type_id' => PostType::query()
                ->where('slug', 'pages')
                ->first()?->id,
        ]);
    }

    /**
     * @return PostFactory<Post>
     */
    public function post(): self
    {
        return $this->state(fn (array $attributes): array => [
            'post_type_id' => PostType::query()
                ->where('slug', 'posts')
                ->first()?->id,
        ]);
    }
}
