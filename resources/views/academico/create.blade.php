<x-layouts.app title="Registrar Calificación">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded p-6">
        <h1 class="text-lg font-bold text-gray-900 mb-4">Registrar Calificación</h1>

        <form action="{{ route('academico.store') }}" method="POST" class="space-y-3 text-sm">
            @csrf
            <div>
                <label class="block mb-1">Alumno</label>
                <select name="user_id" required class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white">
                    <option value="">Selecciona un alumno...</option>
                    @foreach($alumnos as $al)
                        <option value="{{ $al->id }}">{{ $al->name }} ({{ $al->email }})</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Faltas</label>
                <input type="number" name="faltas" min="0" max="100" value="{{ old('faltas', 0) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('faltas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Calificación (0 a 10)</label>
                <input type="number" step="0.1" name="calificacion" min="0" max="10" value="{{ old('calificacion') }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('calificacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="px-4 py-1.5 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">Guardar</button>
                <a href="{{ route('academico.index') }}" class="px-4 py-1.5 border border-gray-300 rounded hover:bg-gray-100">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.app>