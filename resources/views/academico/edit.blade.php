<x-layouts.app title="Editar Calificación">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Actualizar Registro Académico</h1>
        <p class="text-sm text-slate-500 mb-4">Alumno: <strong>{{ $academico->alumno->name }}</strong></p>

        <form action="{{ route('academico.update', $academico) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Número de Faltas</label>
                <input type="number" name="faltas" min="0" max="100" value="{{ old('faltas', $academico->faltas) }}" required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('faltas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Calificación Numérica (0 a 10)</label>
                <input type="number" step="0.1" name="calificacion" min="0" max="10" value="{{ old('calificacion', $academico->calificacion) }}" required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('calificacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-semibold hover:bg-amber-700">
                    Actualizar
                </button>
                <a href="{{ route('academico.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>