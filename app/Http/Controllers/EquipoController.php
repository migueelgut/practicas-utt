<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'Administrador') {
            $equipos = Equipo::orderBy('codigo')->get();
            $reservaciones = Reservacion::with(['usuario', 'equipo'])->latest()->get();
        } else {
            // Estudiante: ve equipos disponibles y ÚNICAMENTE sus propias reservaciones
            $equipos = Equipo::where('estado', 'Disponible')->orderBy('codigo')->get();
            $reservaciones = Reservacion::with('equipo')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('equipos.index', compact('equipos', 'reservaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:equipos,codigo',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|in:Disponible,Ocupado,Mantenimiento',
        ]);

        Equipo::create($request->only('codigo', 'descripcion', 'estado'));
        return back()->with('success', 'Equipo registrado correctamente.');
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|in:Disponible,Ocupado,Mantenimiento',
        ]);

        $equipo->update($request->only('descripcion', 'estado'));
        return back()->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return back()->with('success', 'Equipo eliminado.');
    }

    public function reservar(Equipo $equipo)
    {
        try {
            DB::transaction(function () use ($equipo) {
                $equipoBloqueado = Equipo::where('id', $equipo->id)->lockForUpdate()->first();

                if ($equipoBloqueado->estado !== 'Disponible') {
                    throw new \Exception('El equipo ya fue reservado por otro usuario o no está disponible.');
                }

                Reservacion::create([
                    'user_id' => auth()->id(),
                    'equipo_id' => $equipoBloqueado->id,
                    'fecha_inicio' => now(),
                    'estado' => 'Activa',
                ]);

                $equipoBloqueado->update(['estado' => 'Ocupado']);
            });

            return back()->with('success', "Equipo {$equipo->codigo} reservado correctamente.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelar(Reservacion $reservacion)
    {
        $user = auth()->user();

        if ($user->role !== 'Administrador' && $reservacion->user_id !== $user->id) {
            abort(403, 'No tienes permiso para cancelar reservaciones de otro usuario.');
        }

        if ($reservacion->estado !== 'Activa') {
            return back()->with('error', 'Solo se pueden cancelar reservaciones activas.');
        }

        DB::transaction(function () use ($reservacion) {
            $reservacion->update([
                'estado' => 'Cancelada',
                'fecha_fin' => now(),
            ]);

            $reservacion->equipo()->update(['estado' => 'Disponible']);
        });

        return back()->with('success', 'Reservación cancelada y equipo liberado.');
    }
}