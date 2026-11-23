<x-layouts.app title="Editar Calificación">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded p-6">
        <h1 class="text-lg font-bold text-gray-900 mb-1">Editar Calificación</h1>
        <p class="text-xs text-gray-500 mb-4">Alumno: {{ $academico->alumno->name }}</p>

        <form action="{{ route('academico.update', $academico) }}" method="POST" class="space-y-3 text-sm">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1">Faltas</label>
                <input type="number" name="faltas" min="0" max="100" value="{{ old('faltas', $academico->faltas) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('faltas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Calificación (0 a 10)</label>
                <input type="number" step="0.1" name="calificacion" min="0" max="10" value="{{ old('calificacion', $academico->calificacion) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('calificacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="px-4 py-1.5 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">Actualizar</button>
                <a href="{{ route('academico.index') }}" class="px-4 py-1.5 border border-gray-300 rounded hover:bg-gray-100">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.app>