<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Resultat du diagnostic de stress</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (! $isSaved)
                <div class="bg-amber-50 border border-amber-200 text-amber-900 rounded-lg px-4 py-3 text-sm">
                    Vous n'etes pas connecte: ce resultat est affiche mais n'est pas enregistre.
                    <a href="{{ route('login') }}" class="underline font-medium">Connectez-vous</a> pour sauvegarder vos prochains diagnostics.
                </div>
            @endif

            <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500">Niveau de stress</p>
                <p class="mt-1 text-2xl font-semibold text-cesi-green-700">{{ $interpretation['title'] }}</p>
                <p class="mt-2 text-lg font-medium text-gray-900">Score total: {{ $totalScore }}</p>
                <p class="mt-2 text-sm text-gray-700">{{ $interpretation['range'] }}</p>
                <p class="mt-1 text-sm text-gray-700">{{ $interpretation['risk'] }}</p>
                <p class="mt-1 text-sm text-gray-700">{{ $interpretation['details'] }}</p>

                @if ($totalScore >= 300)
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                        Recommandation automatique: votre niveau de stress est eleve. Essayez une session de respiration guidee des maintenant.
                        <a href="{{ route('breathing.show') }}" class="underline font-medium">Commencer la respiration</a>
                    </div>
                @endif

                <h3 class="mt-6 font-semibold text-gray-900">Evenements selectionnes</h3>
                <ul class="mt-3 list-disc list-inside text-sm text-gray-700 space-y-1">
                    @foreach ($selectedEvents as $event)
                        <li>{{ $event->label }} ({{ $event->score }} pts)</li>
                    @endforeach
                </ul>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('diagnostics.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-cesi-green-500 text-white text-sm font-medium hover:bg-cesi-green-600">Refaire le test</a>
                    @auth
                        <a href="{{ route('diagnostics.history') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">Voir mon historique</a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">Créer un compte</a>
                    @endauth
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
