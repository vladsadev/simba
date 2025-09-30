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
            // Sintaxis correcta para Livewire 3
            document.addEventListener('livewire:initialized', () => {
                // Escuchar el evento de confirmación
                Livewire.on('show-delete-confirmation', (event) => {
                    const count = event.count || event[0]?.count || 0;

                    if (confirm(`¿Estás seguro de eliminar ${count} registro(s)?\n\nEsta acción no se puede deshacer.`)) {
                        // Llamar al método deleteConfirmed del componente
                        Livewire.find('{{ $this->getId() }}')?.call('deleteConfirmed');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
