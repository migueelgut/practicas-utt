<x-layouts.app title="Sistema Académico">
    <div class="bg-white border border-gray-300 rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Sistema Académico</h1>
                <p class="text-xs text-gray-500">Rol: {{ auth()->user()->role }}</p>
            </div>

            @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                <a href="{{ route('academico.create') }}" class="px-3 py-1.5 bg-gray-900 text-white rounded text-sm hover:bg-gray-800">
                    Registrar Calificación
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-2.5 border border-gray-300 bg-gray-100 text-sm text-gray-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
            <div class="flex items-center gap-2 mb-4 text-xs">
                <span class="text-gray-600">Ordenar:</span>
                <a href="{{ route('academico.index', ['sort' => 'nombre', 'dir' => ($sort === 'nombre' && $dir === 'asc') ? 'desc' : 'asc']) }}"
                   class="px-2.5 py-1 border border-gray-300 rounded {{ $sort === 'nombre' ? 'bg-gray-200 font-semibold' : 'bg-white' }}">
                    Nombre ({{ $sort === 'nombre' ? strtoupper($dir) : 'ASC' }})
                </a>
                <a href="{{ route('academico.index', ['sort' => 'calificacion', 'dir' => ($sort === 'calificacion' && $dir === 'desc') ? 'asc' : 'desc']) }}"
                   class="px-2.5 py-1 border border-gray-300 rounded {{ $sort === 'calificacion' ? 'bg-gray-200 font-semibold' : 'bg-white' }}">
                    Calificación ({{ $sort === 'calificacion' ? strtoupper($dir) : 'DESC' }})
                </a>
                <a href="{{ route('academico.index', ['sort' => 'faltas', 'dir' => ($sort === 'faltas' && $dir === 'desc') ? 'asc' : 'desc']) }}"
                   class="px-2.5 py-1 border border-gray-300 rounded {{ $sort === 'faltas' ? 'bg-gray-200 font-semibold' : 'bg-white' }}">
                    Faltas ({{ $sort === 'faltas' ? strtoupper($dir) : 'DESC' }})
                </a>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">Alumno</th>
                        <th class="border border-gray-300 px-3 py-2">Faltas</th>
                        <th class="border border-gray-300 px-3 py-2">Calificación</th>
                        <th class="border border-gray-300 px-3 py-2">Equivalencia</th>
                        @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                            <th class="border border-gray-300 px-3 py-2">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $reg)
                        <tr>
                            <td class="border border-gray-300 px-3 py-2">{{ $reg->alumno->name }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $reg->faltas }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ number_format($reg->calificacion, 1) }}</td>
                            <td class="border border-gray-300 px-3 py-2 font-semibold">{{ $reg->equivalencia }}</td>
                            @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                                <td class="border border-gray-300 px-3 py-2 space-x-2">
                                    <a href="{{ route('academico.edit', $reg) }}" class="underline text-gray-700">Editar</a>
                                    <form action="{{ route('academico.destroy', $reg) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="underline text-red-700 cursor-pointer" onclick="return confirm('¿Eliminar registro?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>