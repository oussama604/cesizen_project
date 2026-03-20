<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-cesi-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-cesi-green-600 focus:bg-cesi-green-600 active:bg-cesi-green-700 focus:outline-none focus:ring-2 focus:ring-cesi-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
