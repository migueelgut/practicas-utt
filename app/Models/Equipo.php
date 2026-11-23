<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'codigo',
        'descripcion',
        'estado',
    ];

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }
}