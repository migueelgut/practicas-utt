<x-layouts.app title="Inicio">
    <div class="bg-white border border-gray-300 rounded p-6">
        <h1 class="text-xl font-bold text-gray-900">Panel Principal</h1>
        <p class="text-sm text-gray-600 mt-1">
            Usuario: <strong>{{ auth()->user()->name }}</strong> | Rol: <strong>{{ auth()->user()->role }}</strong>
        </p>

        <hr class="my-4 border-gray-200">

        <p class="text-sm text-gray-700 mb-3">Módulos disponibles según tu rol:</p>
        <ul class="list-disc list-inside text-sm text-gray-800 space-y-1.5">
            @if(in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                <li><a href="{{ route('usuarios.index') }}" class="underline hover:text-black">Práctica 1.2 - Gestión de Usuarios</a></li>
            @endif
            @if(Route::has('academico.index') && in_array(auth()->user()->role, ['Administrador', 'Profesor', 'Alumno']))
                <li><a href="{{ route('academico.index') }}" class="underline hover:text-black">Práctica 1.3 - Sistema Académico</a></li>
            @endif
            @if(Route::has('productos.index') && in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                <li><a href="{{ route('productos.index') }}" class="underline hover:text-black">Práctica 1.4 - Gestión de Productos</a></li>
            @endif
            @if(Route::has('equipos.index') && in_array(auth()->user()->role, ['Administrador', 'Estudiante']))
                <li><a href="{{ route('equipos.index') }}" class="underline hover:text-black">Práctica 1.5 - Reservación de Equipos</a></li>
            @endif
            @if(Route::has('gato.index') && in_array(auth()->user()->role, ['Administrador', 'Jugador']))
                <li><a href="{{ route('gato.index') }}" class="underline hover:text-black">Práctica 1.6 - Juego del Gato</a></li>
            @endif
        </ul>
    </div>
</x-layouts.app>