<!-- resources/views/components/equipment/horometer-status.blade.php -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-blue-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Estado Actual de Horómetros
        </h3>
        @if($equipment->inspections->count() > 0)
            <span class="text-sm text-gray-500">
                Última actualización: {{ $equipment->inspections->first()->inspection_date->diffForHumans() }}
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Motor -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Motor</span>
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->engine_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
            @if($equipment->engine_hours > 0)
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full"
                             style="width: {{ min(100, ($equipment->engine_hours / 10000) * 100) }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format((($equipment->engine_hours / 10000) * 100), 1) }}% de 10,000 hrs
                    </p>
                </div>
            @endif
        </div>

        <!-- Percusión -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Percusión</span>
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->percussion_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
            @if($equipment->percussion_hours > 0)
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full"
                             style="width: {{ min(100, ($equipment->percussion_hours / 10000) * 100) }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format((($equipment->percussion_hours / 10000) * 100), 1) }}% de 10,000 hrs
                    </p>
                </div>
            @endif
        </div>

        <!-- Posicionamiento -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Posicionamiento</span>
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->position_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
            @if($equipment->position_hours > 0)
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full"
                             style="width: {{ min(100, ($equipment->position_hours / 10000) * 100) }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format((($equipment->position_hours / 10000) * 100), 1) }}% de 10,000 hrs
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Alerta de mantenimiento si se acerca a ciertos límites -->
    @php
        $maxHours = max($equipment->engine_hours ?? 0, $equipment->percussion_hours ?? 0, $equipment->position_hours ?? 0);
        $nextMaintenanceAt = 500 * ceil($maxHours / 500); // Siguiente múltiplo de 500
        $hoursUntilMaintenance = $nextMaintenanceAt - $maxHours;
    @endphp

    @if($hoursUntilMaintenance <= 50 && $maxHours > 0)
        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm text-yellow-800">
                    Mantenimiento recomendado en aproximadamente <strong>{{ number_format($hoursUntilMaintenance, 1) }} horas</strong>
                    (al alcanzar {{ number_format($nextMaintenanceAt, 0) }} hrs)
                </span>
            </div>
        </div>
    @endif
</div>
