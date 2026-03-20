<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Informations utiles</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($contents as $content)
                    <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $content->title }}</h3>
                        <p class="mt-3 text-sm text-gray-600 flex-1">{{ \Illuminate\Support\Str::limit(strip_tags($content->body), 130) }}</p>
                        <a href="{{ route('information.show', $content->slug) }}" class="mt-4 text-sm font-medium text-cesi-green-700 hover:text-cesi-green-600">
                            Lire l'article
                        </a>
                    </article>
                @empty
                    <p class="text-gray-600">Aucun contenu publie pour le moment.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
