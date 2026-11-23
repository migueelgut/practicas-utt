@props(['title' => 'Prácticas UTT'])

<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    <title>{{ $title }} - UTT</title>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 font-sans antialiased">
    <!-- Barra de navegación superior estilo Portal Universitario -->
    <nav class="bg-emerald-900 text-white shadow-md border-b-4 border-amber-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo y Título -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 font-bold text-lg tracking-tight">
                        <span class="bg-white text-emerald-900 px-2.5 py-1 rounded font-black text-sm">UTT</span>
                        <span>Aplicaciones Web</span>
                    </a>

                    <!-- Enlaces de las Prácticas -->
                    <div class="hidden md:flex items-center space-x-1 ml-6">
                        <a href="{{ route('dashboard') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                            Inicio
                        </a>

                        @if(in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                            <a href="{{ route('usuarios.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('usuarios.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                                1.2 Usuarios
                            </a>
                        @endif

                        @if(Route::has('academico.index') && in_array(auth()->user()->role, ['Administrador', 'Profesor', 'Alumno']))
                            <a href="{{ route('academico.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('academico.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                                1.3 Académico
                            </a>
                        @endif

                        @if(Route::has('productos.index') && in_array(auth()->user()->role, ['Administrador', 'Empleado']))
                            <a href="{{ route('productos.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('productos.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                                1.4 Productos
                            </a>
                        @endif

                        @if(Route::has('equipos.index') && in_array(auth()->user()->role, ['Administrador', 'Estudiante']))
                            <a href="{{ route('equipos.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('equipos.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                                1.5 Equipos
                            </a>
                        @endif

                        @if(Route::has('gato.index') && in_array(auth()->user()->role, ['Administrador', 'Jugador']))
                            <a href="{{ route('gato.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('gato.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/60' }}">
                                1.6 Gato
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Usuario y Cerrar Sesión -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold leading-none">{{ auth()->user()->name }}</p>
                        <span class="text-xs text-amber-300 font-medium">{{ auth()->user()->role }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-emerald-950 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded border border-emerald-700 transition cursor-pointer">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>