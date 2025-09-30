<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reportes') }}
            </h2>
        </div>
    </x-slot>

    <x-panels.main>
        <button
            onclick="if(!confirm('¿Estás seguro de borrar los registros seleccionados?')) return false;"
            wire:click="deleteSelected"
            class="btn btn-danger">
            Borrar seleccionados
        </button>
        <h3 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            {{ ('Inspecciones') }}
        </h3>
        @livewire('inspection-table')

        <hr class="my-4">

        <h3 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            {{ ('Mantenimientos') }}
        </h3>
        @livewire('maintenance-table')

    </x-panels.main>
</x-app-layout>
