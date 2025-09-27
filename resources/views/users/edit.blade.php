<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios') }}
            </h2>
            <div class="gap-3">
                <x-link-btn href="{{route('user-role.index')}}">
                    Volver
                </x-link-btn>
            </div>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{ route('user-role.update',$user) }}" class="max-w-4xl">
            @csrf
            @method('PATCH')

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-forms.input
                    label="Nombre"
                    name="name"
                    placeholder="Juan Ventura"
                    value="{{$user->name}}"
                    required
                />
                <x-forms.error/>

                <x-forms.input
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="juanv@jv.com"
                    value="{{$user->email}}"
                    required
                />

                <x-forms.input
                    label="Password"
                    name="password"
                    type="email"
                    placeholder="juanv@jv.com"
                    value="{{$user->email}}"
                    required
                />

                <x-forms.input
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="juanv@jv.com"
                    value="{{$user->email}}"
                    required
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-forms.input
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="juanv@jv.com"
                    value="{{$user->email}}"
                    required
                />

            </div>

            <x-forms.divider class="bg-yellow-main my-6"/>

            <x-forms.select label="Permiso" name="role" required>
                <option value="administrador" {{ old('role', $user->is_admin) == '1' ? 'selected' : ''
                        }}>Administrador
                </option>
                <option value="usuario" {{ old('role', $user->is_admin) == '0' ? 'selected' : ''
                        }}>Usuario
                </option>
            </x-forms.select>
            <x-forms.button type="submit" class="cursor-pointer">
                Guardar Equipo
            </x-forms.button>
        </x-forms.form>

    </x-panels.main>
</x-app-layout>
