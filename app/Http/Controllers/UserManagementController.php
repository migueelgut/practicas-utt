<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        // El Administrador ve también los eliminados lógicamente (Soft Deletes) para poder restaurarlos
        $users = auth()->user()->role === 'Administrador'
            ? User::withTrashed()->latest()->get()
            : User::latest()->get();

        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Administrador,Empleado,Profesor,Alumno,Estudiante,Jugador',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado correctamente.');
    }

    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($usuario->id)],
            'role' => 'required|in:Administrador,Empleado,Profesor,Alumno,Estudiante,Jugador',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminación Lógica (Soft Delete) - Solo Administrador
    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes deshabilitar tu propio usuario activo.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario deshabilitado (Soft Delete).');
    }

    // Restaurar usuario eliminado lógicamente - Solo Administrador[cite: 3]
    public function restore($id)
    {
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado correctamente.');
    }

    // Eliminación Permanente (Force Delete) - Solo Administrador[cite: 3]
    public function forceDelete($id)
    {
        $usuario = User::withTrashed()->findOrFail($id);

        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar permanentemente tu propio usuario.');
        }

        $usuario->forceDelete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado permanentemente de la base de datos.');
    }
}