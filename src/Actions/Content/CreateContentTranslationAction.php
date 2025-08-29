<?php

declare(strict_types=1);

namespace TenantForge\Actions\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TenantForge\Contracts\Translatable;
use TenantForge\Models\Language;
use Throwable;

class CreateContentTranslationAction
{
    /**
     * @throws Throwable
     */
    public function handle(Translatable $model, Language $language): Model|Translatable
    {

        return DB::transaction(fn (): Model|Translatable => $model->makeTranslation($language));

    }
}
