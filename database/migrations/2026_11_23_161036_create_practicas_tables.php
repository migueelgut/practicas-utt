<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1.3 Sistema Académico[cite: 3]
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('faltas')->default(0);
            $table->decimal('calificacion', 4, 2)->default(0);
            $table->timestamps();
        });

        // 1.4 Gestión de Productos[cite: 5]
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('existencias')->default(0);
            $table->enum('estado', ['Disponible', 'Agotado'])->default('Disponible');
            $table->timestamps();
        });

        // 1.5 Reservación de Equipos[cite: 7]
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->enum('estado', ['Disponible', 'Ocupado', 'Mantenimiento'])->default('Disponible');
            $table->timestamps();
        });

        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_fin')->nullable();
            $table->enum('estado', ['Activa', 'Finalizada', 'Cancelada'])->default('Activa');
            $table->timestamps();
        });

        // 1.6 Juego del Gato (Tic-Tac-Toe)[cite: 9]
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jugador_x_id')->constrained('users');
            $table->foreignId('jugador_o_id')->nullable()->constrained('users');
            $table->string('tablero', 9)->default('---------');
            $table->enum('turno', ['X', 'O'])->default('X');
            $table->enum('estado', ['esperando', 'en_curso', 'ganador_x', 'ganador_o', 'empate', 'cancelada'])->default('esperando');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidas');
        Schema::dropIfExists('reservaciones');
        Schema::dropIfExists('equipos');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('calificaciones');
    }
};