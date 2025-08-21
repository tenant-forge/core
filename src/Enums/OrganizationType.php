<?php

declare(strict_types=1);

namespace TenantForge\Enums;

use Filament\Support\Contracts\HasLabel;

use function __;

enum OrganizationType: string implements HasLabel
{
    case Company = 'Company';
    case Individual = 'Individual';

    public function getLabel(): string
    {
        return match ($this) {
            self::Company => __('tenantforge::enums.organization_type.company'),
            self::Individual => __('tenantforge::enums.organization_type.individual'),
        };
    }
}
