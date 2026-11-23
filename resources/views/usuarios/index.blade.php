<x-layouts.app title="Gestión de Usuarios">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Práctica 1.2: Gestión de Usuarios</h1>
                <p class="text-sm text-slate-500">
                    Control de acceso por roles, Soft Deletes y eliminación permanente. Rol actual: <strong class="text-emerald-800">{{ auth()->user()->role }}</strong>
                </p>
            </div>
            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-sm font-semibold transition">
                + Nuevo Usuario
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($users as $u)
                        <tr class="{{ $u->trashed() ? 'bg-red-50/60 text-slate-400' : 'hover:bg-slate-50' }}">
                            <td class="px-4 py-3">{{ $u->id }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $u->name }}</td>
                            <td class="px-4 py-3">{{ $u->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($u->trashed())
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Deshabilitado (Soft Delete)</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Activo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if(!$u->trashed())
                                    <a href="{{ route('usuarios.show', $u) }}" class="text-blue-600 hover:underline font-medium">Ver</a>
                                    <a href="{{ route('usuarios.edit', $u) }}" class="text-amber-600 hover:underline font-medium">Editar</a>

                                    {{-- Botones de eliminación visibles ÚNICAMENTE para Administrador --}}
                                    @if(auth()->user()->role === 'Administrador')
                                        <form action="{{ route('usuarios.destroy', $u) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-orange-600 hover:underline font-medium" onclick="return confirm('¿Deshabilitar usuario (Soft Delete)?')">
                                                Deshabilitar
                                            </button>
                                        </form>
                                        <form action="{{ route('usuarios.force-delete', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-semibold" onclick="return confirm('¿Eliminar PERMANENTEMENTE de la base de datos?')">
                                                Eliminar Definitivo
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if(auth()->user()->role === 'Administrador')
                                        <form action="{{ route('usuarios.restore', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-emerald-700 hover:underline font-semibold">Restaurar</button>
                                        </form>
                                        <form action="{{ route('usuarios.force-delete', $u->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-medium" onclick="return confirm('¿Eliminar definitivamente?')">
                                                Eliminar Definitivo
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