<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $content->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <p class="mt-1 text-sm text-gray-500">Publie le {{ $content->published_at?->format('d/m/Y') }}</p>

                <div class="mt-6 prose max-w-none text-gray-700">
                    {!! nl2br(e($content->body)) !!}
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
