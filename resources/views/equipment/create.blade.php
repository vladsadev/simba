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

        <x-forms.form method="POST" action="{{route('equipment.store')}}"  enctype="multipart/form-data" class="max-w-4xl px-3 md:px-2">
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
                <option value="De Acarreo">De Acarreo</option>
                <option value="Perforadora">Perforadora</option>
            </x-forms.select>
            <!-- Especificaciones Técnicas -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <x-forms.select label="Tipo de Combustible" name="fuel_type">
                    <option value="diesel">Diesel</option>
                    <option value="gasolina">Gasolina</option>
                    <option value="eléctrico">Eléctrico</option>
                </x-forms.select>
                <x-forms.input label="Capacidad de Combustible" name="fuel_capacity" placeholder="400"/>
            </div>
            <x-forms.input label="Manual" name="manual_pdf" class="border border-slate-600" type="file"/>
            <x-forms.input label="Imagen del Equipo" name="equipment_img" class="border border-slate-600" type="file"/>
            <x-forms.divider class="bg-yellow-main"/>

            <x-forms.button class="cursor-pointer">Guardar Equipo</x-forms.button>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
