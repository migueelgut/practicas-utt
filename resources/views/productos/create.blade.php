<x-layouts.app title="Nuevo Producto">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded p-6">
        <h1 class="text-lg font-bold text-gray-900 mb-4">Registrar Producto</h1>

        <form action="{{ route('productos.store') }}" method="POST" class="space-y-3 text-sm">
            @csrf
            <div>
                <label class="block mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('nombre') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Descripción</label>
                <textarea name="descripcion" rows="2" required class="w-full border border-gray-300 rounded px-3 py-1.5">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">Categoría</label>
                    <select name="categoria_id" required class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white">
                        <option value="">Seleccionar...</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1">Estado</label>
                    <select name="estado" required class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white">
                        <option value="Disponible" {{ old('estado') === 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Agotado" {{ old('estado') === 'Agotado' ? 'selected' : '' }}>Agotado</option>
                    </select>
                    @error('estado') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">Precio</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                    @error('precio') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1">Existencias</label>
                    <input type="number" name="existencias" value="{{ old('existencias', 0) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                    @error('existencias') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="px-4 py-1.5 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">Guardar</button>
                <a href="{{ route('productos.index') }}" class="px-4 py-1.5 border border-gray-300 rounded hover:bg-gray-100">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.app>