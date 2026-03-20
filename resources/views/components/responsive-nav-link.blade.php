@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-cesi-yellow-400 text-start text-base font-medium text-cesi-green-700 bg-cesi-green-50 focus:outline-none focus:text-cesi-green-700 focus:bg-cesi-green-100 focus:border-cesi-green-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-cesi-green-700 hover:bg-cesi-yellow-50 hover:border-cesi-yellow-200 focus:outline-none focus:text-cesi-green-700 focus:bg-cesi-yellow-50 focus:border-cesi-yellow-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
