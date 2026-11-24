<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    <title>Iniciar Sesión - Prácticas UTT</title>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4 text-gray-800 antialiased">
    <div class="w-full max-w-sm bg-white border border-gray-300 rounded p-6">
        <div class="mb-5">
            <h1 class="text-lg font-bold text-gray-900">Iniciar Sesión</h1>
            <p class="text-xs text-gray-500 mt-0.5">Prácticas UTT — Ingresa tus credenciales</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-2.5 border border-gray-300 bg-gray-100 text-xs text-gray-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4 text-sm">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    placeholder="usuario@utt.edu.mx"
                    class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white focus:outline-none focus:border-gray-500">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded px-3 py-1.5 bg-white focus:outline-none focus:border-gray-500">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="inline-flex items-center gap-1.5 text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="border-gray-300 rounded">
                    <span>Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="underline text-gray-600 hover:text-gray-900">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded text-sm font-medium hover:bg-gray-800 cursor-pointer">
                Entrar
            </button>
        </form>

        @if (Route::has('register'))
            <div class="mt-4 pt-4 border-t border-gray-200 text-center text-xs text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="underline font-medium text-gray-900">Registrarse</a>
            </div>
        @endif
    </div>
</body>
</html>