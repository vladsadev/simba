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
            {{ ('Inspecciones') }}
        </h3>

        <div x-data="{
            showDeleteConfirm(count) {
                if (confirm(`¿Estás seguro de eliminar ${count} registro(s)?\n\nEsta acción no se puede deshacer.`)) {
                    $wire.call('deleteConfirmed');
                }
            }
        }"
             @show-delete-confirmation.window="showDeleteConfirm($event.detail.count)">
            @livewire('inspection-table')
        </div>

        <hr class="my-4">

        <h3 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            {{ ('Mantenimientos') }}
        </h3>
        @livewire('maintenance-table')

    </x-panels.main>
</x-app-layout>
