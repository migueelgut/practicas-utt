<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            ['name' => 'Ana Alumno', 'email' => 'ana@utt.edu.mx', 'role' => 'Alumno'],
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

        $miguel = User::where('email', 'alumno@utt.edu.mx')->first();
        $ana = User::where('email', 'ana@utt.edu.mx')->first();
        Calificacion::create(['user_id' => $miguel->id, 'faltas' => 1, 'calificacion' => 9.5]);
        Calificacion::create(['user_id' => $ana->id, 'faltas' => 3, 'calificacion' => 8.2]);

        $catBebidas = Categoria::create(['nombre' => 'Bebidas']);
        $catAlimentos = Categoria::create(['nombre' => 'Alimentos']);
        $catPostres = Categoria::create(['nombre' => 'Postres']);

        for ($i = 1; $i <= 15; $i++) {
            Producto::create([
                'nombre' => "Producto #{$i}",
                'descripcion' => "Descripción del producto {$i}.",
                'categoria_id' => [$catBebidas->id, $catAlimentos->id, $catPostres->id][$i % 3],
                'precio' => 15 + ($i * 5),
                'existencias' => $i % 4 === 0 ? 0 : $i * 3,
                'estado' => $i % 4 === 0 ? 'Agotado' : 'Disponible',
            ]);
        }

        DB::table('equipos')->insert([
            ['codigo' => 'PC-LAB1-01', 'descripcion' => 'Dell OptiPlex i7 - 16GB RAM', 'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'PC-LAB1-02', 'descripcion' => 'Dell OptiPlex i7 - 16GB RAM', 'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'PC-LAB1-03', 'descripcion' => 'HP ProDesk Ryzen 5 - 16GB RAM', 'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'PC-LAB1-04', 'descripcion' => 'iMac 24" M3', 'estado' => 'Mantenimiento', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}