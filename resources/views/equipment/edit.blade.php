<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar: ') }} <span class="text-yellow-main">{{$equipment->equipmentType->name .' '.
                $equipment->model}}</span>
            </h2>

            <x-link-btn href="{{route('equipment.show',$equipment)}}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <x-forms.form method="POST" action="{{route('equipment.update',$equipment)}}" class="max-w-4xl px-3 md:px-2">
            @method('PATCH')
            {{--            <h3 class="text-xl font-bold text-blue-main">Campos Obligatorios</h3>--}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-forms.input label="Código" name="code" placeholder="EXC-001" value="{{$equipment->code}}"/>
                <x-forms.input label="Marca" name="brand" placeholder="Caterpillar" value="{{$equipment->brand}}"/>
                <x-forms.input label="Modelo" name="model" placeholder="S7D" value="{{$equipment->model}}"/>
                <x-forms.input label="Año" name="year" placeholder="2024" value="{{$equipment->year}}"/>
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
                <x-forms.input label="Largo" name="length" placeholder="12.5" value="{{$equipment->length}}"/>
                <x-forms.input label="Ancho" name="width" placeholder="3.2" value="{{$equipment->width}}"/>
                <x-forms.input label="Alto" name="height" placeholder="4.1" value="{{$equipment->height}}"/>
                <x-forms.input label="Peso" name="weight" placeholder="15000" value="{{$equipment->weight}}"/>

                <x-forms.input label="Potencia del Motor" name="engine_power" placeholder="400"
                               value="{{$equipment->engine_power}}"/>
                <x-forms.input label="Carga Máxima" name="max_load" placeholder="20" value="{{$equipment->max_load}}"/>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <x-forms.input label="Capacidad de Cuchara" name="bucket_capacity" placeholder="6.5"
                               value="{{$equipment->bucket_capacity}}"/>
                <x-forms.input label="Combustible" name="fuel_type" placeholder="Diesel" value="{{$equipment->fuel_type}}"/>
                <x-forms.input label="Capacidad de Combustible" name="fuel_capacity" placeholder="400"
                               value="{{$equipment->fuel_capacity}}"/>
            </div>

            <x-forms.divider/>
            <x-forms.button>Actualizar Equipo</x-forms.button>
            <x-link-btn href="{{route('equipment.show',$equipment)}}"> Cancelar</x-link-btn>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
