<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Equipo') }}
            </h2>

            {{--            <x-link-btn href="{{route('equipment.index')}}">Volver</x-link-btn>--}}
            <x-link-btn href="/catalogo">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <x-forms.form method="POST" action="{{route('equipment.store')}}" class="max-w-4xl px-3 md:px-2">
            <h3 class="text-xl font-bold text-blue-main">Campos Obligatorios</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-forms.input label="Código" name="code" placeholder="EXC-001"/>
                <x-forms.input label="Marca" name="brand" placeholder="Caterpillar"/>
                <x-forms.input label="Modelo" name="model" placeholder="S7D"/>
                <x-forms.input label="Año" name="year" placeholder="2024"/>
            </div>

            <!-- Estado -->
            <x-forms.select label="Estado" name="status">
                <option value="active">Operativa</option>
                <option value="maintenance">En Mantenimiento</option>
                <option value="inactive">Inactiva</option>
            </x-forms.select>

            <!-- Tipo de Equipo -->
            <x-forms.select label="Tipo de Equipo" name="equipment_type_id">
                @foreach($eTypes as $eType)
                    <option value="{{ $eType->id }}">{{ $eType->name }}</option>
                @endforeach
            </x-forms.select>
            <x-forms.divider class="bg-yellow-main"/>

            <h3 class="text-xl font-bold text-blue-main">Campos Complementarios</h3>
            <!-- Especificaciones Técnicas -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:my-6">
                <x-forms.input label="Largo" name="length" placeholder="12.5"/>
                <x-forms.input label="Ancho" name="width" placeholder="3.2"/>
                <x-forms.input label="Alto" name="height" placeholder="4.1"/>
                <x-forms.input label="Peso" name="weight" placeholder="15000"/>

                <x-forms.input label="Potencia del Motor" name="engine_power" placeholder="400"/>
                <x-forms.input label="Carga Máxima" name="max_load" placeholder="20"/>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <x-forms.input label="Capacidad de Cuchara" name="bucket_capacity" placeholder="6.5"/>
                <x-forms.input label="Combustible" name="fuel_type" placeholder="Diesel"/>
                <x-forms.input label="Capacidad de Combustible" name="fuel_capacity" placeholder="400"/>
            </div>

            <x-forms.divider/>
            <x-forms.button class="cursor-pointer">Guardar Equipo</x-forms.button>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
