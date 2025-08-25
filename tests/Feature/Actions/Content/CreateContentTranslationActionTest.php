<?php

declare(strict_types=1);

use TenantForge\Actions\Content\CreateContentTranslationAction;
use TenantForge\Models\Language;
use TenantForge\Models\Post;

beforeEach(function (): void {

    $this->portuguese = Language::factory()
        ->createQuietly([
            'name' => 'Portuguese',
            'locale' => 'pt',
        ])
        ->fresh();

});

describe('create content translation action', function (): void {

    test('it creates a new translation version of the post', function (): void {

        assert(property_exists($this, 'portuguese'));

        /** @var Post $post */
        $post = Post::factory()
            ->post()
            ->createQuietly();

        $action = new CreateContentTranslationAction();

        /** @var Post $translation */
        $translation = $action->handle($post, $this->portuguese);

        expect($translation)
            ->toBeInstanceOf(Post::class)
            ->and($translation->language->id)
            ->toBe($this->portuguese->id);

    });

});
