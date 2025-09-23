<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reportes') }}
            </h2>
        </div>
    </x-slot>

    <x-panels.main>


        <h3 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            {{ ('Usuarios') }}
        </h3>
        @livewire('users-table')
    </x-panels.main>
</x-app-layout>
