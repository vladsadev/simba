<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <x-panels.main>

        <!-- Estadísticas Generales -->
        <x-description-heading>Resumen General</x-description-heading>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Operativas</p>
                        <p class="text-2xl font-semibold text-gray-900">16</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En Mantenimiento</p>
                        <p class="text-2xl font-semibold text-gray-900">6</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Fuera de Servicio</p>
                        <p class="text-2xl font-semibold text-gray-900">3</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Flota</p>
                        <p class="text-2xl font-semibold text-gray-900">33</p>
                    </div>
                </div>
            </div>
        </div>

        <x-description-heading>Detalle por Tipo de Máquina</x-description-heading>
        <!-- Categorías de Equipos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 w-3/4 mx-auto">
            <!-- Perforadoras -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                <div class="bg-gradient-to-r from-yellow-600/85 to-yellow-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">Perforadoras</h3>
                                <p class="text-sm text-white/80">12 equipos</p>
                            </div>
                        </div>
                        <a href="#" class="text-white hover:text-white/80
                            transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Operativas:</span>
                            <span class="font-medium text-green-600">10</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Mantenimiento:</span>
                            <span class="font-medium text-yellow-600">2</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Fuera de servicio:</span>
                            <span class="font-medium text-red-600">0</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-xs text-gray-500 mb-2">Última inspección</div>
                        <div class="text-sm font-medium text-gray-900">Hace 2 horas</div>
                    </div>
                </div>
            </div>

            <!-- De Acareo-->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                <div class="bg-gradient-to-r from-yellow-600/85 to-yellow-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 7h-3V6a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1H7a1 1 0 0 0-1 1v11a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V8a1 1 0 0 0-1-1zM11 6h2v1h-2V6zm6 13a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V9h8v10z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">De Acarreo</h3>
                                <p class="text-sm text-white/80">8 equipos</p>
                            </div>
                        </div>
                        <a href="#" class="text-white hover:text-white/80 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Operativas:</span>
                            <span class="font-medium text-green-600">6</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Mantenimiento:</span>
                            <span class="font-medium text-yellow-600">2</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Fuera de servicio:</span>
                            <span class="font-medium text-red-600">0</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-xs text-gray-500 mb-2">Última inspección</div>
                        <div class="text-sm font-medium text-gray-900">Hace 4 horas</div>
                    </div>
                </div>
            </div>

        </div>

    </x-panels.main>

</x-app-layout>
