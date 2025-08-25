<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use TenantForge\Filament\Central\Resources\Posts\PostResource;
use TenantForge\Models\CentralUser;
use TenantForge\Models\Language;
use TenantForge\Models\Post;

describe('view missing translations', function (): void {

    test('user must see the missing translations on language selector', function (): void {

        // Arrange
        /** @var Language $english */
        $english = Language::query()->where('locale', 'en')->first();

        Language::factory()->create([
            'name' => 'Portuguese',
            'locale' => 'pt',
        ]);

        Language::factory()->create([
            'name' => 'French',
            'locale' => 'fr',
        ]);

        /** @var Collection<int, Post> $posts */
        $posts = Post::factory()
            ->for($english, 'language')
            ->count(10)
            ->post()
            ->create([
                'content' => 'Hello World',
            ])
            ->fresh();

        /** @var CentralUser $user */
        $user = CentralUser::factory()->create([
            'email' => 'me@example.com',
            'password' => Hash::make('password'),
        ]);

        visit(route('login', absolute: false))
            ->type('form.email', $user->email)
            ->type('form.password', 'password')
            ->press('@sign-in')
            ->assertSee('Dashboard')
            ->assertSee('Posts');

        /** @var Post $firstPost */
        $firstPost = $posts->first();

        visit(PostResource::getUrl(parameters: ['type' => 'posts'], isAbsolute: false))
            ->wait(1)
            ->assertSee($firstPost->title)
            ->click($firstPost->title)
            ->assertSee('EN')
            ->pressAndWaitFor('@language-selector', 1)
            ->assertSee(__('Missing'))
            ->assertSee('Portuguese')
            ->assertSee('French');

    });

});
