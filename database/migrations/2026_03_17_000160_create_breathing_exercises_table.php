<?php

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
        Schema::create('breathing_exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('inhale_seconds')->default(4);
            $table->unsignedInteger('exhale_seconds')->default(4);
            $table->unsignedInteger('default_total_seconds')->default(120);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breathing_exercises');
    }
};
