<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catálogo de equipos') }}
            </h2>
            <x-link-btn href="{{route('equipment.create')}}">
                Agregar Equipo
            </x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 bg-gray-50">
            @foreach($equipment as $machine)

                <x-machine.card :$machine/>

            @endforeach
        </div>

        <div class="mt-2 lg:mt-4">
            {{$equipment->links()}}
        </div>
    </x-panels.main>

</x-app-layout>
