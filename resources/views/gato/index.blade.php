<x-layouts.app title="Juego del Gato">
    <div class="space-y-6">
        <div class="bg-white border border-gray-300 rounded p-6 flex justify-between items-center">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Juego del Gato (Tic-Tac-Toe)</h1>
                <p class="text-xs text-gray-500">Jugador: {{ auth()->user()->name }}</p>
            </div>

            @if(auth()->user()->role === 'Jugador')
                <form action="{{ route('gato.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-gray-900 text-white rounded text-sm hover:bg-gray-800 cursor-pointer">
                        Nueva Partida (X)
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="p-2.5 border border-gray-300 bg-gray-100 text-sm text-gray-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-300 rounded p-4">
                <h2 class="text-base font-bold text-gray-900 mb-3">Salas Disponibles (O)</h2>
                <div class="space-y-2 text-sm">
                    @forelse($partidasDisponibles as $disp)
                        <div class="p-2.5 border border-gray-300 bg-gray-50 rounded flex justify-between items-center">
                            <div>
                                <div class="font-medium">Partida #{{ $disp->id }}</div>
                                <div class="text-xs text-gray-500">Por: {{ $disp->jugadorX->name }}</div>
                            </div>
                            <form action="{{ route('gato.unirse', $disp) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 bg-gray-900 text-white rounded text-xs hover:bg-gray-800 cursor-pointer">
                                    Unirse
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500">No hay salas esperando rival.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-gray-300 rounded p-4 md:col-span-2">
                <h2 class="text-base font-bold text-gray-900 mb-3">
                    {{ auth()->user()->role === 'Administrador' ? 'Historial General de Partidas' : 'Mis Partidas' }}
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse border border-gray-300">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border border-gray-300 px-3 py-2">ID</th>
                                <th class="border border-gray-300 px-3 py-2">Jugador X</th>
                                <th class="border border-gray-300 px-3 py-2">Jugador O</th>
                                <th class="border border-gray-300 px-3 py-2">Estado</th>
                                <th class="border border-gray-300 px-3 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($misPartidas as $p)
                                <tr>
                                    <td class="border border-gray-300 px-3 py-2">#{{ $p->id }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $p->jugadorX->name }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $p->jugadorO?->name ?? 'Esperando...' }}</td>
                                    <td class="border border-gray-300 px-3 py-2 text-xs uppercase">{{ str_replace('_', ' ', $p->estado) }}</td>
                                    <td class="border border-gray-300 px-3 py-2 space-x-2">
                                        <a href="{{ route('gato.show', $p) }}" class="underline text-gray-800">Abrir</a>
                                        @if(in_array($p->estado, ['esperando', 'en_curso']))
                                            <form action="{{ route('gato.abandonar', $p) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="underline text-red-700 text-xs cursor-pointer">
                                                    {{ auth()->user()->role === 'Administrador' ? 'Cancelar' : 'Abandonar' }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-3 py-4 text-center text-gray-500 text-xs">Sin partidas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>