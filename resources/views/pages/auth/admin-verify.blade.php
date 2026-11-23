<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    @include('partials.head')
    <title>Verificación de Administrador</title>
</head>
<body class="min-h-screen bg-white antialiased dark:bg-zinc-950 flex items-center justify-center p-6">
    <div class="w-full max-w-sm flex flex-col gap-6">
        <div class="flex flex-col items-center gap-2 text-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium">
                <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
            </a>
            <h1 class="text-xl font-semibold text-zinc-900 dark:text-white">Verificación de Administrador</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ingresa el código de 6 dígitos enviado a tu correo. Expira en 5 minutos.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.2fa.verify') }}" class="flex flex-col gap-5">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Código de verificación
                </label>
                <input id="code" type="text" name="code" maxlength="6" required autofocus
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white px-3 py-2.5 text-center text-2xl tracking-[0.5em] font-mono focus:outline-none focus:ring-2 focus:ring-zinc-500"
                    placeholder="000000">
                @error('code')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-zinc-900 text-white py-2.5 font-medium hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200 transition">
                Verificar y Acceder
            </button>
        </form>
    </div>
</body>
</html>