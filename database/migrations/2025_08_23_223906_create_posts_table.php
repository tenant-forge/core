<?php

declare(strict_types=1);

use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use TenantForge\Models\Language;
use TenantForge\Models\PostType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_types', function (Blueprint $table): void {

            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('plural_name');
            $table->string('icon')->nullable();
            $table->string('description')->nullable();
            $table->integer('sort');
            $table->boolean('is_active');
            $table->boolean('is_system');
            $table->timestamps();

        });

        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(PostType::class)
                ->constrained();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('pages');
            $table->foreignIdFor(Language::class)
                ->constrained();
            $table->string('title');
            $table->string('slug')
                ->unique();
            $table->jsonb('content')
                ->nullable();
            $table->timestamps();
        });

        DB::table('post_types')->insert([
            'name' => 'Post',
            'slug' => 'posts',
            'plural_name' => 'Posts',
            'icon' => Heroicon::OutlinedDocumentText->value,
            'description' => 'Blog posts',
            'sort' => 1,
            'is_active' => true,
            'is_system' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('post_types')->insert([
            'name' => 'Page',
            'slug' => 'pages',
            'plural_name' => 'Pages',
            'icon' => Heroicon::OutlinedSquare2Stack->value,
            'description' => 'Website pages',
            'sort' => 1,
            'is_active' => true,
            'is_system' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
};
