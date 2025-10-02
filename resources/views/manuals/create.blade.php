<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Manual') }}
            </h2>
            <x-link-btn href="{{ route('equipment.index') }}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{ route('manual.store') }}" enctype="multipart/form-data"
                      class="max-w-4xl px-3 md:px-2">

            <h3 class="text-xl font-bold text-blue-main mb-4">Campos Obligatorios</h3>

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">

                <x-forms.select label="Tipo de Equipo" name="equipment_type" required>
                    <option value="">Seleccione un Tipo</option>
                    <option value="Acarreo" {{old('equipment_type')=='Acarreo'? 'selected':''}}>De Acarreo</option>
                    <option value="Perforación" {{old('equipment_type')=='drilling'? 'selected':''}} >Perforación</option>
                </x-forms.select>

                <x-forms.select label="Modelo" name="model" required>
                    <option value="">Seleccione un Modelo</option>
                    <option value="ST7" {{old('model')=='ST7'? 'selected':''}}>ST7</option>
                    <option value="ST2G" {{old('model')=='ST2G'? 'selected':''}}> ST2G</option>
                    <option value="MT2010" {{old('model')=='MT2010'? 'selected':''}}> MT2010</option>
                    <option value="MT2200" {{old('model')=='MT2200'? 'selected':''}}> MT2200</option>
                    <option value="SIMBA_S7_D" {{old('model')=='SIMBA_S7_D'? 'selected':''}}> SIMBA_S7_D</option>
                    <option value="BOOMER_S1_D" {{old('model')=='BOOMER_S1_D'? 'selected':''}}> BOOMER_S1_D</option>
                    <option value="BOOMER_T1_D" {{old('model')=='BOOMER_T1_D'? 'selected':''}}>BOOMER_T1_D</option>
                </x-forms.select>

                <x-forms.select label="Descripción" name="description" required>
                    <option value="">Seleccione una descripción</option>
                    <option value="Partes" {{old('description')=='Partes'? 'selected':''}}>Partes</option>
                    <option value="Diagrama" {{old('description')=='Diagrama'? 'selected':''}}>Diagrama</option>
                    <option value="Seguridad" {{old('description')=='Operación'? 'selected':''}}>Seguridad</option>
                    <option value="Operación" {{old('description')=='Seguridad'? 'selected':''}}>Operación</option>
                    <option value="Mantenimiento" {{old('description')=='Mantenimiento'? 'selected':''}} >Mantenimiento</option>
                </x-forms.select>
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

            <div class="mt-4 lg:mt-8">
                <x-forms.button type="submit" class="cursor-pointer">
                    Guardar Manual
                </x-forms.button>
            </div>
        </x-forms.form>
    </x-panels.main>
</x-app-layout>
