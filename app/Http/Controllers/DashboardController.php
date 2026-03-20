<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request): View
    {
        $latestDiagnostic = $request->user()
            ->stressDiagnostics()
            ->latest('diagnosed_at')
            ->first();

        $completedBreathingSession = null;

        if ($latestDiagnostic && $latestDiagnostic->total_score >= 300) {
            $completedBreathingSession = $request->user()
                ->breathingSessions()
                ->with('exercise')
                ->where('practiced_at', '>=', $latestDiagnostic->diagnosed_at)
                ->orderBy('practiced_at')
                ->first();
        }

        $latestPublishedContents = Content::query()
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('dashboard', [
            'latestDiagnostic' => $latestDiagnostic,
            'completedBreathingSession' => $completedBreathingSession,
            'latestPublishedContents' => $latestPublishedContents,
        ]);
    }
}
