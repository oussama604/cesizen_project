<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des questions Holmes-Rahe</h2>
            <a href="{{ route('admin.stress-events.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">Ajouter question</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-between gap-3 flex-wrap">
                <p class="text-sm text-emerald-900 font-medium">Action rapide: ajouter une question Holmes-Rahe.</p>
                <a href="{{ route('admin.stress-events.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                    Ajouter question
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Question</th>
                            <th class="px-4 py-3 text-left">Score</th>
                            <th class="px-4 py-3 text-left">Etat</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($events as $event)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $event->label }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $event->score }}</td>
                                <td class="px-4 py-3">
                                    @if ($event->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Actif</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Inactif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.stress-events.edit', $event) }}" class="text-emerald-700 hover:text-emerald-900">Modifier</a>
                                    <form method="POST" action="{{ route('admin.stress-events.destroy', $event) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 hover:text-red-900" onclick="return confirm('Supprimer cette question ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-600">Aucune question.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
