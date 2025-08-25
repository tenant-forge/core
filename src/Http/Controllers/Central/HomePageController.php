<?php

declare(strict_types=1);

namespace TenantForge\Http\Controllers\Central;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use TenantForge\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HeroBlock;
use TenantForge\Models\Post;

class HomePageController
{
    public function index(): View
    {

        /** @var Post $page */
        $page = Post::query()
            ->where('post_type_id', 2)
            ->where('slug', 'home')
            ->first();

        $content = $page ? RichContentRenderer::make($page->content)
            ->customBlocks([
                HeroBlock::class,
            ])
            ->toHtml()
        : null;

        return view('tenantforge::central.home', [
            'title' => 'Hello Mundo',
            'description' => 'Description',
            'content' => $content,
        ]);
    }
}
