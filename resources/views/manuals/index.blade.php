<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manuales') }}
            </h2>
            @can('admin-access')
                <x-link-btn href="{{route('manual.create')}}">
                    Agregar Manual
                </x-link-btn>
            @endcan
        </div>
    </x-slot>

    <x-panels.main>

        @livewire('inspection-table')

        <hr class="my-4">


    </x-panels.main>

</x-app-layout>
