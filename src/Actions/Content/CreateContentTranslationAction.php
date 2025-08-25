<?php

declare(strict_types=1);

namespace TenantForge\Actions\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TenantForge\Contracts\Translatable;
use TenantForge\Models\Language;

class CreateContentTranslationAction
{
    /**
     * @param  Translatable<Model, Model, Model, Language>  $model
     */
    public function handle(Translatable $model, Language $language): Model
    {

        return DB::transaction(fn (): Model => $model->makeTranslation($language));

    }
}
