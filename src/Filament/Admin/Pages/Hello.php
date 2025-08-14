<?php

namespace TenantForge\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Hello extends Page
{
    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'hello/{person}';

    protected string $view = 'tenantforge::filament.admin.pages.hello';
}
