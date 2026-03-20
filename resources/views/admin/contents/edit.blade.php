<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier un contenu</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.contents.update', $content) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @method('PATCH')
                @php($buttonLabel = 'Enregistrer les modifications')
                @include('admin.contents._form')
            </form>
        </div>
    </div>
</x-app-layout>
