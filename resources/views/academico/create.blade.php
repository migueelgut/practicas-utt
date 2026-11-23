<x-layouts.app title="Registrar Calificación">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h1 class="text-xl font-bold text-slate-900 mb-4">Registrar Calificación de Alumno</h1>

        <form action="{{ route('academico.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alumno</label>
                <select name="user_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                    <option value="">Selecciona un alumno...</option>
                    @foreach($alumnos as $al)
                        <option value="{{ $al->id }}">{{ $al->name }} ({{ $al->email }})</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Número de Faltas</label>
                <input type="number" name="faltas" min="0" max="100" value="{{ old('faltas', 0) }}" required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('faltas') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Calificación Numérica (0 a 10)</label>
                <input type="number" step="0.1" name="calificacion" min="0" max="10" value="{{ old('calificacion') }}" required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('calificacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-lg text-sm font-semibold hover:bg-emerald-800">
                    Guardar
                </button>
                <a href="{{ route('academico.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>