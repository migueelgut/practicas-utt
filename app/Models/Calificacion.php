<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'user_id',
        'faltas',
        'calificacion',
    ];

    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Equivalencia alfabética automática (Práctica 1.3)
    public function getEquivalenciaAttribute(): string
    {
        $nota = (float) $this->calificacion;

        if ($nota < 7.0) {
            return 'NA';
        }
        if ($nota < 8.0) {
            return 'SA';
        }
        if ($nota < 9.0) {
            return 'DE';
        }

        return 'AU';
    }
}