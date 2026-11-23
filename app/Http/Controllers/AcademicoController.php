<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // El Alumno únicamente consulta su propia información académica
        if ($user->role === 'Alumno') {
            $registros = Calificacion::with('alumno')->where('user_id', $user->id)->get();
            return view('academico.index', compact('registros'));
        }

        // Profesor o Administrador: consulta ordenada por nombre, calificación o faltas
        $sort = $request->get('sort', 'nombre');
        $dir = $request->get('dir', 'asc') === 'desc' ? 'desc' : 'asc';

        $query = Calificacion::query()
            ->join('users', 'calificaciones.user_id', '=', 'users.id')
            ->select('calificaciones.*');

        if ($sort === 'calificacion') {
            $query->orderBy('calificaciones.calificacion', $dir);
        } elseif ($sort === 'faltas') {
            $query->orderBy('calificaciones.faltas', $dir);
        } else {
            $query->orderBy('users.name', $dir);
        }

        $registros = $query->with('alumno')->get();

        return view('academico.index', compact('registros', 'sort', 'dir'));
    }

    public function create()
    {
        $alumnos = User::where('role', 'Alumno')
            ->whereDoesntHave('calificacion')
            ->get();

        return view('academico.create', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::unique('calificaciones', 'user_id')],
            'faltas' => 'required|integer|min:0|max:100',
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        Calificacion::create($request->only('user_id', 'faltas', 'calificacion'));

        return redirect()->route('academico.index')->with('success', 'Registro académico guardado correctamente.');
    }

    public function edit(Calificacion $academico)
    {
        return view('academico.edit', compact('academico'));
    }

    public function update(Request $request, Calificacion $academico)
    {
        $request->validate([
            'faltas' => 'required|integer|min:0|max:100',
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $academico->update($request->only('faltas', 'calificacion'));

        return redirect()->route('academico.index')->with('success', 'Calificación y faltas actualizadas.');
    }

    public function destroy(Calificacion $academico)
    {
        $academico->delete();
        return redirect()->route('academico.index')->with('success', 'Registro eliminado.');
    }
}