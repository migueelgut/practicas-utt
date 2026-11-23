<x-layouts.app title="Detalle de Usuario">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h1 class="text-xl font-bold text-slate-900 mb-4">Detalles del Usuario</h1>

        <div class="rounded-lg border border-slate-200 p-4 space-y-2.5 bg-slate-50 text-sm text-slate-700">
            <p><strong>ID:</strong> {{ $usuario->id }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p><strong>Correo:</strong> {{ $usuario->email }}</p>
            <p><strong>Rol asignado:</strong> {{ $usuario->role }}</p>
            <p><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mt-5">
            <a href="{{ route('usuarios.index') }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900">
                Volver al listado
            </a>
        </div>
    </div>
</x-layouts.app>