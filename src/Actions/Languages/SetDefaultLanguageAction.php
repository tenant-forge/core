<?php

declare(strict_types=1);

namespace TenantForge\Actions\Languages;

use Illuminate\Support\Facades\DB;
use TenantForge\Models\Language;

class SetDefaultLanguageAction
{
    public static function handle(string $locale): void
    {
        DB::transaction(function () use ($locale): void {
            Language::query()
                ->where('locale', $locale)
                ->update([
                    'is_default' => true,
                ]);

            Language::query()
                ->whereNot('locale', $locale)
                ->update([
                    'is_default' => false,
                ]);

        });
    }
}
