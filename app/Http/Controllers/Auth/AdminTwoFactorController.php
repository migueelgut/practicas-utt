<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTwoFactorController extends Controller
{
    public function show(Request $request)
    {
        // Bloquear si no completó la etapa 1
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('pages.auth.admin-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Sesión de verificación no válida.']);
        }

        $user = User::findOrFail($userId);

        // Validar código y vigencia máxima de 5 minutos
        if ($user->two_factor_code !== $request->code || now()->greaterThan($user->two_factor_expires_at)) {
            return back()->withErrors(['code' => 'El código es incorrecto o ha expirado (límite de 5 minutos).']);
        }

        // Limpiar código y completar acceso
        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        session()->forget('2fa_user_id');
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}