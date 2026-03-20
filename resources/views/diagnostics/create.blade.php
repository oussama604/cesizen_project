<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Diagnostic de stress (Holmes-Rahe)</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-sm text-amber-900">
                Selectionnez les evenements de vie vecus au cours des 12 derniers mois.
            </div>

            <form method="POST" action="{{ route('diagnostics.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                @csrf

                @error('events')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-2">
                    @foreach ($events as $event)
                        <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-100 hover:border-cesi-yellow-300">
                            <input type="checkbox" name="events[]" value="{{ $event->id }}" class="mt-1 rounded border-gray-300 text-cesi-green-500 focus:ring-cesi-green-500" @checked(in_array($event->id, old('events', [])))>
                            <span class="text-sm text-gray-800">{{ $event->label }}</span>
                        </label>
                    @endforeach
                </div>

                <div>
                    <x-primary-button>Calculer mon niveau de stress</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
