<?php

declare(strict_types=1);

namespace TenantForge\Actions\Tenants;

use Illuminate\Support\Facades\DB;
use TenantForge\Actions\MakeDomainFromSlugAction;
use TenantForge\Actions\MakeUniqueSlugAction;
use TenantForge\DataObjects\CreateTenantData;
use TenantForge\Models\Tenant;
use Throwable;

use function array_merge;

final readonly class CreateTenantAction
{
    public function __construct(
        private MakeUniqueSlugAction $makeUniqueSlugAction,
        private MakeDomainFromSlugAction $makeDomainFromSlugAction,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(CreateTenantData $data): Tenant
    {

        $slug = $this->makeUniqueSlugAction->handle($data->name, Tenant::class);

        $data = array_merge($data->toArray(), ['slug' => $slug]);

        if ($data['domain'] === null) {
            $data['domain'] = $this->makeDomainFromSlugAction->handle($slug);
        }

        $tenant = DB::transaction(fn (): Tenant => Tenant::query()->create($data));

        $tenant->domains()->create([
            'domain' => $data['domain'],
        ]);

        return $tenant->refresh();
    }
}
