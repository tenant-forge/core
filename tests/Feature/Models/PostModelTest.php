<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use TenantForge\Models\Language;
use TenantForge\Models\Post;
use TenantForge\Models\PostType;

beforeEach(function (): void {

    $this->language = Language::query()
        ->where('locale', 'en')
        ->first();

});

describe('Post model test', function (): void {

    test('one post can only have one translation for each language', function (): void {})->todo();

    test('posts have a post type relation', function (): void {

        // Arrange
        /** @var PostType $postType */
        $postType = PostType::query()
            ->where('slug', 'posts')
            ->first();

        /** @var Post $post */
        $post = Post::factory()
            ->for($this->language)
            ->for($postType, 'type')
            ->create()
            ->fresh();

        expect($post->type)
            ->toBeInstanceOf(PostType::class)
            ->and($post->type->slug)
            ->toBe('posts');

    });
    test('can have a translation in portuguese', function (): void {

        // Arrange

        /** @var Language $language */
        $language = Language::factory()
            ->createQuietly([
                'name' => 'Portuguese',
                'locale' => 'pt',
            ])
            ->fresh();

        /** @var Post $post */
        $post = Post::factory()
            ->post()
            ->createQuietly()
            ->fresh();

        Post::factory()
            ->post()
            ->for($post, 'originalTranslation')
            ->for($language, 'language')
            ->createQuietly([
                'title' => $title = Str::title('Este é o meu artigo traduzido'),
                'slug' => Str::slug($title),
            ])
            ->fresh();

        /** @var Post $translationFromDatabase */
        $translationFromDatabase = $post->translations()
            ->where('language_id', $language->id)
            ->first();

        expect($translationFromDatabase->title)
            ->toBe($title)
            ->and($translationFromDatabase->slug)
            ->toBe(Str::slug($title))
            ->and($post->translations()->count())
            ->toBe(1);

    });

    test('to array', function (): void {

        /** @var Post $post */
        $post = Post::factory()
            ->post()
            ->createQuietly()
            ->fresh();

        expect(array_keys($post->toArray()))
            ->toBe([
                'id',
                'post_type_id',
                'translation_id',
                'parent_id',
                'language_id',
                'title',
                'slug',
                'content',
                'featured_image',
                'status',
                'published_at',
                'created_at',
                'updated_at',
            ]);

    });

});
