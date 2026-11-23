<x-layouts.app title="Gestión de Productos">
    <div class="bg-white border border-gray-300 rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Gestión de Productos</h1>
                <p class="text-xs text-gray-500">Rol: {{ auth()->user()->role }}</p>
            </div>

            @if(auth()->user()->role === 'Administrador')
                <a href="{{ route('productos.create') }}" class="px-3 py-1.5 bg-gray-900 text-white rounded text-sm hover:bg-gray-800">
                    Nuevo Producto
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-2.5 border border-gray-300 bg-gray-100 text-sm text-gray-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros, Ordenamiento y Paginación -->
        <form method="GET" action="{{ route('productos.index') }}" class="border border-gray-300 bg-gray-50 p-3 rounded mb-4 space-y-3 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2">
                <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Nombre..."
                       class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">

                <select name="categoria_id" class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">
                    <option value="">Categoría (Todas)</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>

                <input type="number" step="0.01" name="precio_min" value="{{ request('precio_min') }}" placeholder="Precio mín."
                       class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">

                <input type="number" step="0.01" name="precio_max" value="{{ request('precio_max') }}" placeholder="Precio máx."
                       class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">

                <select name="estado" class="border border-gray-300 rounded px-2.5 py-1.5 bg-white">
                    <option value="">Estado (Todos)</option>
                    <option value="Disponible" {{ request('estado') === 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Agotado" {{ request('estado') === 'Agotado' ? 'selected' : '' }}>Agotado</option>
                </select>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-gray-200 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-600">Ordenar:</span>
                    <select name="sort" class="border border-gray-300 rounded px-2 py-1 bg-white">
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Fecha</option>
                        <option value="nombre" {{ $sort === 'nombre' ? 'selected' : '' }}>Nombre</option>
                        <option value="precio" {{ $sort === 'precio' ? 'selected' : '' }}>Precio</option>
                        <option value="existencias" {{ $sort === 'existencias' ? 'selected' : '' }}>Existencias</option>
                    </select>

                    <select name="dir" class="border border-gray-300 rounded px-2 py-1 bg-white">
                        <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>

                    <span class="text-gray-600 ml-2">Por página:</span>
                    <select name="per_page" class="border border-gray-300 rounded px-2 py-1 bg-white">
                        @foreach([10, 15, 25, 50] as $cant)
                            <option value="{{ $cant }}" {{ $perPage == $cant ? 'selected' : '' }}>{{ $cant }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">
                        Filtrar
                    </button>
                    <a href="{{ route('productos.index') }}" class="px-3 py-1 border border-gray-300 bg-white rounded hover:bg-gray-100">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        <div class="mb-2 text-xs text-gray-600 flex justify-between">
            <span>Total de registros: <strong>{{ $productos->total() }}</strong></span>
            <span>Página <strong>{{ $productos->currentPage() }}</strong> de <strong>{{ $productos->lastPage() }}</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">ID</th>
                        <th class="border border-gray-300 px-3 py-2">Nombre</th>
                        <th class="border border-gray-300 px-3 py-2">Categoría</th>
                        <th class="border border-gray-300 px-3 py-2">Precio</th>
                        <th class="border border-gray-300 px-3 py-2">Existencias</th>
                        <th class="border border-gray-300 px-3 py-2">Estado</th>
                        <th class="border border-gray-300 px-3 py-2">Fecha</th>
                        @if(auth()->user()->role === 'Administrador')
                            <th class="border border-gray-300 px-3 py-2">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $prod)
                        <tr>
                            <td class="border border-gray-300 px-3 py-2">{{ $prod->id }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                <div class="font-medium text-gray-900">{{ $prod->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $prod->descripcion }}</div>
                            </td>
                            <td class="border border-gray-300 px-3 py-2">{{ $prod->categoria->nombre }}</td>
                            <td class="border border-gray-300 px-3 py-2">${{ number_format($prod->precio, 2) }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $prod->existencias }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $prod->estado }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-xs">{{ $prod->created_at->format('d/m/Y') }}</td>
                            @if(auth()->user()->role === 'Administrador')
                                <td class="border border-gray-300 px-3 py-2 space-x-2">
                                    <a href="{{ route('productos.edit', $prod) }}" class="underline text-gray-700">Editar</a>
                                    <form action="{{ route('productos.destroy', $prod) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="underline text-red-700 cursor-pointer" onclick="return confirm('¿Eliminar producto?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Sin resultados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</x-layouts.app>