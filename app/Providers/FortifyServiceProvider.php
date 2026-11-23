<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redirigir directo a /login al cerrar sesión
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect()->route('login');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => view('pages.auth.login'));
        Fortify::registerView(fn () => view('pages.auth.register'));
        Fortify::requestPasswordResetLinkView(fn () => view('pages.auth.forgot-password'));
        Fortify::resetPasswordView(fn (Request $request) => view('pages.auth.reset-password', ['request' => $request]));
        Fortify::confirmPasswordView(fn () => view('pages.auth.confirm-password'));

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Autenticación por rol: 3 etapas para Administrador y directa para Empleado[cite: 1, 2]
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->role === 'Administrador') {
                    $code = (string) rand(100000, 999999);
                    $user->update([
                        'two_factor_code' => $code,
                        'two_factor_expires_at' => now()->addMinutes(5),
                    ]);

                    session(['2fa_user_id' => $user->id]);

                    Mail::raw("Tu código de verificación de Administrador es: {$code}. Expira en 5 minutos.", function ($msg) use ($user) {
                        $msg->to($user->email)->subject('Código de Verificación - Administrador');
                    });

                    $signedUrl = URL::temporarySignedRoute('admin.2fa.show', now()->addMinutes(5));
                    abort(redirect($signedUrl));
                }

                return $user;
            }

            return null;
        });
    }
}