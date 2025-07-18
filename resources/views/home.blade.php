<x-main>
    <!-- Header -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    {{--                    <img src="{{Vite::asset('resources/images/logo.png')}}" alt=""--}}
                    {{--                         class="h-8 w-auto"/>--}}
                    <x-application-logo/>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                         aria-hidden="true" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#" class="text-sm/6 font-semibold text-white">Nosotros</a>
                <a href="#" class="text-sm/6 font-semibold text-white">Contacto</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-white">Log in <span
                            aria-hidden="true">&rarr;</span></a>
            </div>
        </nav>

        <!-- Mobile menu, show/hide based on menu open state. -->
        <div role="dialog" aria-modal="true" class="lg:hidden">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <x-application-logo/>
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400">
                        <span class="sr-only">Close menu</span>
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
                               hover:bg-gray-800">Nosotros</a>
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white
                               hover:bg-gray-800">Contacto</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('login') }}"
                               class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white
                               hover:bg-gray-800">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero section -->
        <div class="relative isolate overflow-hidden bg-gray-900 pt-14 pb-16 sm:pb-20 h-[100vh]">
{{--            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2830&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply"--}}
{{--                 alt="" class="absolute inset-0 -z-10 size-full object-cover"/>--}}
            <img src="{{Vite::asset('resources/images/simbaHome.webp')}}"
                 alt="" class="absolute inset-0 -z-10 size-full object-cover"/>
            <div aria-hidden="true"
                 class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                     class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
            </div>
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        <h1 class="text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">Data to enrich
                            your online business</h1>
                        <p class="mt-8 text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">Anim aute id magna aliqua
                            ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam
                            occaecat.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('login') }}"
                               class="rounded-md bg-yellow-600 px-4.5 py-2.5 text-sm lg:text-md font-semibold text-white
                               shadow-xs
                               hover:bg-blue-main focus-visible:outline-2 focus-visible:outline-offset-2
                               focus-visible:outline-blue-main">Log in</a>
                        </div>
                    </div>
                </div>

                <!-- Equipos -->
                <div class="flex gap-8">
                    <img width="158" height="48"
                         src="https://tailwindcss.com/plus-assets/img/logos/158x48/transistor-logo-white.svg" alt="Transistor"
                         class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"/>
                    <img width="158" height="48"
                         src="https://tailwindcss.com/plus-assets/img/logos/158x48/reform-logo-white.svg" alt="Reform"
                         class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"/>
                    <img width="158" height="48"
                         src="https://tailwindcss.com/plus-assets/img/logos/158x48/tuple-logo-white.svg" alt="Tuple"
                         class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"/>
                </div>
            </div>
            <div aria-hidden="true"
                 class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                     class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
            </div>
        </div>
    </main>

</x-main>
