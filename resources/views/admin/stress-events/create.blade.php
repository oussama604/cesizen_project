<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle question Holmes-Rahe</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.stress-events.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @php($buttonLabel = 'Creer la question')
                @include('admin.stress-events._form')
            </form>
        </div>
    </div>
</x-app-layout>
