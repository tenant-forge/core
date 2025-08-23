<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->boolean('default')->default(false);
            $table->boolean('active')->default(false);

            $table->timestamps();
            $table->index(['code', 'active']);
            $table->index(['default']);

        });
    }
};
