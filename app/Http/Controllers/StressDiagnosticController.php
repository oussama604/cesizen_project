<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticItem;
use App\Models\StressDiagnostic;
use App\Models\StressEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class StressDiagnosticController extends \App\Http\Controllers\Controller
{
    public function create(): View
    {
        $events = StressEvent::query()
            ->where('is_active', true)
            ->orderBy('score', 'desc')
            ->get();

        return view('diagnostics.create', [
            'events' => $events,
        ]);
    }

    public function store(Request $request): RedirectResponse|View
    {
        $validated = $request->validate([
            'events' => ['required', 'array', 'min:1'],
            'events.*' => ['integer', 'exists:stress_events,id'],
        ]);

        $selectedEvents = StressEvent::query()
            ->whereIn('id', $validated['events'])
            ->get();

        $totalScore = (int) $selectedEvents->sum('score');

        $stressLevel = match (true) {
            $totalScore < 150 => 'faible',
            $totalScore <= 299 => 'modere',
            default => 'eleve',
        };

        $interpretation = $this->stressInterpretation($totalScore);

        if (! $request->user()) {
            return view('diagnostics.result', [
                'selectedEvents' => $selectedEvents,
                'totalScore' => $totalScore,
                'stressLevel' => $stressLevel,
                'interpretation' => $interpretation,
                'isSaved' => false,
            ]);
        }

        $diagnostic = StressDiagnostic::create([
            'user_id' => $request->user()->id,
            'total_score' => $totalScore,
            'stress_level' => $stressLevel,
            'diagnosed_at' => Carbon::now(),
        ]);

        foreach ($selectedEvents as $event) {
            DiagnosticItem::create([
                'stress_diagnostic_id' => $diagnostic->id,
                'stress_event_id' => $event->id,
                'score' => $event->score,
            ]);
        }

        return redirect()
            ->route('diagnostics.history')
            ->with('status', 'Diagnostic enregistre avec succes.');
    }

    public function history(Request $request): View
    {
        $diagnostics = $request->user()
            ->stressDiagnostics()
            ->with('items.event')
            ->latest('diagnosed_at')
            ->paginate(10);

        $breathingSessions = $request->user()
            ->breathingSessions()
            ->with('exercise')
            ->orderBy('practiced_at')
            ->get();

        return view('diagnostics.history', [
            'diagnostics' => $diagnostics,
            'breathingSessions' => $breathingSessions,
        ]);
    }

    /**
     * @return array{title: string, range: string, risk: string, details: string}
     */
    private function stressInterpretation(int $score): array
    {
        if ($score <= 149) {
            return [
                'title' => 'Stress faible (normal)',
                'range' => 'Score : 0 a 149',
                'risk' => 'Niveau considere comme normal. Risque faible de problemes de sante lies au stress.',
                'details' => 'C\'est le stress gerable ou normal.',
            ];
        }

        if ($score <= 299) {
            return [
                'title' => 'Stress modere',
                'range' => 'Score : 150 a 299',
                'risk' => 'Risque moyen.',
                'details' => 'Le corps commence a accumuler du stress.',
            ];
        }

        return [
            'title' => 'Stress eleve',
            'range' => 'Score : 300 et +',
            'risk' => 'Risque eleve (fatigue, burn-out, problemes de sante).',
            'details' => 'Une prise en charge est recommandee rapidement.',
        ];
    }
}
