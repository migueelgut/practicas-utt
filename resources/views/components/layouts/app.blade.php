@props(['title' => 'Prácticas UTT'])

<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    <title>{{ $title }}</title>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <header class="bg-white border-b border-gray-300">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="font-bold text-gray-900">
                    Prácticas UTT
                </a>

                <nav class="flex items-center gap-4 text-sm">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                        Inicio
                    </a>

                    @if(in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                        <a href="{{ route('usuarios.index') }}"
                           class="{{ request()->routeIs('usuarios.*') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                            1.2 Usuarios
                        </a>
                    @endif

                    @if(Route::has('academico.index') && in_array(auth()->user()->role, ['Administrador', 'Profesor', 'Alumno']))
                        <a href="{{ route('academico.index') }}"
                           class="{{ request()->routeIs('academico.*') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                            1.3 Académico
                        </a>
                    @endif

                    @if(Route::has('productos.index') && in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                        <a href="{{ route('productos.index') }}"
                           class="{{ request()->routeIs('productos.*') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                            1.4 Productos
                        </a>
                    @endif

                    @if(Route::has('equipos.index') && in_array(auth()->user()->role, ['Administrador', 'Estudiante']))
                        <a href="{{ route('equipos.index') }}"
                           class="{{ request()->routeIs('equipos.*') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                            1.5 Equipos
                        </a>
                    @endif

                    @if(Route::has('gato.index') && in_array(auth()->user()->role, ['Administrador', 'Jugador']))
                        <a href="{{ route('gato.index') }}"
                           class="{{ request()->routeIs('gato.*') ? 'font-semibold text-black underline' : 'text-gray-600 hover:text-black' }}">
                            1.6 Gato
                        </a>
                    @endif
                </nav>
            </div>

            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-600">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-100 text-gray-800 cursor-pointer">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>