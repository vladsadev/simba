<button {{
$attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-yellow-600 border border-transparent
rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out
duration-300 cursor-pointer']) }}>
    {{ $slot }}
</button>
