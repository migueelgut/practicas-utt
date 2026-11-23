<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    <title>Verificación de Administrador</title>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4 text-gray-800">
    <div class="w-full max-w-sm bg-white border border-gray-300 rounded p-6">
        <h1 class="text-lg font-bold text-gray-900">Verificación en 2 Pasos</h1>
        <p class="text-sm text-gray-600 mt-1 mb-5">
            Ingresa el código de 6 dígitos enviado a tu correo. Expira en 5 minutos.
        </p>

        <form method="POST" action="{{ route('admin.2fa.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium mb-1">Código de verificación</label>
                <input id="code" type="text" name="code" maxlength="6" required autofocus
                    class="w-full border border-gray-300 rounded px-3 py-2 text-center text-xl tracking-widest"
                    placeholder="000000">
                @error('code')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded text-sm font-medium hover:bg-gray-800 cursor-pointer">
                Verificar
            </button>
        </form>
    </div>
</body>
</html>