<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Historique des diagnostics</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900">Historique des exercices de respiration</h3>
                <ul class="mt-3 text-sm text-gray-700 space-y-2">
                    @forelse ($breathingSessions->sortByDesc('practiced_at')->take(5) as $session)
                        <li class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                            <span class="font-medium">{{ $session->exercise->name ?? 'Exercice' }}</span>
                            <span class="text-gray-500">{{ $session->practiced_at?->format('d/m/Y H:i') }} - {{ $session->total_duration_seconds }}s</span>
                        </li>
                    @empty
                        <li class="text-gray-600">Aucun exercice de respiration enregistre pour le moment.</li>
                    @endforelse
                </ul>
            </section>

            @forelse ($diagnostics as $diagnostic)
                @php
                    $label = match (true) {
                        $diagnostic->total_score <= 149 => 'Stress faible (normal)',
                        $diagnostic->total_score <= 299 => 'Stress modere',
                        default => 'Stress eleve',
                    };

                    $completedBreathingSession = $breathingSessions->first(
                        fn ($session) => $session->practiced_at && $session->practiced_at->greaterThanOrEqualTo($diagnostic->diagnosed_at)
                    );
                @endphp
                <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-sm text-gray-500">{{ $diagnostic->diagnosed_at->format('d/m/Y H:i') }}</p>
                        <p class="text-sm font-semibold tracking-wide text-cesi-green-700">{{ $label }}</p>
                    </div>
                    <p class="mt-2 text-lg font-semibold text-gray-900">Score total: {{ $diagnostic->total_score }}</p>
                    @if ($diagnostic->total_score >= 300)
                        @if ($completedBreathingSession)
                            <div class="mt-2 text-sm text-green-800 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                Recommandation faite: exercice realise le {{ $completedBreathingSession->practiced_at?->format('d/m/Y H:i') }}
                                ({{ $completedBreathingSession->exercise->name ?? 'Respiration guidee' }}, {{ $completedBreathingSession->total_duration_seconds }}s).
                            </div>
                        @else
                            <p class="mt-2 text-sm text-red-700">
                                Recommandation: stress eleve detecte.
                                <a href="{{ route('breathing.show') }}" class="underline font-medium">Faire un exercice de respiration</a>
                            </p>
                        @endif
                    @endif
                    <ul class="mt-3 text-sm text-gray-600 list-disc list-inside space-y-1">
                        @foreach ($diagnostic->items as $item)
                            <li>{{ $item->event->label }} ({{ $item->score }} pts)</li>
                        @endforeach
                    </ul>
                </article>
            @empty
                <p class="text-gray-600">Aucun diagnostic enregistre.</p>
            @endforelse

            <div>
                {{ $diagnostics->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
