<?php

declare(strict_types=1);

namespace TenantForge\Database\Seeders;

use Illuminate\Database\Seeder;
use TenantForge\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Language::query()->create([
            'locale' => 'es',
            'name' => 'Spanish',
            'is_default' => false,
            'is_active' => true,
        ]);

        Language::query()->create([
            'locale' => 'pt',
            'name' => 'Portuguese',
            'is_default' => false,
            'is_active' => true,
        ]);

        Language::query()->create([
            'locale' => 'pt_BR',
            'name' => 'Portuguese (Brazil)',
            'is_default' => false,
            'is_active' => true,
        ]);
    }
}
