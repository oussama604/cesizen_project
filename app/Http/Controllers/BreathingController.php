<?php

namespace App\Http\Controllers;

use App\Models\BreathingExercise;
use App\Models\BreathingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BreathingController extends \App\Http\Controllers\Controller
{
    public function show(): View
    {
        $exercise = BreathingExercise::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->firstOrFail();

        return view('breathing.show', [
            'exercise' => $exercise,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'breathing_exercise_id' => ['required', 'exists:breathing_exercises,id'],
            'total_duration_seconds' => ['required', 'integer', 'min:30', 'max:3600'],
        ]);

        BreathingSession::query()->create([
            'user_id' => $request->user()->id,
            'breathing_exercise_id' => (int) $validated['breathing_exercise_id'],
            'total_duration_seconds' => (int) $validated['total_duration_seconds'],
            'practiced_at' => now(),
        ]);

        return redirect()->route('breathing.show')->with('status', 'Session de respiration enregistree.');
    }
}
