<x-layouts.app title="Reservación de Equipos">
    <div class="space-y-6">
        <div class="bg-white border border-gray-300 rounded p-6">
            <h1 class="text-lg font-bold text-gray-900">Reservación de Equipos de Cómputo</h1>
            <p class="text-xs text-gray-500">Usuario: {{ auth()->user()->name }} | Rol: {{ auth()->user()->role }}</p>

            @if(session('success'))
                <div class="mt-4 p-2.5 border border-gray-300 bg-gray-100 text-sm text-gray-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mt-4 p-2.5 border border-red-300 bg-red-50 text-sm text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(auth()->user()->role === 'Administrador')
                <form action="{{ route('equipos.store') }}" method="POST" class="mt-4 pt-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-2 text-sm">
                    @csrf
                    <input type="text" name="codigo" placeholder="Código (ej. PC-LAB2-01)" required class="border border-gray-300 rounded px-2.5 py-1.5">
                    <input type="text" name="descripcion" placeholder="Descripción" required class="border border-gray-300 rounded px-2.5 py-1.5">
                    <select name="estado" class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">
                        <option value="Disponible">Disponible</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                    </select>
                    <button type="submit" class="px-3 py-1.5 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">
                        Agregar Equipo
                    </button>
                </form>
            @endif
        </div>

        <div class="bg-white border border-gray-300 rounded p-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">
                {{ auth()->user()->role === 'Administrador' ? 'Inventario de Equipos' : 'Equipos Disponibles' }}
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2">Código</th>
                            <th class="border border-gray-300 px-3 py-2">Descripción</th>
                            <th class="border border-gray-300 px-3 py-2">Estado</th>
                            <th class="border border-gray-300 px-3 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipos as $eq)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2 font-medium">{{ $eq->codigo }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $eq->descripcion }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $eq->estado }}</td>
                                <td class="border border-gray-300 px-3 py-2 space-x-2">
                                    @if($eq->estado === 'Disponible' && auth()->user()->role === 'Estudiante')
                                        <form action="{{ route('equipos.reservar', $eq) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 bg-gray-900 text-white rounded text-xs hover:bg-gray-800 cursor-pointer">
                                                Reservar
                                            </button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->role === 'Administrador')
                                        <form action="{{ route('equipos.destroy', $eq) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="underline text-red-700 text-xs cursor-pointer" onclick="return confirm('¿Eliminar equipo?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-300 px-3 py-4 text-center text-gray-500">No hay equipos disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded p-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">
                {{ auth()->user()->role === 'Administrador' ? 'Todas las Reservaciones' : 'Mis Reservaciones' }}
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2">Folio</th>
                            <th class="border border-gray-300 px-3 py-2">Equipo</th>
                            @if(auth()->user()->role === 'Administrador')
                                <th class="border border-gray-300 px-3 py-2">Usuario</th>
                            @endif
                            <th class="border border-gray-300 px-3 py-2">Inicio</th>
                            <th class="border border-gray-300 px-3 py-2">Estado</th>
                            <th class="border border-gray-300 px-3 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservaciones as $res)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2">#{{ $res->id }}</td>
                                <td class="border border-gray-300 px-3 py-2 font-medium">{{ $res->equipo->codigo }}</td>
                                @if(auth()->user()->role === 'Administrador')
                                    <td class="border border-gray-300 px-3 py-2">{{ $res->usuario->name }}</td>
                                @endif
                                <td class="border border-gray-300 px-3 py-2 text-xs">{{ $res->fecha_inicio->format('d/m/Y H:i') }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $res->estado }}</td>
                                <td class="border border-gray-300 px-3 py-2">
                                    @if($res->estado === 'Activa')
                                        <form action="{{ route('reservaciones.cancelar', $res) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="underline text-red-700 text-xs cursor-pointer">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Sin reservaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>