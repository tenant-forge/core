<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table): void {
            $table->id();
            $table->string('locale')->unique();
            $table->string('name')->unique();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->index(['code', 'active']);
            $table->index(['default']);

        });

        DB::table('languages')->insert([
            'locale' => 'en',
            'name' => 'English',
            'is_default' => true,
            'is_active' => true,

        ]);
    }
};
