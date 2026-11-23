<x-layouts.app title="Editar Usuario">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded p-6">
        <h1 class="text-lg font-bold text-gray-900 mb-4">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-3 text-sm">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Correo</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Rol</label>
                <select name="role" class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white">
                    @foreach(['Administrador', 'Empleado', 'Profesor', 'Alumno', 'Estudiante', 'Jugador'] as $rol)
                        <option value="{{ $rol }}" {{ old('role', $usuario->role) === $rol ? 'selected' : '' }}>{{ $rol }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-1.5">
                @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded px-3 py-1.5">
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="px-4 py-1.5 bg-gray-900 text-white rounded hover:bg-gray-800 cursor-pointer">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="px-4 py-1.5 border border-gray-300 rounded hover:bg-gray-100">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.app>