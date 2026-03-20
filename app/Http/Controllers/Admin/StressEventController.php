<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StressEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StressEventController extends Controller
{
    public function index(): View
    {
        Gate::authorize('access-admin-panel');

        $events = StressEvent::query()
            ->orderByDesc('score')
            ->orderBy('label')
            ->paginate(30);

        return view('admin.stress-events.index', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('access-admin-panel');

        return view('admin.stress-events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('access-admin-panel');

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255', 'unique:stress_events,label'],
            'score' => ['required', 'integer', 'min:0', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        StressEvent::query()->create([
            'label' => $validated['label'],
            'score' => (int) $validated['score'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.stress-events.index')->with('status', 'Question creee avec succes.');
    }

    public function edit(StressEvent $stressEvent): View
    {
        Gate::authorize('access-admin-panel');

        return view('admin.stress-events.edit', [
            'stressEvent' => $stressEvent,
        ]);
    }

    public function update(Request $request, StressEvent $stressEvent): RedirectResponse
    {
        Gate::authorize('access-admin-panel');

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255', 'unique:stress_events,label,'.$stressEvent->id],
            'score' => ['required', 'integer', 'min:0', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $stressEvent->update([
            'label' => $validated['label'],
            'score' => (int) $validated['score'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.stress-events.index')->with('status', 'Question mise a jour.');
    }

    public function destroy(StressEvent $stressEvent): RedirectResponse
    {
        Gate::authorize('access-admin-panel');

        $stressEvent->delete();

        return redirect()->route('admin.stress-events.index')->with('status', 'Question supprimee.');
    }
}
