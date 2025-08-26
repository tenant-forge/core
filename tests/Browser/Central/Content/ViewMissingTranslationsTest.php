<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use TenantForge\Enums\AuthGuard;
use TenantForge\Filament\Central\Resources\Posts\PostResource;
use TenantForge\Models\CentralUser;
use TenantForge\Models\Language;
use TenantForge\Models\Post;

use function Pest\Laravel\actingAs;

beforeEach(function () {

    // Arrange

    $this->centralUser = CentralUser::factory()->create([
        'email' => 'me@example.com',
        'password' => Hash::make('password'),
    ]);

    /** @var Language $english */
    $english = Language::query()
        ->where('locale', 'en')
        ->first();

    Language::factory()->create([
        'name' => 'Portuguese',
        'locale' => 'pt',
    ]);

    Language::factory()->create([
        'name' => 'French',
        'locale' => 'fr',
    ]);

    Post::factory()
        ->for($english, 'language')
        ->post()
        ->create([
            'title' => $title = 'Hello Mundo!',
            'slug' => Str::slug($title),
            'content' => 'Hello World',
        ])
        ->fresh();

    Post::factory()
        ->for($english, 'language')
        ->count(10)
        ->post()
        ->create([
            'content' => 'Hello World',
        ])
        ->fresh();

});

describe('view missing translations', function (): void {

    test('user must see the missing translations on language selector', function (): void {

        actingAs($this->centralUser, AuthGuard::WebCentral->value)
            ->visit(PostResource::getUrl(parameters: ['type' => 'posts'], isAbsolute: false))
            ->assertSee('Hello Mundo!')
            ->click('Hello Mundo!')
            ->assertSee('EN')
            ->pressAndWaitFor('@language-selector', 1)
            ->assertSee(__('Missing'))
            ->assertSee('Portuguese')
            ->assertSee('French');

    });

});
