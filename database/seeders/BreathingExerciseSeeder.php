<?php

namespace Database\Seeders;

use App\Models\BreathingExercise;
use Illuminate\Database\Seeder;

class BreathingExerciseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        BreathingExercise::query()->updateOrCreate(
            ['name' => 'Respiration guidee 4-4'],
            [
                'inhale_seconds' => 4,
                'exhale_seconds' => 4,
                'default_total_seconds' => 120,
                'is_active' => true,
            ]
        );
    }
}
