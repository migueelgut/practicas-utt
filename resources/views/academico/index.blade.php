<x-layouts.app title="Sistema Académico">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Práctica 1.3: Sistema Académico</h1>
                <p class="text-sm text-slate-500">
                    Consulta de calificaciones, faltas y equivalencias automáticas. Rol: <strong class="text-emerald-800">{{ auth()->user()->role }}</strong>
                </p>
            </div>

            @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                <a href="{{ route('academico.create') }}"
                   class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-lg transition">
                    + Registrar Alumno
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
            <div class="flex flex-wrap items-center gap-2 mb-4 text-xs">
                <span class="font-semibold text-slate-600">Ordenar por:</span>
                <a href="{{ route('academico.index', ['sort' => 'nombre', 'dir' => ($sort === 'nombre' && $dir === 'asc') ? 'desc' : 'asc']) }}"
                   class="px-3 py-1.5 rounded border {{ $sort === 'nombre' ? 'bg-emerald-50 border-emerald-400 text-emerald-800 font-semibold' : 'bg-slate-50 border-slate-200 text-slate-700' }}">
                    Nombre ({{ $sort === 'nombre' ? strtoupper($dir) : 'ASC' }})
                </a>
                <a href="{{ route('academico.index', ['sort' => 'calificacion', 'dir' => ($sort === 'calificacion' && $dir === 'desc') ? 'asc' : 'desc']) }}"
                   class="px-3 py-1.5 rounded border {{ $sort === 'calificacion' ? 'bg-emerald-50 border-emerald-400 text-emerald-800 font-semibold' : 'bg-slate-50 border-slate-200 text-slate-700' }}">
                    Calificación ({{ $sort === 'calificacion' ? strtoupper($dir) : 'DESC' }})
                </a>
                <a href="{{ route('academico.index', ['sort' => 'faltas', 'dir' => ($sort === 'faltas' && $dir === 'desc') ? 'asc' : 'desc']) }}"
                   class="px-3 py-1.5 rounded border {{ $sort === 'faltas' ? 'bg-emerald-50 border-emerald-400 text-emerald-800 font-semibold' : 'bg-slate-50 border-slate-200 text-slate-700' }}">
                    Faltas ({{ $sort === 'faltas' ? strtoupper($dir) : 'DESC' }})
                </a>
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Nombre del Alumno</th>
                        <th class="px-4 py-3 text-center">Número de Faltas</th>
                        <th class="px-4 py-3 text-center">Calificación Numérica</th>
                        <th class="px-4 py-3 text-center">Equivalencia Alfabética</th>
                        @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                            <th class="px-4 py-3 text-right">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($registros as $reg)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $reg->alumno->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $reg->faltas }}</td>
                            <td class="px-4 py-3 text-center font-semibold">{{ number_format($reg->calificacion, 1) }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $badge = match($reg->equivalencia) {
                                        'AU' => 'bg-emerald-100 text-emerald-800',
                                        'DE' => 'bg-blue-100 text-blue-800',
                                        'SA' => 'bg-amber-100 text-amber-800',
                                        default => 'bg-red-100 text-red-800',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                    {{ $reg->equivalencia }}
                                </span>
                            </td>
                            @if(in_array(auth()->user()->role, ['Administrador', 'Profesor']))
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('academico.edit', $reg) }}" class="text-amber-600 hover:underline font-medium">Editar</a>
                                    <form action="{{ route('academico.destroy', $reg) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium" onclick="return confirm('¿Eliminar registro académico?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">No hay registros académicos capturados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>