<?php

namespace Tests\Feature;

use App\Models\DiagnosticItem;
use App\Models\StressDiagnostic;
use App\Models\StressEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StressDiagnosticTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_run_diagnostic_without_persistence(): void
    {
        $eventA = StressEvent::query()->create([
            'label' => 'Divorce',
            'score' => 73,
            'is_active' => true,
        ]);

        $eventB = StressEvent::query()->create([
            'label' => 'Changement de travail',
            'score' => 36,
            'is_active' => true,
        ]);

        $response = $this->post(route('diagnostics.store'), [
            'events' => [$eventA->id, $eventB->id],
        ]);

        $response
            ->assertOk()
            ->assertSee('n\'est pas enregistre', false)
            ->assertSee('Score total: 109');

        $this->assertDatabaseCount('stress_diagnostics', 0);
        $this->assertDatabaseCount('diagnostic_items', 0);
    }

    public function test_user_can_submit_stress_diagnostic_and_level_is_computed(): void
    {
        $user = User::factory()->createOne();
        $this->assertInstanceOf(User::class, $user);

        $eventA = StressEvent::query()->create([
            'label' => 'Divorce',
            'score' => 73,
            'is_active' => true,
        ]);

        $eventB = StressEvent::query()->create([
            'label' => 'Changement de travail',
            'score' => 36,
            'is_active' => true,
        ]);

        $authUser = User::query()->findOrFail($user->id);

        $response = $this->actingAs($authUser)->post(route('diagnostics.store'), [
            'events' => [$eventA->id, $eventB->id],
        ]);

        $response->assertRedirect(route('diagnostics.history'));

        $this->assertDatabaseHas('stress_diagnostics', [
            'user_id' => $user->id,
            'total_score' => 109,
            'stress_level' => 'faible',
        ]);

        $diagnostic = StressDiagnostic::query()->where('user_id', $user->id)->firstOrFail();

        $this->assertSame(2, DiagnosticItem::query()->where('stress_diagnostic_id', $diagnostic->id)->count());
    }

    public function test_high_score_diagnostic_is_classified_as_eleve(): void
    {
        $user = User::factory()->createOne();
        $this->assertInstanceOf(User::class, $user);

        $eventA = StressEvent::query()->create([
            'label' => 'Deces du conjoint',
            'score' => 100,
            'is_active' => true,
        ]);

        $eventB = StressEvent::query()->create([
            'label' => 'Divorce',
            'score' => 73,
            'is_active' => true,
        ]);

        $eventC = StressEvent::query()->create([
            'label' => 'Separation conjugale',
            'score' => 65,
            'is_active' => true,
        ]);

        $eventD = StressEvent::query()->create([
            'label' => 'Detention',
            'score' => 63,
            'is_active' => true,
        ]);

        $authUser = User::query()->findOrFail($user->id);

        $this->actingAs($authUser)->post(route('diagnostics.store'), [
            'events' => [$eventA->id, $eventB->id, $eventC->id, $eventD->id],
        ]);

        $this->assertDatabaseHas('stress_diagnostics', [
            'user_id' => $user->id,
            'total_score' => 301,
            'stress_level' => 'eleve',
        ]);
    }
}
