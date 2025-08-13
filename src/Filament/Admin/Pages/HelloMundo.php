<?php

namespace TenantForge\Core\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;

class HelloMundo extends Page
{
    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'hello-mundo/{person}';

    protected string $view = 'TenantForge:core.filament.admin.pages.hello-mundo';
}
