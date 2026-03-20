<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Tableau de bord CESIZen</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Dernier niveau de stress</p>
                    @php
                        $latestLabel = $latestDiagnostic
                            ? match (true) {
                                $latestDiagnostic->total_score <= 149 => 'Stress faible (normal)',
                                $latestDiagnostic->total_score <= 299 => 'Stress modéré',
                                default => 'Stress élevé',
                            }
                            : 'Aucun';
                    @endphp
                    <p class="mt-2 text-2xl font-semibold text-cesi-green-700">{{ $latestLabel }}</p>
                    <p class="mt-2 text-sm text-gray-600">Score: {{ $latestDiagnostic->total_score ?? '-' }}</p>
                    @if ($latestDiagnostic && $latestDiagnostic->total_score >= 300)
                        @if ($completedBreathingSession)
                            <div class="mt-2 text-sm text-green-800 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                Recommandation faite le {{ $completedBreathingSession->practiced_at?->format('d/m/Y H:i') }}
                                ({{ $completedBreathingSession->exercise->name ?? 'Respiration guidée' }}, {{ $completedBreathingSession->total_duration_seconds }}s).
                            </div>
                        @else
                            <a href="{{ route('breathing.show') }}" class="mt-2 inline-block text-sm text-red-700 underline">Recommandation : commencer la respiration guidée</a>
                        @endif
                    @endif
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Lancer un nouveau test</p>
                    <a href="{{ route('diagnostics.create') }}" class="mt-3 inline-block text-cesi-green-700 font-medium hover:text-cesi-green-600">Démarrer le diagnostic</a>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Suivi personnel</p>
                    <a href="{{ route('diagnostics.history') }}" class="mt-3 inline-block text-cesi-green-700 font-medium hover:text-cesi-green-600">Voir mon historique</a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Derniers contenus publiés</h3>
                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    @forelse ($latestPublishedContents as $content)
                        <li>
                            <a class="text-cesi-green-700 hover:text-cesi-green-600" href="{{ route('information.show', $content->slug) }}">
                                {{ $content->title }}
                            </a>
                        </li>
                    @empty
                        <li>Aucun contenu publié pour le moment.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
