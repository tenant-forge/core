<?php

declare(strict_types=1);

namespace TenantForge\Actions\Users;

use Illuminate\Support\Facades\DB;
use TenantForge\DataObjects\CentraUserData;
use TenantForge\Models\CentralUser;
use Throwable;

final class CreateCentralUserAction
{
    /**
     * @throws Throwable
     */
    public function handle(CentraUserData $data): CentralUser
    {
        return DB::transaction(function () use ($data): CentralUser {
            return CentralUser::query()
                ->create($data->toArray());
        });
    }
}
