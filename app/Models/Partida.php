<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $fillable = [
        'jugador_x_id',
        'jugador_o_id',
        'tablero',
        'turno',
        'estado',
    ];

    public function jugadorX()
    {
        return $this->belongsTo(User::class, 'jugador_x_id');
    }

    public function jugadorO()
    {
        return $this->belongsTo(User::class, 'jugador_o_id');
    }
}