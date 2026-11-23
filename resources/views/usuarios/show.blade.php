<x-layouts.app title="Detalle de Usuario">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded p-6 text-sm">
        <h1 class="text-lg font-bold text-gray-900 mb-4">Detalle de Usuario</h1>

        <div class="space-y-2 border-t border-b border-gray-200 py-3">
            <p><strong>ID:</strong> {{ $usuario->id }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p><strong>Correo:</strong> {{ $usuario->email }}</p>
            <p><strong>Rol:</strong> {{ $usuario->role }}</p>
            <p><strong>Registro:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('usuarios.index') }}" class="px-3 py-1.5 border border-gray-300 rounded hover:bg-gray-100">Volver</a>
        </div>
    </div>
</x-layouts.app>