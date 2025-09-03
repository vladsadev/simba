<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl">
                {{$inspection->equipment->code}}
            </h2>
        </div>
    </x-slot>

    <x-panels.main>

        <x-inspection.horometer-info :inspection="$inspection"/>
        {{--        {{$inspection}}--}}
        <hr class="my-4">
        <div class="space-y-6 gap-4 grid grid-cols-1 sm:grid-cols-3">
            <div class="sm:col-span-2">
                {{-- 🔍 Sección 1: Revisión antes de arrancar --}}
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="flex items-center text-lg font-semibold mb-3">
                        <span class="mr-2">🔍</span> Revisión antes de arrancar
                    </h3>
                    {{--                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-1 text-xs lg:text-sm">--}}
                    <div class="grid grid-cols-2 gap-y-1">
                        <div>Combustible: {!! $inspection->nivel_combustible_checked ? '✅' : '❌' !!}</div>
                        <div>Aceite motor: {!! $inspection->nivel_aceite_motor_checked ? '✅' : '❌' !!}</div>
                        <div>Refrigerante: {!! $inspection->nivel_refrigerante_checked ? '✅' : '❌' !!}</div>
                        <div>Aceite hidráulico: {!! $inspection->nivel_aceite_hidraulico_checked ? '✅' : '❌' !!}</div>
                        <div>Purgar agua filtro: {!! $inspection->purgar_agua_filtro_checked ? '✅' : '❌' !!}</div>
                        <div>Correas alternador, ventilador y combustible : {!! $inspection->correas_alternador_checked ? '✅' :
                        '❌'
                        !!}</div>
                    </div>

                    <hr class="my-4">

                    {{-- ⚙️ Sección 2: Después de arrancar --}}
                    <h3 class="flex items-center text-lg font-semibold mb-3">
                        <span class="mr-2">⚙️</span> Después de arrancar
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-sm">
                        <div>Pedales de freno: {!! $inspection->pedales_freno_checked ? '✅' : '❌' !!}</div>
                        <div>Alarma de arranque: {!! $inspection->alarma_arranque_checked ? '✅' : '❌' !!}</div>
                        <div>Sistema de aire: {!! $inspection->sistema_de_aire_checked ? '✅' : '❌' !!}</div>
                        <div>Sistema de barrido: {!! $inspection->sistema_de_barrido_checked ? '✅' : '❌' !!}</div>
                    </div>

                    <hr class="my-4">

                    {{-- 🛠️ Sección 3: Inspección general --}}
                    <h3 class="flex items-center text-lg font-semibold mb-3">
                        <span class="mr-2">🛠️</span> Inspección general
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-sm">
                        <div>Carrete posicionamiento: {!! $inspection->carrete_de_posicionamiento_checked ? '✅' : '❌' !!}</div>
                        <div>Válvula avance: {!! $inspection->valvula_a_avance_checked ? '✅' : '❌' !!}</div>
                        <div>Mesa perforadora: {!! $inspection->mesa_de_perforadora_checked ? '✅' : '❌' !!}</div>
                    </div>

                    <hr class="my-4">

                    <h3 class="flex items-center text-lg font-semibold mb-3">
                        <span class="mr-2"> ⚙️</span> Temas no negociables
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-sm">
                        <div>Freno de servicio: {!! $inspection->freno_de_servicio_checked ? '✅' : '❌' !!}</div>
                        <div>Freno de parqueo: {!! $inspection->freno_parqueo_checked ? '✅' : '❌' !!}</div>
                        <div>Luces delanteras: {!! $inspection->luces_delanteras_checked ? '✅' : '❌' !!}</div>
                        <div>Alarma de retroceso: {!! $inspection->alarma_de_retroceso_checked ? '✅' : '❌' !!}</div>
                        <div>Bocina: {!! $inspection->bocina_checked ? '✅' : '❌' !!}</div>
                        <div>Cinturón seguridad: {!! $inspection->cinturon_de_seguridad_checked ? '✅' : '❌' !!}</div>
                    </div>

                </div>
            </div>

            <div class="sm:col-span-1">

                {{-- 👷 EPP --}}
                <div>
                    <h3 class="flex items-center text-lg font-semibold mb-2">
                        <span class="mr-2">👷</span> Equipo de protección personal
                    </h3>
                    <p class="text-sm">
                        {!! $inspection->epp_complete ? '✅ Completo' : '❌ Incompleto' !!}
                    </p>

                    <hr class="my-4">
                    {{-- 📝 Observaciones --}}
                    <h3 class="flex items-center text-lg font-semibold mb-2">
                        <span class="mr-2">📝</span> Observaciones
                    </h3>
                    <p class="p-3 rounded-lg text-sm">
                        {{$inspection->observations? $inspection->observations: 'Sin Observaciones'}}
                    </p>

                    <hr class="my-4">
                    {{-- 📝 Issues--}}
                    <h3 class="flex items-center text-lg font-semibold mb-2">
                        <span class="mr-2">🚨</span> Avería Reportada
                    </h3>
                </div>
            </div>
        </div>


    </x-panels.main>

</x-app-layout>
