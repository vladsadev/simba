<x-main>
    <!-- Header -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">PAN AMERICAN SILVER</span>
                    <x-application-logo/>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-white hover:text-gray-200">
                    <span class="sr-only">Abrir menú principal</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                         aria-hidden="true" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#" class="text-sm/6 font-semibold text-white hover:text-gray-200 transition-colors duration-200 drop-shadow-lg">Nosotros</a>
                <a href="#" class="text-sm/6 font-semibold text-white hover:text-gray-200 transition-colors duration-200 drop-shadow-lg">Contacto</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-white hover:text-gray-200 transition-colors duration-200 drop-shadow-lg">
                    Iniciar Sesión <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </nav>

        <!-- Mobile menu, show/hide based on menu open state. -->
        <div role="dialog" aria-modal="true" class="lg:hidden">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50 bg-black/50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900/95 backdrop-blur-sm p-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">PAN AMERICAN SILVER</span>
                        <x-application-logo/>
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400 hover:text-white transition-colors duration-200">
                        <span class="sr-only">Cerrar menú</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                             aria-hidden="true" class="size-6">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/25">
                        <div class="space-y-2 py-6">
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white
                               hover:bg-gray-800 transition-colors duration-200">Nosotros</a>
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white
                               hover:bg-gray-800 transition-colors duration-200">Contacto</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('login') }}"
                               class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white
                               hover:bg-gray-800 transition-colors duration-200">Iniciar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero section -->
        <div class="relative isolate overflow-hidden bg-gray-900 pt-14 pb-16 sm:pb-20 h-[100vh]">
            <!-- Background Image -->
            <img src="{{Vite::asset('resources/images/simbaHome.webp')}}"
                 alt="Equipo minero en operación" class="absolute inset-0 -z-20 size-full object-cover"/>

            <!-- Dark Overlay for better text contrast -->
            <div class="absolute inset-0 -z-10 bg-black/60"></div>

            <!-- Gradient overlay for additional depth -->
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>

            <div aria-hidden="true"
                 class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                     class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-10 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        <h1 class="text-5xl font-bold tracking-tight text-balance text-white sm:text-7xl drop-shadow-2xl">
                            Sistema de Control
                            <span class="text-yellow-400 drop-shadow-2xl">SIMBA</span>
                        </h1>
                        <p class="mt-8 text-lg font-medium text-pretty text-gray-200 sm:text-xl/8 drop-shadow-xl max-w-2xl mx-auto">
                            Control y monitoreo del estado de equipos pesados para operaciones mineras.
                            Gestiona inspecciones de seguridad y reportes operacionales de manera eficiente.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('login') }}"
                               class="rounded-md bg-yellow-600 px-6 py-3 text-sm lg:text-md font-semibold text-white
                               shadow-2xl hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2
                               focus-visible:outline-yellow-500 transition-all duration-200 transform hover:scale-105">
                                Iniciar Sesión
                            </a>
                            <a href="#equipos" class="text-sm font-semibold text-white hover:text-gray-200 transition-colors duration-200 drop-shadow-lg">
                                Ver Equipos <span aria-hidden="true">↓</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Equipos Section -->
                <div id="equipos" class="mx-auto max-w-7xl pb-16">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-white drop-shadow-2xl mb-4">Equipos Monitoreados</h2>
                        <p class="text-gray-200 drop-shadow-xl">Controla el estado operacional de tu flota de equipos pesados</p>
                    </div>

                    <!-- Equipment Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                        <!-- Excavadoras -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7h-3V6a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1H7a1 1 0 0 0-1 1v11a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V8a1 1 0 0 0-1-1zM11 6h2v1h-2V6zm6 13a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V9h8v10z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white drop-shadow-lg mb-2">Excavadoras</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Control de palas y sistemas hidráulicos</p>
                            </div>
                        </div>

                        <!-- Camiones -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 8h-3V6c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2v2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3v-2c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2zM6 17.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm12 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white drop-shadow-lg mb-2">Camiones</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Monitoreo de sistemas de transporte</p>
                            </div>
                        </div>

                        <!-- Perforadoras -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white drop-shadow-lg mb-2">Perforadoras</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Control de equipos de perforación</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div aria-hidden="true"
                 class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                     class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-10 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
            </div>
        </div>
    </main>

</x-main>
