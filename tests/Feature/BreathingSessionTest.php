<?php

namespace Tests\Feature;

use App\Models\BreathingExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreathingSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_store_breathing_session(): void
    {
        $user = User::factory()->createOne();
        $exercise = BreathingExercise::query()->create([
            'name' => 'Respiration guidee 4-4',
            'inhale_seconds' => 4,
            'exhale_seconds' => 4,
            'default_total_seconds' => 120,
            'is_active' => true,
        ]);

        $authUser = User::query()->findOrFail($user->id);

        $this->actingAs($authUser)->post(route('breathing.store'), [
            'breathing_exercise_id' => $exercise->id,
            'total_duration_seconds' => 120,
        ])->assertRedirect(route('breathing.show'));

        $this->assertDatabaseHas('breathing_sessions', [
            'user_id' => $user->id,
            'breathing_exercise_id' => $exercise->id,
            'total_duration_seconds' => 120,
        ]);
    }

    public function test_guest_cannot_store_breathing_session(): void
    {
        $exercise = BreathingExercise::query()->create([
            'name' => 'Respiration guidee 4-4',
            'inhale_seconds' => 4,
            'exhale_seconds' => 4,
            'default_total_seconds' => 120,
            'is_active' => true,
        ]);

        $this->post(route('breathing.store'), [
            'breathing_exercise_id' => $exercise->id,
            'total_duration_seconds' => 120,
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('breathing_sessions', 0);
    }
}
