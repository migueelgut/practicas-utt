<x-layouts.app title="Nuevo Usuario">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h1 class="text-xl font-bold text-slate-900 mb-4">Registrar Nuevo Usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Rol</label>
                <select name="role" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                    @foreach(['Administrador', 'Empleado', 'Profesor', 'Alumno', 'Estudiante', 'Jugador'] as $rol)
                        <option value="{{ $rol }}" {{ old('role') === $rol ? 'selected' : '' }}>{{ $rol }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-lg text-sm font-semibold hover:bg-emerald-800">
                    Guardar Usuario
                </button>
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>