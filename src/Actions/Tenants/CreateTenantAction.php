<?php

declare(strict_types=1);

namespace TenantForge\Actions\Tenants;

use Illuminate\Support\Facades\DB;
use TenantForge\Actions\MakeUniqueSlugAction;
use TenantForge\DataObjects\CreateTenantData;
use TenantForge\Models\Tenant;
use Throwable;

use function array_merge;

final readonly class CreateTenantAction
{
    public function __construct(
        private MakeUniqueSlugAction $makeUniqueSlugAction,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(CreateTenantData $data): Tenant
    {

        $slug = $this->makeUniqueSlugAction->handle($data->name, Tenant::class);

        $data = array_merge($data->toArray(), ['slug' => $slug]);

        return DB::transaction(fn (): Tenant => Tenant::query()->create($data));
    }
}
