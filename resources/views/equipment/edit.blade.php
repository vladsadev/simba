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
            <h3 class="text-xl font-bold text-blue-main">Campos Obligatorios</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-forms.input label="Código" name="code" placeholder="EXC-001" value="{{$equipment->code}}"/>
                <x-forms.input label="Marca" name="brand" placeholder="Caterpillar" value="{{$equipment->brand}}"/>
                <x-forms.input label="Modelo" name="model" placeholder="S7D" value="{{$equipment->model}}"/>
                <x-forms.input label="Año" name="year" placeholder="2024" value="{{$equipment->year}}"/>
            </div>

            <!-- Estado -->
            <x-forms.select label="Estado" name="status">
                <option value="active" {{ $equipment->status == 'active' ? 'selected' : '' }}>Operativa</option>
                <option value="maintenance" {{ $equipment->status == 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                <option value="inactive" {{ $equipment->status == 'inactive' ? 'selected' : '' }}>Inactiva</option>
            </x-forms.select>

            <!-- Ubicación -->
            <x-forms.select label="Ubicación" name="location">
                <option value="">Seleccione una ubicación</option>
                <option value="Interior mina" {{ $equipment->location == 'Interior mina' ? 'selected' : '' }}>Interior Mina</option>
                <option value="Exterior mina" {{ $equipment->location == 'Exterior mina' ? 'selected' : '' }}>Exterior Mina</option>
                <option value="Área de Mantenimiento" {{ $equipment->location == 'Área de Mantenimiento' ? 'selected' : '' }}>Área de Mantenimiento</option>
                <option value="Apartada de la Empresa" {{ $equipment->location == 'Apartada de la Empresa' ? 'selected' : '' }}>Apartada de la Empresa</option>
            </x-forms.select>

            <!-- Tipo de Equipo -->
            <x-forms.select label="Tipo de Equipo" name="equipment_type_id">
                @foreach($eTypes as $eType)
                    <option value="{{ $eType->id }}" {{ $equipment->equipment_type_id == $eType->id ? 'selected' : '' }}>
                        {{ $eType->name }}
                    </option>
                @endforeach
            </x-forms.select>

            <!-- Especificaciones Técnicas -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <x-forms.input label="Combustible" name="fuel_type" placeholder="Diesel" value="{{$equipment->fuel_type}}"/>
                <x-forms.input label="Capacidad de Combustible" name="fuel_capacity" placeholder="400"
                               value="{{$equipment->fuel_capacity}}"/>
            </div>

            <!-- Archivos -->
            <div class="mb-4">
                <x-forms.input
                    label="Manual (PDF)"
                    name="manual_pdf"
                    type="file"
                    accept=".pdf"
                    class="border border-slate-600"
                />
            </div>

            <div class="mb-4">
                <x-forms.input
                    label="Imagen del Equipo"
                    name="equipment_img"
                    type="file"
                    accept="image/*"
                    class="border border-slate-600"
                />
            </div>


            <x-forms.divider class="bg-yellow-main"/>
            <x-forms.button>Actualizar Equipo</x-forms.button>
            <x-link-btn href="{{route('equipment.show',$equipment)}}"> Cancelar</x-link-btn>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
