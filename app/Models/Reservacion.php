<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    protected $table = 'reservaciones';

    protected $fillable = [
        'user_id',
        'equipo_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'datetime',
            'fecha_fin' => 'datetime',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}