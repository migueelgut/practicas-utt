<x-layouts.app title="Gestión de Usuarios">
    <div class="bg-white border border-gray-300 rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Gestión de Usuarios</h1>
                <p class="text-xs text-gray-500">Rol: {{ auth()->user()->role }}</p>
            </div>
            <a href="{{ route('usuarios.create') }}" class="px-3 py-1.5 bg-gray-900 text-white rounded text-sm hover:bg-gray-800">
                Nuevo Usuario
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-2.5 border border-gray-300 bg-gray-100 text-sm text-gray-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-2.5 border border-red-300 bg-red-50 text-sm text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">ID</th>
                        <th class="border border-gray-300 px-3 py-2">Nombre</th>
                        <th class="border border-gray-300 px-3 py-2">Correo</th>
                        <th class="border border-gray-300 px-3 py-2">Rol</th>
                        <th class="border border-gray-300 px-3 py-2">Estado</th>
                        <th class="border border-gray-300 px-3 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr class="{{ $u->trashed() ? 'bg-gray-100 text-gray-400' : '' }}">
                            <td class="border border-gray-300 px-3 py-2">{{ $u->id }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $u->name }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $u->email }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $u->role }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $u->trashed() ? 'Deshabilitado' : 'Activo' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2 space-x-2">
                                @if(!$u->trashed())
                                    <a href="{{ route('usuarios.show', $u) }}" class="underline text-gray-700">Ver</a>
                                    <a href="{{ route('usuarios.edit', $u) }}" class="underline text-gray-700">Editar</a>

                                    @if(auth()->user()->role === 'Administrador')
                                        <form action="{{ route('usuarios.destroy', $u) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="underline text-red-700 cursor-pointer" onclick="return confirm('¿Deshabilitar usuario?')">
                                                Deshabilitar
                                            </button>
                                        </form>
                                        <form action="{{ route('usuarios.force-delete', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="underline text-red-700 cursor-pointer" onclick="return confirm('¿Eliminar definitivamente?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if(auth()->user()->role === 'Administrador')
                                        <form action="{{ route('usuarios.restore', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="underline text-gray-800 cursor-pointer">Restaurar</button>
                                        </form>
                                        <form action="{{ route('usuarios.force-delete', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="underline text-red-700 cursor-pointer" onclick="return confirm('¿Eliminar definitivamente?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>