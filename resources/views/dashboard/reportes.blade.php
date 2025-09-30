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
        @livewire('inspection-table')

        <hr class="my-4">

        <h3 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            {{ ('Mantenimientos') }}
        </h3>
        @livewire('maintenance-table')

    </x-panels.main>

    @push('scripts')
        <script>
            // Esperar a que el DOM y Livewire estén listos
            document.addEventListener('DOMContentLoaded', function() {
                // Usar delegación de eventos para capturar clicks en botones de bulk actions
                document.addEventListener('click', function(e) {
                    // Buscar si el click fue en un botón de bulk action "deleteSelected"
                    const button = e.target.closest('button[wire\\:click*="deleteSelected"]');

                    if (button) {
                        // Prevenir la ejecución inmediata
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        // Mostrar confirmación
                        if (confirm('¿Estás seguro de eliminar los registros seleccionados?\n\nEsta acción no se puede deshacer.')) {
                            // Si confirma, ejecutar la acción manualmente
                            const componentId = button.closest('[wire\\:id]').getAttribute('wire:id');
                            Livewire.find(componentId).call('deleteSelected');
                        }

                        return false;
                    }
                }, true); // Usar capture phase para interceptar antes
            });
        </script>
    @endpush
</x-app-layout>
