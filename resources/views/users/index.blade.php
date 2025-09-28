<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios') }}
            </h2>
            <x-link-btn href="{{route('user-role.create')}}">
                Agregar Usuario
            </x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <div class="px-2">
            <div class="mt-2  flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="relative min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6
                                    lg:pl-8">Nombre y Correo electrónico
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold
                                text-gray-900">Cargo/Ocupación
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Último
                                    ingreso
                                </th>
                                <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{$user->name}}</div>
                                                <div class="mt-1 text-gray-500">{{$user->email}}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <x-table-user-item> {{$user->occupation ?? '-'}}</x-table-user-item>
                                    <x-table-user-item> {{($user->is_super_admin && $user->is_admin)? 'Super Admin' :
                                    ($user->is_admin ?'Administrador':'Usuario' )}}</x-table-user-item>
                                    <x-table-user-item> {{$user->updated_at->diffForHumans()??'-'}}</x-table-user-item>
                                    <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                        <x-link-btn size="sm" href="{{route('user-role.edit',$user)}}">Editar</x-link-btn>
                                        <form class="inline" action="{{route('user-role.destroy',$user)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button size="sm" variant="danger">Borrar</x-button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </x-panels.main>
</x-app-layout>
