<?php

declare(strict_types=1);

namespace TenantForge\Enums;

enum AuthGuard: string
{
    case Web = 'web';
    case WebCentral = 'web_central';

}
