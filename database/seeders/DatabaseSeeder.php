<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin UTT', 'email' => 'admin@utt.edu.mx', 'role' => 'Administrador'],
            ['name' => 'Empleado Uno', 'email' => 'empleado@utt.edu.mx', 'role' => 'Empleado'],
            ['name' => 'Profe Kenneth', 'email' => 'profesor@utt.edu.mx', 'role' => 'Profesor'],
            ['name' => 'Miguel Alumno', 'email' => 'alumno@utt.edu.mx', 'role' => 'Alumno'],
            ['name' => 'Miguel Estudiante', 'email' => 'estudiante@utt.edu.mx', 'role' => 'Estudiante'],
            ['name' => 'Jugador Uno', 'email' => 'jugador1@utt.edu.mx', 'role' => 'Jugador'],
            ['name' => 'Jugador Dos', 'email' => 'jugador2@utt.edu.mx', 'role' => 'Jugador'],
        ];

        foreach ($roles as $u) {
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make('password'),
                'role' => $u['role'],
            ]);
        }
    }
}