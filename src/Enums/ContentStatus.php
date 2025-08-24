<?php

declare(strict_types=1);

namespace TenantForge\Enums;

enum ContentStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case TRASHED = 'trashed';

}
