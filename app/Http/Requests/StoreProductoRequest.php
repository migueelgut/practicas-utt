<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'Administrador';
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|gt:0',
            'existencias' => 'required|integer|min:0',
            'estado' => 'required|in:Disponible,Agotado',
        ];
    }
}