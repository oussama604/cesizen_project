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
        Schema::create('diagnostic_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stress_diagnostic_id')->constrained('stress_diagnostics')->cascadeOnDelete();
            $table->foreignId('stress_event_id')->constrained('stress_events')->cascadeOnDelete();
            $table->unsignedInteger('score');
            $table->timestamps();

            $table->unique(['stress_diagnostic_id', 'stress_event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_items');
    }
};
