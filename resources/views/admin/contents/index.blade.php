<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des contenus</h2>
            <a href="{{ route('admin.contents.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">Ajouter contenu</a>
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
                <p class="text-sm text-emerald-900 font-medium">Action rapide: ajouter un nouveau contenu d'information.</p>
                <a href="{{ route('admin.contents.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                    Ajouter contenu
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Titre</th>
                            <th class="px-4 py-3 text-left">Statut</th>
                            <th class="px-4 py-3 text-left">Auteur</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($contents as $content)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $content->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($content->is_published)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Publie</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Brouillon</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $content->creator->name }}</td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.contents.edit', $content) }}" class="text-emerald-700 hover:text-emerald-900">Modifier</a>
                                    <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 hover:text-red-900" onclick="return confirm('Supprimer ce contenu ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-600">Aucun contenu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
