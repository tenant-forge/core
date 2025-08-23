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
            'locale' => 'en',
            'name' => 'English',
            'default' => true,
            'active' => true,
        ]);

        Language::query()->create([
            'locale' => 'es',
            'name' => 'Spanish',
            'default' => false,
            'active' => true,
        ]);

        Language::query()->create([
            'locale' => 'pt',
            'name' => 'Portuguese',
            'default' => false,
            'active' => true,
        ]);

        Language::query()->create([
            'locale' => 'pt_BR',
            'name' => 'Portuguese (Brazil)',
            'default' => false,
            'active' => true,
        ]);
    }
}
